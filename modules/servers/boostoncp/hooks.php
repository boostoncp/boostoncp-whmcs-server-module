<?php
/**
 * BoostonCP WHMCS Hooks - EXTREME ROBUST INJECTION
 */

use Illuminate\Database\Capsule\Manager as Capsule;

add_hook('AdminAreaFooterOutput', 1, function($vars) {
    $serviceId = 0;
    if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
        $serviceId = (int)$_REQUEST['id'];
    } elseif (isset($_REQUEST['userid']) && $_REQUEST['userid'] > 0) {
        $userId = (int)$_REQUEST['userid'];
        try {
            $firstService = Capsule::table('tblhosting')
                ->where('userid', $userId)
                ->orderBy('id', 'asc')
                ->first();
            if ($firstService) {
                $serviceId = $firstService->id;
            }
        } catch (\Exception $e) {}
    }

    if (!$serviceId || strpos($_SERVER['SCRIPT_NAME'], 'clientsservices.php') === false) {
        return '';
    }

    // Verify BoostonCP service using Capsule
    try {
        $service = Capsule::table('tblhosting')
            ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
            ->where('tblhosting.id', $serviceId)
            ->select('tblproducts.servertype')
            ->first();

        if (!$service || $service->servertype !== 'boostoncp') {
            return '';
        }
    } catch (\Exception $e) {
        return ''; // Silent fail on DB error
    }

    // Prepare Links (Relative to WHMCS Admin)
    $userLoginUrl = "../modules/servers/boostoncp/redirect.php?id=" . $serviceId;
    $adminLoginUrl = "../modules/servers/boostoncp/redirect.php?id=" . $serviceId . "&type=admin";

    // HTML Payload
    $html = '<tr id=\"booston-admin-section\">' .
            '<td class=\"fieldlabel\">BoostonCP Access</td>' .
            '<td class=\"fieldarea\">' .
            '<div style=\"display:flex; gap:10px; align-items:center;\">' .
            '<a href=\"' . $userLoginUrl . '\" target=\"_blank\" class=\"btn btn-primary\" style=\"background: linear-gradient(135deg, #0061ff 0%, #60efff 100%) !important; border:none; font-weight:800; color:white !important; padding:6px 18px; border-radius:4px; box-shadow: 0 4px 12px rgba(0,97,255,0.3);\"><i class=\"fas fa-user-shield me-1\"></i> Login to User Account</a>' .
            '<a href=\"' . $adminLoginUrl . '\" target=\"_blank\" class=\"btn btn-dark\" style=\"background:#1e293b; border:none; font-weight:800; color:white !important; padding:6px 18px; border-radius:4px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);\"><i class=\"fas fa-tools me-1\"></i> Master Admin</a>' .
            '</div>' .
            '</td>' .
            '</tr>';

    return "
    <script type='text/javascript'>
    (function($) {
        function tryInjectBooston() {
            if ($('#booston-admin-section').length > 0) return;
            
            // Search for 'Module Commands' row by searching for text content in <td>
            var targetRow = $('td').filter(function() {
                return $(this).text().trim() === 'Module Commands';
            }).closest('tr');
            
            if (targetRow.length > 0) {
                targetRow.after('" . $html . "');
            } else {
                // Fallback: try to find by ID if the text search fails
                var lastFieldRow = $('.fieldarea').last().closest('tr');
                if (lastFieldRow.length > 0) {
                    lastFieldRow.after('" . $html . "');
                }
            }
        }
        
        $(document).ready(function() {
            tryInjectBooston();
            // Retry a few times in case of dynamic UI loading
            setTimeout(tryInjectBooston, 500);
            setTimeout(tryInjectBooston, 1500);
            setTimeout(tryInjectBooston, 3000);
        });
    })(jQuery);
    </script>";
});

// Hook to dynamically inject the Server Port input field on configservers.php
add_hook('AdminAreaFooterOutput', 2, function($vars) {
    if (strpos($_SERVER['SCRIPT_NAME'], 'configservers.php') === false) {
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