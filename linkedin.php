<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed


if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
    $protocol = 'http';
}
$baseurl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$lnkdn_id = '';
$lnkdn_secret = '';
$lnkdn_token = '';

$linkedIn = new Happyr\LinkedIn\LinkedIn($lnkdn_id, $lnkdn_secret);

if($_GET['auth-status'] == 'success' &&  $_GET['auth-from'] == 'linkedin'){
	echo 'Linkedin successfully!';
}elseif ($segments[1] == 'linkedin') {

	$access_token = $linkedIn->getAccessToken();
	$token = $access_token->getToken();
	header('Location: '.$baseurl.'?auth-status=success&auth-from=linkedin');
}


$params = ['redirect_uri' => $baseurl."linkedin",];
$linkedin_login = $linkedIn->getLoginUrl($params);
header('Location: '.$linkedin_login);
