<?php 
session_start(); 
if(!isset($_SESSION['u_id']))
{
	header("Location: ../signup.php");
	exit();
}
include_once 'dbh.inc.php';
if(isset($_POST['makePublic']))
{
		$id = $_SESSION['u_id'];

		$sql = "UPDATE users SET wl_public=1 WHERE user_id='$id';";
		$result = mysqli_query($conn, $sql);
		$_SESSION['wl_public'] = true;
		header("Location: ../wishlist.php?wishlist=public");
}
elseif(isset($_POST['makePrivate']))
{
		$id = $_SESSION['u_id'];

		$sql = "UPDATE users SET wl_public=0 WHERE user_id='$id';";
		$result = mysqli_query($conn, $sql);
		$_SESSION['wl_public'] = false;
		header("Location: ../wishlist.php?wishlist=private");
}
else
{
	header("Location: ../wishlist.php?wishlist=error");
	exit();
}
