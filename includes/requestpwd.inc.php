<?php 

session_start();

if(isset($_POST['requestpwd']))
{
	include_once 'dbh.inc.php';

	$pwd = $_POST['pwd'];
	$id = $_SESSION['u_id'];

	if(empty($pwd))
	{
		header("Location: ../profile.php?requestpwd=empty");
		exit();
	}
	else
	{
		$sql = "SELECT * FROM users WHERE user_id='$id';";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if($resultCheck !== 1)
		{
			header("Location: ../profile.php?requestpwd=usererror");
			exit();
		}
		else
		{
			$row = mysqli_fetch_assoc($result);
			$pwdTest = password_verify($pwd, $row['user_pwd']);
			if($pwdTest == false)
			{
				header("Location: ../profile.php?requestpwd=pwfalse");
				exit();
			}
			elseif($pwdTest == true)
			{
				$pwdHash = $row['user_pwd'];
				header("Location: ../profile.php?requestpwd=success&pwdhash=$pwdHash");
				exit();
			}
		}
	}
}
else
{
	header("Location: ../profile.php");
	exit();
}