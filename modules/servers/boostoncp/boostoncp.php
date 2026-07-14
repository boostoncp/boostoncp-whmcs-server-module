<?php
/**
 * BoostonCP WHMCS Server Module
 * Version: 1.6.5 (Stable)
 */

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use Illuminate\Database\Capsule\Manager as Capsule;

function boostoncp_MetaData() {
    return array(
        'DisplayName' => 'BoostonCP',
        'APIVersion' => '1.1',
        'RequiresServer' => true,
        'ServiceSingleSignOn' => true,
        'AdminSingleSignOn' => true,
        'ListAccountsSupported' => true,
    );
}

function boostoncp_ConfigOptions($params) {
    $packages = array("" => "-- Select Package --");
    $host = $params['serverhostname'] ? $params['serverhostname'] : $params['serverip'];
    $apiKey = $params['serveraccesshash'];

    if (empty($host) || empty($apiKey)) {
        try {
            $serverId = 0;
            if (isset($_REQUEST['servergroup']) && $_REQUEST['servergroup'] > 0) {
                $serverRel = Capsule::table('tblservergroupsrel')->where('groupid', $_REQUEST['servergroup'])->first();
                if ($serverRel) $serverId = $serverRel->serverid;
            } elseif (isset($_REQUEST['server']) && $_REQUEST['server'] > 0) {
                $serverId = $_REQUEST['server'];
            }
            if ($serverId > 0) {
                $server = Capsule::table('tblservers')->where('id', $serverId)->first();
                if ($server) {
                    $params['serverip'] = $server->ipaddress;
                    $params['serverhostname'] = $server->hostname;
                    $params['serveraccesshash'] = $server->accesshash;
                    $params['serversecure'] = $server->secure;
                }
            }
        } catch (\Exception $e) { } // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedDuringDeprecationAnalysis
    }

    $result = boostoncp_call_api($params, 'list_packages');
    if (isset($result['status']) && $result['status'] === 'success' && is_array($result['packages'])) {
        foreach ($result['packages'] as $pkg) {
            $packages[$pkg['id']] = $pkg['name'];
        }
    }

    return array(
        "package_id" => array(
            "FriendlyName" => "BoostonCP Package",
            "Type" => "dropdown",
            "Options" => $packages,
            "Description" => "Select the BoostonCP hosting plan.",
        ),
        "client_template" => array(
            "FriendlyName" => "Client Area Design",
            "Type" => "dropdown",
            "Options" => array(
                "premium_blue_design" => "Premium Blue (Modern - Default)",
                "original_design" => "BoostonCP (Original)",
                "alien_neon_design" => "Interstellar (Alien Neon)",
            ),
            "Default" => "premium_blue_design",
            "Description" => "Choose the look of the client dashboard.",
        ),
    );
}

function boostoncp_call_api($params, $action, $postData = array()) {
    $host = $params['serverhostname'] ? $params['serverhostname'] : $params['serverip'];
    $port = $params['serverport'] ? $params['serverport'] : '2087';
    
    // Parse custom port from hostname or IP if specified (e.g. 1.2.3.4:8087)
    if (strpos($host, ':') !== false) {
        $parts = explode(':', $host);
        $host = $parts[0];
        $port = $parts[1];
    }
    
    // Auto-detect protocol: Respect the Secure checkbox setting
    // Auto-detect protocol: Default to HTTPS (SSL) unless explicitly disabled, ensuring Simple Mode wizard works out of the box
    $protocol = 'https';
    if (isset($params['serversecure']) && ($params['serversecure'] === 'off' || $params['serversecure'] === false || $params['serversecure'] === 0 || $params['serversecure'] === '0')) {
        $protocol = 'http';
    }

    $apiKey = trim($params['serveraccesshash']);

    if (empty($apiKey)) return array('status' => 'error', 'message' => 'Missing API Key');

    $url = "$protocol://$host:$port/api/whmcs.php?action=$action&api_key=" . urlencode($apiKey);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Safety check for IP based HTTPS to avoid SSL errors
    if (filter_var($host, FILTER_VALIDATE_IP) && $protocol === 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    } else {
        // Default to secure settings for hostname or HTTP connections
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // Verify hostname matching
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'BoostonCP-API');

    if (!empty($postData)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    }

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) return array('status' => 'error', 'message' => "CURL Error: $error");
    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : array('status' => 'error', 'message' => 'Invalid Response');
}

function boostoncp_TestConnection($params) {
    $result = boostoncp_call_api($params, 'test');
    if ($result['status'] === 'success') {
        $msg = "CONNECTION SUCCESSFUL!\n";
        $msg .= "HOSTNAME: " . ($result['hostname'] ?? '') . "\n";
        
        $serverIp = $params['serverip'] ? $params['serverip'] : ($params['serverhostname'] ? gethostbyname($params['serverhostname']) : '');
        $msg .= "IP: " . $serverIp . "\n";
        
        $ns1 = $result['nameservers'][0] ?? '';
        $ns2 = $result['nameservers'][1] ?? '';
        
        $ns1ip = '';
        $ns2ip = '';
        
        if (!empty($ns1)) {
            $msg .= "NS1: " . $ns1 . "\n";
            $resolvedIp = gethostbyname($ns1);
            if ($resolvedIp !== $ns1 && filter_var($resolvedIp, FILTER_VALIDATE_IP)) {
                $ns1ip = $resolvedIp;
            }
            $msg .= "NS1IP: " . $ns1ip . "\n";
        }
        if (!empty($ns2)) {
            $msg .= "NS2: " . $ns2 . "\n";
            $resolvedIp = gethostbyname($ns2);
            if ($resolvedIp !== $ns2 && filter_var($resolvedIp, FILTER_VALIDATE_IP)) {
                $ns2ip = $resolvedIp;
            }
            $msg .= "NS2IP: " . $ns2ip . "\n";
        }
        
        return array(
            'success' => true,
            'message' => $msg,
            'hostname' => $result['hostname'] ?? '',
            'ipaddress' => $serverIp,
            'ns1' => $ns1,
            'ns1ip' => $ns1ip,
            'ns2' => $ns2,
            'ns2ip' => $ns2ip,
        );
    }
    return array('error' => $result['message']);
}

function boostoncp_CreateAccount($params) {
    $postData = array('username' => $params['username'], 'password' => $params['password'], 'email' => $params['clientsdetails']['email'], 'domain' => $params['domain'], 'package_id' => $params['configoption1']);
    $result = boostoncp_call_api($params, 'create', $postData);
    return ($result['status'] === 'success') ? 'success' : $result['message'];
}

function boostoncp_SuspendAccount($params) {
    $result = boostoncp_call_api($params, 'suspend', array('username' => $params['username']));
    return ($result['status'] === 'success') ? 'success' : $result['message'];
}

function boostoncp_UnsuspendAccount($params) {
    $result = boostoncp_call_api($params, 'unsuspend', array('username' => $params['username']));
    return ($result['status'] === 'success') ? 'success' : $result['message'];
}

function boostoncp_TerminateAccount($params) {
    $result = boostoncp_call_api($params, 'terminate', array('username' => $params['username']));
    return ($result['status'] === 'success') ? 'success' : $result['message'];
}

function boostoncp_AdminCustomButtonArray() {
    return array("Re-sync Resources" => "ResyncResources", "Manual Sync Accounts" => "ListAccounts");
}

function boostoncp_ResyncResources($params) {
    $result = boostoncp_call_api($params, 'resync', array('username' => $params['username']));
    return ($result['status'] === 'success') ? 'success' : $result['message'];
}

function boostoncp_ClientArea($params) {
    try {
        $result = boostoncp_call_api($params, 'user_login', array('username' => $params['username']));
        $loginUrl = ($result['status'] === 'success') ? $result['login_url'] : '#';
        $template = !empty($params['configoption2']) ? $params['configoption2'] : 'premium_blue_design';
        return array('templatefile' => $template, 'vars' => array('login_url' => $loginUrl, 'api_error' => ($result['status'] !== 'success' ? $result['message'] : ''), 'domain' => $params['domain'], 'serverip' => $params['serverip']));
    } catch (\Exception $e) { return ""; } // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedDuringDeprecationAnalysis
}

function boostoncp_AdminLink($params) {
    $result = boostoncp_call_api($params, 'admin_login');
    if (isset($result['status']) && $result['status'] === 'success' && !empty($result['login_url'])) {
        return '<a href="'.$result['login_url'].'" target="_blank" class="btn btn-default">Log in to BoostonCP</a>';
    } else {
        // Fallback to direct link if API fails
        $host = $params['serverhostname'] ? $params['serverhostname'] : $params['serverip'];
        $port = $params['serverport'] ? $params['serverport'] : '2087';
        
        if (strpos($host, ':') !== false) {
            $parts = explode(':', $host);
            $host = $parts[0];
            $port = $parts[1];
        }
        
        $protocol = $params['serversecure'] ? 'https' : 'http';
        return '<a href="'.$protocol.'://'.$host.':'.$port.'/" target="_blank" class="btn btn-default">Log in to BoostonCP (Manual)</a>';
    }
}

function boostoncp_UsageUpdate($params) {
    $result = boostoncp_call_api($params, 'get_stats');
    if (isset($result['status']) && $result['status'] === 'success') {
        // WHMCS expects an array where keys match the server's metrics
        return array(
            'accounts' => (int)$result['total_accounts'],
        );
    }
    return false;
}

function boostoncp_ListAccounts($params) {
    $result = boostoncp_call_api($params, 'list_users');
    $accounts = array();
    if (isset($result['status']) && $result['status'] === 'success' && is_array($result['accounts'])) {
        foreach ($result['accounts'] as $acc) {
            $accounts[] = array(
                'username' => $acc['username'],
                'domain' => $acc['domain'],
                'email' => $acc['email'],
                'status' => $acc['status'],
                'created' => $acc['created'],
            );
        }
    }
    return $accounts;
}

function boostoncp_AdminServicesTabFields($params) {
    $result = boostoncp_call_api($params, 'get_stats');
    $fields = array();
    if (isset($result['status']) && $result['status'] === 'success') {
        $fields['Server Statistics'] = '<b>Active Accounts:</b> ' . $result['active_accounts'] . '<br><b>Suspended:</b> ' . $result['suspended_accounts'];
    }
    return $fields;
}

function boostoncp_ServiceSingleSignOn($params) {
    if (empty($params['username'])) {
        return array(
            'success' => false,
            'errorMsg' => 'Username is missing. Cannot generate login URL.',
        );
    }
    
    // API call to generate a one-time login token for the specific user
    $result = boostoncp_call_api($params, 'user_login', array('username' => $params['username']));

    if (isset($result['status']) && $result['status'] === 'success' && !empty($result['login_url'])) {
        return array(
            'success' => true,
            'redirectTo' => $result['login_url'],
        );
    }

    return array(
        'success' => false,
        'errorMsg' => $result['message'] ?? 'Failed to generate single sign-on URL from API.',
    );
}

?>
