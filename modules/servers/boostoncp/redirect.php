<?php
/**
 * BoostonCP Admin Redirect Bridge
 */
require("../../../init.php");

use Illuminate\Database\Capsule\Manager as Capsule;

$id = (int)$_REQUEST['id'];
if (!$id) die("Missing Service ID.");

$type = $_REQUEST['type'] ?? 'user'; // 'user' or 'admin'

// Get Service Details
$service = Capsule::table('tblhosting')
    ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
    ->join('tblservers', 'tblhosting.server', '=', 'tblservers.id')
    ->where('tblhosting.id', $id)
    ->select('tblhosting.userid', 'tblhosting.username', 'tblservers.ipaddress', 'tblservers.hostname', 'tblservers.accesshash', 'tblservers.secure', 'tblservers.port')
    ->first();

if (!$service) die("Service not found.");

// Authentication & Authorization Check
$adminId = $_SESSION['adminid'] ?? 0;
$clientId = $_SESSION['uid'] ?? 0;

if ($type === 'admin') {
    // Master admin access requires active admin session
    if (!$adminId) {
        die("Unauthorized access: WHMCS Admin session required.");
    }
} else {
    // User login requires ownership OR admin login
    $isOwner = ((int)$service->userid === (int)$clientId);
    if (!$isOwner && !$adminId) {
        die("Unauthorized access: You do not have permission to access this service.");
    }
}

// Prepare API Call
$host = $service->hostname ? $service->hostname : $service->ipaddress;
$port = $service->port ? $service->port : '2087';

if (strpos($host, ':') !== false) {
    $parts = explode(':', $host);
    $host = $parts[0];
    $port = $parts[1];
}

$protocol = $service->secure ? 'https' : 'http';
$apiKey = trim($service->accesshash);

// Select Action based on type
$action = ($type === 'admin') ? 'admin_login' : 'user_login';

$url = "$protocol://$host:$port/api/whmcs.php?action=$action&api_key=" . urlencode($apiKey);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['username' => $service->username]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);

if (isset($data['status']) && $data['status'] === 'success' && !empty($data['login_url'])) {
    header("Location: " . $data['login_url']);
    exit;
} else {
    echo "Login Error: " . ($data['message'] ?? 'Unable to connect to BoostonCP API.');
}
?>