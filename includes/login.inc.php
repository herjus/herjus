<?php 
include '../class/user.class.php';

if(isset($_POST['submit']))
{
	$uid = htmlspecialchars($_POST['uid']);
	$pwd = htmlspecialchars($_POST['pwd']);
	if(isset($_POST['link'])) $link = htmlspecialchars($_POST['link']);
	else $link = "index";
	if(empty($uid) || empty($pwd))
	{
		header("Location: ../index.php?login=empty?link=".$link);
		exit();
	}
	else
	{
		$user = new User;
		$login = $user->login($uid, $pwd);
		
		if($login == "success")
		{
			header("Location: ../".$link.".php?login=".$login);
			exit();
		}
		else
		{
			header("Location: ../index.php?login=".$login."?".$link);
			exit();
		}
	}
}
else
{
	header("Location: ../index.php?login=".$login);
	exit();
}