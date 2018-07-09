<?php 
session_start(); 
include_once 'dbh.inc.php';

if(isset($_POST['submitItem']))
{
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $url = mysqli_real_escape_string($conn, $_POST['url']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $priority = $_POST['priority'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
	$date = date("Y/m/d H:i:s");

    if(empty($name) || empty($url))
    {
    	header("Location: ../wishlist.php?wishlist=empty&name=$name&url=$url&price=$price&priority=$priority&comment=$comment");
		exit();
    }
    else
	{
		$id = $_SESSION['u_id'];

		$sql = "SELECT * FROM users WHERE user_id='$id';";
		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);

		$serverwl = $row['user_wl'];
		print_r($serverwl);

		if($serverwl != null) 
		{
			$wl = json_decode($serverwl);
		}
		else $wl = array();

		$wlitem = array('name' => $name, 'url' => $url, 'price' => $price, 'priority' => $priority, 'comment' => $comment, 'date' => $date);

		array_push($wl, $wlitem);
		$json_wl = json_encode($wl);

		//update new wishlist with new item
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
            header("Location: ../wishlist.php?wishlist=added");
        }
	}
}
else
{
	header("Location: ../wishlist.php");
	exit();
}
