<?php 
session_start();
include '../class/user.class.php';

if(isset($_POST['submit']))
{
	$button = $_POST['submit'];
	if(isset($_POST['origin'])) $origin = htmlspecialchars($_POST['origin']);
	else $origin = "index";

	if($button == "changepwd")
	{
		$id = $_SESSION['u_id'];
		

		if(empty($_POST['pwd']) || empty($_POST['pwdnew'])|| empty($_POST['pwdnewr']))
		{
			header("Location: ../profile.php?form=empty");
		}
		else
		{
			$pwd = htmlspecialchars($_POST['pwd']);
			$pwdnew = htmlspecialchars($_POST['pwdnew']);
			$pwdnewr = htmlspecialchars($_POST['pwdnewr']);

			$user = new User;
			$changepwd = $user->changepwd($pwd, $pwdnew, $pwdnewr);

			header("Location: ../profile.php?form=$changepwd");
		}
	}
	elseif($button == "login")
	{
		$uid = htmlspecialchars($_POST['uid']);
		$pwd = htmlspecialchars($_POST['pwd']);
		
		if(empty($uid) || empty($pwd))
		{
			header("Location: ../index.php?login=empty?origin=".$origin);
			exit();
		}
		else
		{
			$user = new User;
			$login = $user->login($uid, $pwd);
			
			if($login == "success")
			{
				header("Location: ../".$origin.".php?login=".$login);
			}
			else
			{
				header("Location: ../index.php?login=".$login."=".$origin);
			}
		}
	}
	elseif($button == 'requestpwd')
	{
		$pwd = $_POST['pwd'];

		if(empty($pwd))
		{
			header("Location: ../profile.php?requestpwd=empty");
		}
		else
		{
			$user = new User;
			$pwdhash = $user->requestpwd($pwd);

			header("Location: ../profile.php?requestpwd=$pwdhash");
		}
	}
	elseif($button == "signup")
	{
		$user = new User;
		if(!empty(htmlspecialchars(fixString($_POST['first'])))) $user->setFirst(htmlspecialchars(fixString($_POST['first'])));
		if(!empty(htmlspecialchars(fixString($_POST['last'])))) $user->setLast(htmlspecialchars(fixString($_POST['last'])));
		if(!empty(htmlspecialchars(fixString($_POST['uid'])))) $user->setUid(htmlspecialchars(fixString($_POST['uid'])));
		if(!empty(htmlspecialchars(fixString($_POST['email'])))) $user->setEmail(htmlspecialchars(fixString($_POST['email'])));
		$user->setGender($_POST['gender']);
		$origin = htmlentities($_POST['origin']);
		$pwd = htmlspecialchars($_POST['pwd']);
		$pwdr = htmlspecialchars($_POST['pwdr']);



	    if(empty($user->user_first) || empty($user->user_last) || empty($user->user_uid) || empty($pwd) || empty($pwdr) || empty($user->user_email))
	    {
	    	header("Location: ../signup.php?signup=empty&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
			exit();
	    }
	    else
		{
			if($pwd !== $pwdr)
			{
				header("Location: ../signup.php?signup=passwordmm&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
				exit();
			}
			else
			{
				if(strlen($pwd) <= 7)
				{
					header("Location: ../signup.php?signup=passwordshort&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
					exit();
				}
				else
				{
					if(!preg_match("/^[a-yA-Y]*$/", $user->user_first) || !preg_match("/^[a-yA-Y]*$/", $user->user_last))
					{
						header("Location: ../signup.php?signup=char&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
						exit();
					}
					else
					{
						if(!filter_var($user->user_email, FILTER_VALIDATE_EMAIL))
						{
							header("Location: ../signup.php?signup=invalidemail&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
							exit();
						}
						else
						{
							$signup = $user->signup($user->user_first, $user->user_last, $user->user_uid, $pwd, $pwdr, $user->user_email, $user->user_gender);
							
							if($signup == "success")
							{
								header("Location: ../$origin.php?signup=success");
				                exit();
							}
							else
							{
								header("Location: ../signup.php?signup=$signup&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender&&origin=$origin");
							}
						}	
					}
				}
			}	
		}
	}
	elseif($button == "logout")
	{
		session_unset();
		session_destroy();
		header("Location: ../index.php?logout=success");
		exit();
	}
	elseif($button == "deletetwitter")
	{
		$user = new User;
		$delete = $user->twDelete();
		header("Location: ../profile.php?logout=".$delete);
		exit();
	}
	else header("Location: ../$origin.php?buttonerror=".$button);
}
