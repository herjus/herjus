<?php 

session_start();

if(isset($_POST['submit']))
{
	include_once 'dbh.inc.php';

	$id = $_SESSION['u_id'];
	$pwdOld = mysqli_real_escape_string($conn, $_POST['pwdOld']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	$pwdr = mysqli_real_escape_string($conn, $_POST['pwdr']);

	if(empty($pwd) || empty($pwdOld)|| empty($pwdr))
	{
		header("Location: ../profile.php?form=empty");
		exit();
	}
	else
	{
		if($pwd !== $pwdr)
		{
			header("Location: ../profile.php?form=passwordmm");
			exit();
		}
		else
		{
			if(strlen($pwd) <= 7)
			{
				header("Location: ../profile.php?form=passwordshort");
				exit();
			}
			else
			{
				$sql = "SELECT * FROM users WHERE user_id='$id';";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);
				if($resultCheck < 1)
				{
					header("Location: ../profile.php?form=usererror");
					exit();
				}
				else
				{
					if($row = mysqli_fetch_assoc($result))
					{
						$pwdTest = password_verify($pwdOld, $row['user_pwd']);
						if($pwdTest == false)
						{
							header("Location: ../profile.php?form=pwfalse");
							exit();
						}
						elseif($pwdTest == true)
						{
							$pwdHashed = password_hash($pwd, PASSWORD_DEFAULT);
							$sql = "UPDATE users SET user_pwd = '$pwdHashed' WHERE user_id='$id';";
							$result = mysqli_query($conn, $sql);

							header("Location: ../profile.php?form=success");
							exit();
						}
					}
				}
			}
		}
	}
}
else
{
	header("Location: ../profile.php");
	exit();
}