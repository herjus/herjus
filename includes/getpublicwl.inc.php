<?php 

$sql = "SELECT * FROM users WHERE user_uid='$user';";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

if($row['wl_public'])
{
	$serverwl = $row['user_wl'];

	if($serverwl != null) $wl = json_decode($serverwl, true);
	else $wl = null;
}



