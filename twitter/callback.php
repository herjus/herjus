<?php 
session_start();

require 'autoload.php';
require 'twitterkeys.php';
include_once '../class/user.class.php';

use Abraham\TwitterOAuth\TwitterOAuth;

if(isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token'])
{
	$request_token = [];
	$request_token['oauth_token'] = $_SESSION['oauth_token'];
	$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
	$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
	$_SESSION['access_token'] = $access_token;
	
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$user = $connection->get("account/verify_credentials");

	$userClass = new User;
	/*foreach($user as $key=>$item)
	{
		if(is_string($item)) echo '<br>'.$key. " - : ". $item;
		else {print_r($item); echo '<br>';}
	}*/
	$handler = $userClass->twitterHandler($user->screen_name);
	header('Location: ../index.php?'.$handler);
}
else
{
	header('Location: ../index.php?twitter=error');
}


