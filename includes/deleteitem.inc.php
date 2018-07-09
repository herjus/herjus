<?php 
session_start();
if(!isset($_SESSION['u_id']))
{
	header("Location: ../signup.php");
	exit();
}
include 'dbh.inc.php';
include 'getwl.inc.php';
$id = $_SESSION['u_id'];
$deldate = htmlentities($_GET['date']);


print_r($wl); echo '<br><br>';
/*
for($i = 0; $i < count($wl);$i++)
{
	$wlitem = $wl[$i];
	$wlname = htmlentities($wlitem['name']);
    $wlurl = htmlentities($wlitem['url']);
    if(isset($wlitem['price'])) $wlprice = htmlentities($wlitem['price']); //else $price = "";
    $wlpriority = $wlitem['priority'];
    if(isset($wlitem['comment'])) $wlcomment = htmlentities($wlitem['comment']); //else $comment = "";
	if($wlname == $delname && $wlurl == $delurl && $wlprice == $delprice && $wlpriority == $delpriority)
	{
		unset($wl[$i]);
	}
}*/

for($i = 0; $i < count($wl);$i++)
{
	$wlitem = $wl[$i];
    $wldate = $wlitem['date'];

	if($wldate == $deldate)
	{
		unset($wl[$i]);
		$i = count($wl);
		//array_values($wl);
		$json_wl = json_encode($wl);
		$sql = "UPDATE users SET user_wl = ? WHERE user_id='$id' ;";
		$stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            echo "Failure: SQL statement failed. Select query";
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "s", $json_wl);
            mysqli_execute($stmt);
            header("Location: ../wishlist.php?item=deleted");
        }
	}
}



print_r($wl); echo '<br>';