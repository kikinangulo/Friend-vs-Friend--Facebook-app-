<?php
//Include libraries
require('facebook.php');

//Initializing variables
$client_id    = '140229329376512';
$display      = 'page';
$redirect_url = 'http://nic4eve.appspot.com/authorize/'; //where should Facebook redirect after authorization?
$scope        = 'publish_stream'; //what permissions does the user need to grant your app?
$oauth_url    = 'https://graph.facebook.com/oauth/authorize?' . 
										'client_id='     . $client_id .
										'&redirect_uri=' . $redirect_url .
										'&type='         . 'user_agent' .
										'&display='      . $display . 
										'&scope='        . $scope;

//Initializing Facebook's PHP library
$config = array(
 'appId'  => '140229329376512',
 'secret' => '198fb6f72dfb3a029d410d98e3beb203',
 'cookie' => true,
 'domain' => true
);

$facebook_client = new Facebook($config);

//Grab the user's session
$session = $facebook_client->getSession();

/*If session does not exist, the user is not loggedin or hasn't added the app
so redirect them to the authorize page.*/
if(!$session){
 $text = "<script type=\"text/javascript\">\ntop.location.href = \"$oauth_url\";\n</script>";
 echo $text;
 exit;
}

$access_token = $session['access_token'];
$params = array('access_token'=> $access_token);

try{
$me = $facebook_client->api('/me',$params);
$friends = $facebook_client->api('/me/friends',$params);

$friend = $friends['data'];
$random1 = rand(1,count($friend));
$random2 = rand(1,count($friend));
}
catch(FacebookApiException $e){
error_log($e);
}
//var_dump($friend);
//If the session exists, the user has logged in so display the app's contents.


echo '<h1><b><center>"F vs F"
<table>
<caption>
	<h1>who is hotter?????</h1>
</caption>
	
<tr size=20>
	<td></td>
	<td><img src="https://graph.facebook.com/'.$friend[$random1]["id"].'/picture?type=large" alt="myself" width="125" height="150"/></td>
	<td>"VS"</td>
	<td><img src="https://graph.facebook.com/'.$friend[$random2]["id"].'/picture?type=large" alt="myself"  width="125" height="150"/></td>
	<td></td>
	
<tr>
	<td></td>
	<td><input type="button" value="'.$friend[$random1]["name"].'"</td>
	<td></td>
	<td><input type="button" value="'.$friend[$random2]["name"].'"</td>
	<td></td>
	</table>
	</h1></center></b>';

?>