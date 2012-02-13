<?php
/**
/* This code verifies that the authorization succeded. 
**/

//Include libraries
require('../facebook.php');
require('../appengine_functions.php');

//Initialize Facebook's PHP library
$config = array(
  'appId'  => '140229329376512',
  'secret' => '198fb6f72dfb3a029d410d98e3beb203',
  'cookie' => true,
  'domain' => true
);

$facebook_client = new Facebook($config);

//Initialize variables
$app_id          = $facebook_client->getAppId();
$app_secret      = $facebook_client->getApiSecret();
$CANVAS_URL = 'http://apps.facebook.com/russ_myfirstapp/';

//Get the access token from Facebook by supplying the App ID & Secret.
$params=array('client_id'=>$app_id, 'type'=>'client_cred', 'client_secret'=>$app_secret);
$url = "https://graph.facebook.com/oauth/access_token";
$access_token = make_request($url, $params); // creates a POST request with $params as the parameters.
$access_token = substr($access_token, strpos($access_token, "=")+1, strlen($access_token));

//If the access token is not present, something went wrong 
//so display an error, else, redirect to canvas page.
if($access_token){
  header('Location: ' . $CANVAS_URL);
}else{
  echo 'An error occurred';
}
exit;
?>
