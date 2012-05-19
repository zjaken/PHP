<?php
require_once 'google-api-php-client/src/apiClient.php';
require_once 'google-api-php-client/src/contrib/apiPlusService.php';
session_start();

$client = new apiClient();
$client->setApplicationName('Z_Calendar');
// Visit https://code.google.com/apis/console?api=plus to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('711042418195-he14vufkp6bn0a2529qcpga1i9s8rcbe.apps.googleusercontent.com');
$client->setClientSecret('AN5v-xOO-LfF9_Aoz1-JAGTl');
$client->setRedirectUri('https://localhost/oauth2callback');
$client->setDeveloperKey('AIzaSyBuTzO_EOrvM4Xx3Yq5J-IgJrq9pGU-GjM');


$plus = new apiPlusService($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
  $activities = $plus->activities->listActivities('me', 'public');
  print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';

  // The access token may have been updated.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a href='$authUrl'>Connect Me!</a>";
}