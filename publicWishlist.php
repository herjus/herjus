<?php include 'mainHeader.php'; ?>

<?php 

if(isset($_GET['user'])) 
{
	$user = $_GET['user'];
	include_once 'includes/getpublicwl.inc.php';
}
?>


<div class="main-1">
	<?php if(isset($user)) echo "<h4>" .$user."'s Wish List</h4>"  ?>
	
	
	<?php 
		if (isset($wl))
		{
			for ($index = 0; $index < count($wl); $index++)
			{
				echo '<div class="wlitem">';
				$wlitem = $wl[$index];
								
				$wlname = htmlentities($wlitem['name']);
			    $wlurl = htmlentities($wlitem['url']);
			    if(isset($wlitem['price'])) $wlprice = htmlentities($wlitem['price']);
			    $wlpriority = $wlitem['priority'];
			    if(isset($wlitem['comment'])) $wlcomment = htmlentities($wlitem['comment']);
			    $wldate = $wlitem['date'];

				echo "<div>Name: " . $wlname . "</div>";
				echo "<div>Url: " . '<a href="'.$wlurl .'" target="_blank">'.$wlurl.'</a>' . "</div>";
				if(!empty($wlprice)) { echo "<div>Price: " . $wlprice . "</div>"; }
				echo '<div class="wl-date">Priority: ' . $wlpriority;
				echo ' - Date added: ' . $wldate . '</div>';
				if(!empty($wlcomment)) { echo "<div>Comment: " . $wlcomment . "</div>"; }
				echo '</div>';
			}
		}
	?>
</div>

<div class="sidebar-3">
	
	<?php 
		if(isset($_SESSION['u_uid']) && $_SESSION['u_uid'] === $user)
		{
			if($_SESSION['wl_public'] === false) echo '<div class="signUp">
				<form action="includes/makepublic.inc.php" method="POST">
					<button type="submit" name="makePublic">Make Wishlist Public</button>
				</form>
			</div>';
			else echo '<div class="signUp">
				<h3>Public wishlist link: </h3> <br/><h4><a style="color:black" href="publicWishlist.php?user='.$_SESSION['u_uid'].'"> www.herjus.no.publicWishlist.php?user='.$_SESSION['u_uid'].'</a></h4><br/>

				<form action="includes/makepublic.inc.php" method="POST">
					<button type="submit" name="makePrivate">Make Wishlist Private</button>
				</form>
			</div>';
		}
	?>

</div>

<?php include 'footer.php' ?>