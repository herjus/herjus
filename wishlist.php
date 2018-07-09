<?php include 'mainHeader.php' ?>

<?php 
if(!isset($_SESSION['u_id']))
{
	header('Location: signup.php');
	exit();
}
if(isset($_GET['wishlist']) && $_GET['wishlist'] != "added")
{
   	$name = htmlentities($_GET['name']);
    $url = htmlentities($_GET['url']);
    $price = htmlentities($_GET['price']);
    $priority = $_GET['priority'];
    $comment = htmlentities($_GET['comment']);
}

include 'includes/getwl.inc.php';

?>


<div class="main-1">
	<h4>My Wish List</h4>
	
	<?php 
		if (isset($wl))
		{
			for ($index = 0; $index < count($wl); $index++)
			{
				echo count($wl);
				print_r($wl);
				echo '<div class="wlitem">';
				$wlitem = $wl[$index];

				//$deleteString = "includes/deleteitem.inc.php?item=delete&&name=".$wl["$index"]['name']."&&url=".$wl["$index"]['url']."&&price=".$wl["$index"]['price']."&&priority=".$wl["$index"]['priority']."&&comment=".$wl["$index"]['comment'];
				
				$deleteString = "includes/deleteitem.inc.php?item=delete&&date=".$wl["$index"]['date'];

				$wlname = htmlentities($wlitem['name']);
			    $wlurl = htmlentities($wlitem['url']);
			    if(isset($wlitem['price'])) $price = htmlentities($wlitem['price']);
			    $priority = $wlitem['priority'];
			    if(isset($wlitem['comment'])) $comment = htmlentities($wlitem['comment']);
			    $wldate = $wlitem['date'];

			    echo '<a class ="delete-button" href="'.$deleteString.'">X</a>';
				echo "<div>Name: " . $wlname . "</div>";
				echo "<div>Url: " . '<a href="'.$wlurl .'" target="_blank">'.$wlurl.'</a>' . "</div>";
				if(!empty($price)) { echo "<div>Price: " . $price . "</div>"; }
				echo '<div class="wl-date">Priority: ' . $priority;
				echo '  Date added: ' . $wldate . '</div>';
				if(!empty($price)) { echo "<div>Comment: " . $comment . "</div>"; }
				echo '</div>';
				
			}
		}
	?>
</div>

<div class="sidebar-3">
	<div class="form-1">
	<h1>Add Item</h1>
		<form method="POST" action="includes/addwlitem.inc.php">
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
			<button type="submit" name="submitItem">Add</button>

		</form>
	</div>
</div>
<?php include 'footer.php' ?>
