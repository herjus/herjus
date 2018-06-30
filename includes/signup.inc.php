<?php 
session_start();
function fixString($string){
        return $result = ucwords(strtolower($string));
    }

if(isset($_POST['submit']))
{
	include_once 'dbh.inc.php';
	$first = mysqli_real_escape_string($conn, fixString($_POST['first']));
    $last = mysqli_real_escape_string($conn, fixString($_POST['last']));
    $uid = mysqli_real_escape_string($conn, fixString($_POST['uid']));
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$pwdr = mysqli_real_escape_string($conn, $_POST['pwdr']);
    $email = mysqli_real_escape_string($conn, fixString($_POST['email']));
    $gender = $_POST['gender'];


    if(empty($first) || empty($last) || empty($uid) || empty($pwd) || empty($pwdr) || empty($email))
    {
    	header("Location: ../signup.php?signup=empty&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
		exit();
    }
    else
	{
		if($pwd !== $pwdr)
		{
			header("Location: ../signup.php?signup=passwordmm&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
			exit();
		}
		else
		{
			if(strlen($pwd) <= 7)
			{
				header("Location: ../signup.php?signup=passwordshort&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
				exit();
			}
			else
			{
				if(!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last))
				{
					header("Location: ../signup.php?signup=char&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
					exit();
				}
				else
				{
					if(!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						header("Location: ../signup.php?signup=invalidemail&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
						exit();
					}
					else
					{

						$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?;";
						$stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql))
                        {
                            echo "Failure: SQL statement failed. Select query";
                        }
                        else
                        {
                            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            
                            $resultsCheck = mysqli_num_rows($result);
                            if($resultsCheck > 0)
                            {
                            	while ($row = mysqli_fetch_assoc($result)) 
                                {
                                    if(htmlentities($row['user_uid']) === $username)
                                    {
                                    	header("Location: ../signup.php?signup=usertaken&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
										exit();
                                    }
                                    if(htmlentities($row['user_email']) === $email)
                                	{
                                    	header("Location: ../signup.php?signup=emailtaken&first=$first&last=$last&uid=$uid&email=$email&gender=$gender");
										exit();
                                    }
                                }
                            }
                            else 
                            {
                            	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                                $date = date("Y/m/d H:i:s");
                            	$sql = "INSERT INTO users(user_first, user_last, user_email, user_uid, user_pwd, date) VALUES(?,?,?,?, '$hashedPwd', '$date');";
                            	$stmt = mysqli_stmt_init($conn);
					            if(!mysqli_stmt_prepare($stmt, $sql))
					            {
					                echo "Failure: SQL statement failed. Signup query";
					            }
					            else
					            {
					            	//signing up user in MySQL db
					                mysqli_stmt_bind_param($stmt, "ssss", $first, $last, $email, $uid);
					                mysqli_execute($stmt);

									
					                header("Location: ../signup.php?signup=success");
					                exit();
					            }
                            }
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