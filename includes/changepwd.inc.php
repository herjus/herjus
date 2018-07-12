<?php 

if(isset($_POST['submit']))
{
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
		$user = new User;
		$changepwd = $user->changepwd($pwdOld, $pwd, $pwdr);

		if($changepwd = "success")
		{
			header("Location: ../profile.php?form=success");
			exit();
		}
		else
		{
			header("Location: ../profile.php?form=".$changepwd);
			exit();
		}
	}
}
else
{
	header("Location: ../profile.php");
	exit();
}