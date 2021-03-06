<?php
/*
 *	$Id: wsdlclient2.php,v 1.3 2007/11/06 14:48:49 snichol Exp $
 *
 *	WSDL client sample.
 *
 *	Service: WSDL proxy
 *	Payload: rpc/encoded
 *	Transport: http
 *	Authentication: none
 */
require_once('../lib/nusoap.php');
$proxyHost = isset($_POST['proxyHost']) ? $_POST['proxyHost'] : '';
$proxyPort = isset($_POST['proxyPort']) ? $_POST['proxyPort'] : '';
$proxyUsername = isset($_POST['proxyUsername']) ? $_POST['proxyUsername'] : '';
$proxyPassword = isset($_POST['proxyPassword']) ? $_POST['proxyPassword'] : '';
$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
$client = new nusoap_client("http://soap.amazon.com/schemas2/AmazonWebServices.wsdl", 'wsdl',
						$proxyHost, $proxyPort, $proxyUsername, $proxyPassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
	exit();
}
$client->setUseCurl($useCURL);
$param = array(
	'browse_node' => 18,
	'page' => 1,
	'mode' => 'books',
	'tag' =>'melonfire-20',
	'type' => 'lite',
	'devtag' => 'Your dev tag'
);
$result = $client->BrowseNodeSearchRequest($param);
// Check for a fault
if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';