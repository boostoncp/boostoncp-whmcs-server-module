<?php
/**
 * BoostonCP Global Hooks - ROBUST MULTI-LOGIN INJECTION
 */

use Illuminate\Database\Capsule\Manager as Capsule;

add_hook('AdminAreaFooterOutput', 1, function($vars) {
    if ($vars['filename'] !== 'clientsservices') return '';

    $serviceId = (int)$_REQUEST['id'];
    if (!$serviceId) return '';

    // Verify BoostonCP service
    try {
        $service = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->where('tblhosting.id', $serviceId)
            ->select('tblproducts.servertype')
            ->first();

        if (!$service || $service->servertype !== 'boostoncp') return '';
    } catch (\Exception $e) { return ''; }

    // Use relative path from WHMCS Admin to Modules
    $userLoginUrl = "modules/servers/boostoncp/redirect.php?id=" . $serviceId;
    $adminLoginUrl = "modules/servers/boostoncp/redirect.php?id=" . $serviceId . "&type=admin";

    return "
    <script type='text/javascript'>
    $(document).ready(function() {
        // Target the context button container
        var btnBar = $('.context-btn-container');
        if (btnBar.length === 0) btnBar = $('.module-buttons');

        if (btnBar.length && $('#booston-multi-login-v2').length === 0) {
            var buttons = '<div id=\"booston-multi-login-v2\" style=\"display:inline-flex; gap:10px; margin-right:15px; vertical-align:middle;\">' +
                '<a href=\"" . $userLoginUrl . "\" target=\"_blank\" class=\"btn btn-primary\" style=\"background: linear-gradient(135deg, #0061ff 0%, #60efff 100%) !important; border:none; font-weight:800; color:white !important; border-radius:4px; padding:7px 15px; box-shadow: 0 4px 10px rgba(0, 97, 255, 0.3);\"><i class=\"fas fa-user-shield me-1\"></i> Login to User Account</a>' +
                '<a href=\"" . $adminLoginUrl . "\" target=\"_blank\" class=\"btn btn-dark\" style=\"background:#1e293b; border:none; font-weight:800; color:white !important; border-radius:4px; padding:7px 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);\"><i class=\"fas fa-tools me-1\"></i> Master Admin</a>' +
                '</div>';
            
            btnBar.prepend(buttons);
        }
    });
    </script>";
});

// Hook to dynamically inject the Server Port input field and hide unused fields on configservers.php
add_hook('AdminAreaFooterOutput', 2, function($vars) {
    if ($vars['filename'] !== 'configservers' && strpos($_SERVER['SCRIPT_NAME'], 'configservers.php') === false) {
        return '';
    }

    $serverId = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
    $currentPort = 2087; // default

    if ($serverId > 0) {
        try {
            $server = Capsule::table('tblservers')->where('id', $serverId)->first();
            if ($server && !empty($server->port)) {
                $currentPort = (int)$server->port;
            }
        } catch (\Exception $e) {}
    }

    return "
    <script type='text/javascript'>
    (function($) {
        $(document).ready(function() {
            var secureRow = $('input[name=\"secure\"]').closest('tr');
            if (secureRow.length > 0 && $('#booston-port-row').length === 0) {
                var portHtml = '<tr id=\"booston-port-row\">' +
                    '<td class=\"fieldlabel\">Server Port</td>' +
                    '<td class=\"fieldarea\">' +
                    '<input type=\"text\" name=\"port\" value=\"" . $currentPort . "\" class=\"form-control input-150\" style=\"width:150px; display:inline-block;\">' +
                    '<span class=\"help-inline\" style=\"margin-left:10px;\">Specify custom port for BoostonCP connection (Default: 2087)</span>' +
                    '</td>' +
                    '</tr>';
                secureRow.after(portHtml);
            }

            
            // Helper to parse nameserver and hostname details from raw response text and fill input fields
            function handleResponse(msg) {
                if (msg && msg.indexOf('CONNECTION SUCCESSFUL') !== -1) {
                    var hostnameMatch = msg.match(/HOSTNAME:\s*([^\s\r\n<\"\\#]+)/i);
                    var ipMatch = msg.match(/IP:\s*([^\s\r\n<\"\\#]+)/i);
                    var ns1Match = msg.match(/NS1:\s*([^\s\r\n<\"\\#]+)/i);
                    var ns1ipMatch = msg.match(/NS1IP:\s*([^\s\r\n<\"\\#]+)/i);
                    var ns2Match = msg.match(/NS2:\s*([^\s\r\n<\"\\#]+)/i);
                    var ns2ipMatch = msg.match(/NS2IP:\s*([^\s\r\n<\"\\#]+)/i);
                    
                    if (hostnameMatch && hostnameMatch[1]) $('input[name=\"hostname\"]').val(hostnameMatch[1]);
                    if (ipMatch && ipMatch[1]) $('input[name=\"ipaddress\"]').val(ipMatch[1]);
                    if (ns1Match && ns1Match[1]) $('input[name=\"ns1\"]').val(ns1Match[1]);
                    if (ns1ipMatch && ns1ipMatch[1]) $('input[name=\"ns1ip\"]').val(ns1ipMatch[1]);
                    if (ns2Match && ns2Match[1]) $('input[name=\"ns2\"]').val(ns2Match[1]);
                    if (ns2ipMatch && ns2ipMatch[1]) $('input[name=\"ns2ip\"]').val(ns2ipMatch[1]);
                }
            }

            // Hook native XMLHttpRequest
            (function() {
                var open = XMLHttpRequest.prototype.open;
                XMLHttpRequest.prototype.open = function() {
                    this.addEventListener("readystatechange", function() {
                        if (this.readyState === 4 && this.status === 200) {
                            var responseText = this.responseText || '';
                            if (responseText.indexOf('CONNECTION SUCCESSFUL') !== -1) {
                                handleResponse(responseText);
                            }
                        }
                    }, false);
                    open.apply(this, arguments);
                };
            })();

            // Hook native fetch API
            (function() {
                var originalFetch = window.fetch;
                if (originalFetch) {
                    window.fetch = function() {
                        return originalFetch.apply(this, arguments).then(function(response) {
                            response.clone().text().then(function(text) {
                                if (text && text.indexOf('CONNECTION SUCCESSFUL') !== -1) {
                                    handleResponse(text);
                                }
                            });
                            return response;
                        });
                    };
                }
            })();
        });
    })(jQuery);
    </script>";
});
?>