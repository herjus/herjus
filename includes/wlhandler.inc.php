<?php 
session_start();
include '../class/wl.class.php';

if(isset($_SESSION['u_id']))
{
	$wl = new Wishlist;
	$wl->getWl();
	$id = $_SESSION['u_id'];

	if(isset($_POST['origin'])) $origin = htmlspecialchars($_POST['origin']);
	else $origin = "wishlist";

	if(isset($_GET['delete']))
	{
		if(htmlentities($_GET['delete']) == "true")
		{
			$deldate = htmlentities($_GET['date']);
			$deleteitem = $wl->deleteItem($deldate);

		    header("Location: ../wishlist.php?item=".$deleteitem);
		}
	}

	elseif(isset($_POST['addItem']))
	{
		$name = htmlspecialchars($_POST['name']);
	    $url = htmlspecialchars($_POST['url']);
	    $price = htmlspecialchars($_POST['price']);
	    $priority = $_POST['priority'];
	    $comment = htmlspecialchars($_POST['comment']);

	    if(empty($name) || empty($url)) header("Location: ../wishlist.php?wishlist=empty&name=$name&url=$url&price=$price&priority=$priority&comment=$comment");
	    else
		{
			$additem = $wl->addItem($name, $url, $price, $priority, $comment);
	        header("Location: ../wishlist.php?wishlist=".$additem);
		}
	}
	if(isset($_POST['changeVisibility']))
	{
		$change = $_POST['changeVisibility'];

		$changeVisibility = $wl->changeVisibility($change);
		header("Location: ../".$origin.".php?changeVisibility=".$changeVisibility);
	}
}
else
{
	header("Location: ../signup.php?loginerror".$_SESSION['u_id']);
	exit();
}

