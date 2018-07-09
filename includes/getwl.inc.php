<?php 

$id = $_SESSION['u_id'];

$sql = "SELECT * FROM users WHERE user_id='$id';";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$serverwl = $row['user_wl'];

if($serverwl != null) $wl = json_decode($serverwl, true);
else $wl = null;