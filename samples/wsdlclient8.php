<?php
/*
 *	$Id: wsdlclient8.php,v 1.2 2007/11/06 14:49:10 snichol Exp $
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
$address = array(
	'AddressLine' => '563 Park Avenue',
	'PrimaryCity' => 'New York',
	'SecondaryCity' => 'Brooklyn',
	'Subdivision' => '',
	'PostalCode' => '',
	'CountryRegion' => 'US',
	'FormattedAddress' => ''
);
$findRange = array(
	'StartIndex' => 0,
	'Count' => 10
);
$findResultMask = 'AddressFlag';
$findOptions = array(
	'Range' => $findRange,
	'SearchContext' => 1,
	'ResultMask' => $findResultMask,
	'ThresholdScore' => 0.85
);
$findAddressSpecification = array(
	'DataSourceName' => 'MapPoint.NA',
	'InputAddress' => $address,
	'Options' => $findOptions
);
$findAddress = array('specification' => $findAddressSpecification);
$result = $client->call('FindAddress', array('parameters' => $findAddress));
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
