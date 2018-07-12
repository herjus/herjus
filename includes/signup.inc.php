<?php 
include '../class/user.class.php';
session_start();
function fixString($string){
        return $result = ucwords(mb_strtolower($string));
    }

if(isset($_POST['submit']))
{
	$user = new User;
	if(!empty(htmlspecialchars(fixString($_POST['first'])))) $user->setFirst(htmlspecialchars(fixString($_POST['first'])));
	if(!empty(htmlspecialchars(fixString($_POST['last'])))) $user->setLast(htmlspecialchars(fixString($_POST['last'])));
	if(!empty(htmlspecialchars(fixString($_POST['uid'])))) $user->setUid(htmlspecialchars(fixString($_POST['uid'])));
	if(!empty(htmlspecialchars(fixString($_POST['email'])))) $user->setEmail(htmlspecialchars(fixString($_POST['email'])));
	if(!empty(htmlspecialchars(fixString($_POST['gender'])))) $user->setGender($_POST['gender']);
	
	$pwd = htmlspecialchars($_POST['pwd']);
	$pwdr = htmlspecialchars($_POST['pwdr']);


    if(empty($user->user_first) || empty($user->user_last) || empty($user->user_uid) || empty($pwd) || empty($pwdr) || empty($user->user_email))
    {
    	header("Location: ../signup.php?signup=empty&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
		exit();
    }
    else
	{
		if($pwd !== $pwdr)
		{
			header("Location: ../signup.php?signup=passwordmm&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
			exit();
		}
		else
		{
			if(strlen($pwd) <= 7)
			{
				header("Location: ../signup.php?signup=passwordshort&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
				exit();
			}
			else
			{
				if(!preg_match("/^[a-yA-Y]*$/", $user->user_first) || !preg_match("/^[a-yA-Y]*$/", $user->user_last))
				{
					header("Location: ../signup.php?signup=char&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
					exit();
				}
				else
				{
					if(!filter_var($user->user_email, FILTER_VALIDATE_EMAIL))
					{
						header("Location: ../signup.php?signup=invalidemail&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
						exit();
					}
					else
					{
						$signup = $user->signup($user->user_first, $user->user_last, $user->user_uid, $pwd, $pwdr, $user->user_email, $user->user_gender);

						if($signup == "usernametaken")  
						{
							header("Location: ../signup.php?signup=usernametaken&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
						}
						elseif($signup == "emailtaken")  
						{
							header("Location: ../signup.php?signup=emailtaken&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
						}
						elseif($signup == "uidemailtaken")  
						{
							header("Location: ../signup.php?signup=uidemailtaken&first=$user->user_first&last=$user->user_last&uid=$user->user_uid&email=$user->user_email&gender=$user->user_gender");
						}
						elseif($signup == "success")
						{

							header("Location: ../signup.php?signup=success");
			                exit();
						}
						else
						{
							header("Location: ../signup.php?signup=unknownerror&&msg=".$signup);
						}
					}	
				}
			}
		}	
	}
}
else
{
	header("Location: ..signup.php");
	exit();
}