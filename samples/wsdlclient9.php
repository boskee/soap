<?php
/*
 *	$Id: wsdlclient9.php,v 1.2 2007/11/06 14:50:06 snichol Exp $
 *
 *	WSDL client sample.
 *
 *	Service: WSDL
 *	Payload: document/literal
 *	Transport: http
 *	Authentication: digest
 */
require_once('../lib/nusoap.php');
$proxyHost = isset($_POST['proxyHost']) ? $_POST['proxyHost'] : '';
$proxyPort = isset($_POST['proxyPort']) ? $_POST['proxyPort'] : '';
$proxyUsername = isset($_POST['proxyUsername']) ? $_POST['proxyUsername'] : '';
$proxyPassword = isset($_POST['proxyPassword']) ? $_POST['proxyPassword'] : '';
echo 'You must set your username and password in the source';
exit();
$client = new nusoap_client("http://staging.mappoint.net/standard-30/mappoint.wsdl", 'wsdl',
						$proxyHost, $proxyPort, $proxyUsername, $proxyPassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$client->setCredentials($username, $password, 'digest');
$client->useHTTPPersistentConnection();
$view = array(
	'Height' => 200,
	'Width' => 300,
	'CenterPoint' => array(
		'Latitude' => 40,
		'Longitude' => -120
	)
);
$myViews[] = new soapval('MapView', 'ViewByHeightWidth', $view, false, 'http://s.mappoint.net/mappoint-30/');
$mapSpec = array(
	'DataSourceName' => "MapPoint.NA",
	'Views' => array('MapView' => $myViews)
);
$map = array('specification' => $mapSpec);
$result = $client->call('GetMap', array('parameters' => $map));
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
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
