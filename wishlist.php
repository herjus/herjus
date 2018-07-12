<?php 
	include 'mainHeader.php'; 
	include 'includes/wlhandler.inc.php';

	if(!isset($_SESSION['u_id']))
	{
		header('Location: signup.php?link=wishlist');
		exit();
	}
	if(isset($_GET['wishlist']) && $_GET['wishlist'] == "empty")
	{
	   	$name = htmlentities($_GET['name']);
	    $url = htmlentities($_GET['url']);
	    $price = htmlentities($_GET['price']);
	    $priority = $_GET['priority'];
	    $comment = htmlentities($_GET['comment']);
	}
?>

<div class="main-1">
	<h4>My Wish List</h4>
	
	<?php 
		if (isset($wl->user_wl))
		{
			for ($index = 0; $index < count($wl->user_wl); $index++)
			{
				echo '<div class="wlitem">';
				$wlitem = $wl->user_wl[$index];
				
				$deleteString = "wishlist.php?delete=true&&date=".$wlitem['date'];

				$wlname = htmlentities($wlitem['name']);
			    $wlurl = htmlentities($wlitem['url']);
			    if(isset($wlitem['price'])) $wlprice = htmlentities($wlitem['price']);
			    $wlpriority = $wlitem['priority'];
			    if(isset($wlitem['comment'])) $wlcomment = htmlentities($wlitem['comment']);
			    $wldate = $wlitem['date'];

			    echo '<a class ="delete-button" href="'.$deleteString.'">X</a>';
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
	<div class="form-1">
	<h1>Add Item</h1>
		<form method="POST">
			<div class="required">
				<input type="text" name="name" placeholder="Item Name" value="<?php if(isset($name)) echo $name?>"> *
			</div>
			 <div class="required">
			 	<input type="text" name="url" placeholder="Url Link" value="<?php if(isset($url)) echo $url ?>"> *
			 </div>
			<input type="text" name="price" placeholder="Price" value="<?php if(isset($price)) echo $price?>">
			 <div class="radio-2">
			 	<br>
			 	Priority:
				<input type="radio" name="priority" value="High" <?php if(isset($_GET['priority'])) { if($_GET['priority']=="high") echo 'checked'; } ?> > High 
				<input type="radio" name="priority" value="Medium" <?php if(!isset($_GET['priority']) || $_GET['priority']!="high") echo 'checked';  ?>> Medium 
				<input type="radio" name="priority" value="Low" <?php if(isset($_GET['priority'])) { if($_GET['priority']=="low") echo 'checked'; }  ?> > Low
			</div>
			 <input type="comment" name="comment" placeholder="Comment" value="<?php if(isset($comment)) echo $comment?>"><br>
			<button type="submit" name="addItem">Add</button>

		</form>
	</div>
	<?php if($_SESSION['wl_public'] === false) echo '<div class="signUp">
				<form method="POST">
					<button type="submit" name="changeVisibility" value="public">Make Wishlist Public</button>
				</form>
			</div>';
			else echo '<div class="signUp">
				<h3>Public wishlist link: </h3> <br/><h4><a style="color:black" href="publicWishlist.php?user='.$_SESSION['u_uid'].'"> www.herjus.no.publicWishlist.php?user='.$_SESSION['u_uid'].'</a></h4><br/>

				<form method="POST">
					<button type="submit" name="changeVisibility" value="private">Make Wishlist Private</button>
				</form>
			</div>';

			 ?>

</div>

<?php include 'footer.php' ?>
