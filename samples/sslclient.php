<?php
/*
 *	$Id: sslclient.php,v 1.1 2004/01/09 03:23:42 snichol Exp $
 *
 *	SSL client sample.
 *
 *	Service: SOAP endpoint
 *	Payload: rpc/encoded
 *	Transport: https
 *	Authentication: none
 */
require_once('../lib/nusoap.php');
$proxyHost = isset($_POST['proxyHost']) ? $_POST['proxyHost'] : '';
$proxyPort = isset($_POST['proxyPort']) ? $_POST['proxyPort'] : '';
$proxyUsername = isset($_POST['proxyUsername']) ? $_POST['proxyUsername'] : '';
$proxyPassword = isset($_POST['proxyPassword']) ? $_POST['proxyPassword'] : '';
$client = new soapclient('https://arcweb.esri.com/services/v2/AddressFinder', false,
						$proxyHost, $proxyPort, $proxyUsername, $proxyPassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$result = $client->call('getVersion', array(), 'http://arcweb.esri.com/v2', 'getVersion');
if ($client->fault) {
	echo '<h2>Fault</h2><pre>'; print_r($result); echo '</pre>';
} else {
	$err = $client->getError();
	if ($err) {
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
