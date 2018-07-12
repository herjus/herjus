<?php include_once 'mainHeader.php';

if(!isset($_SESSION['u_uid'])) 
{
	header('Location: index.php');
	exit();
}
?>
<div>
	<div class="box-3">
		<h1>Profile Summary</h1>

		<div>
			<div class="signUp">
			<?php 
			echo "<br> Name: " . $_SESSION['u_first'] . ' '. $_SESSION['u_last'] . '<br>';
			echo "E-mail: " . $_SESSION['u_email'] . '<br>';
			echo "Username: " . $_SESSION['u_uid'] . '<br>';
			echo "Joined: " . $_SESSION['date'] . '<br>';
			echo 'Server Id: ' . $_SESSION['u_id'] . '<br>';
			 ?></div>
			 <div>
			 	
			 
			 <?php 
			 	if(!isset($_GET['requeststart']) && !isset($_GET['requestpwd']))
			 		echo '<form class ="signUp">
			 			<button type="submit" name="requeststart" >Request Password Hash on server</button>
			 			</form>';
			 
	 			else
	 			{
	 			 	echo '<form method="POST" action="includes/requestpwd.inc.php" class="signUp">
		  				<button type="submit" name="requestpwd">Request Password Hash stored on server</button>
		  			 	<input type="password" name="pwd" placeholder="Password">
		  				</form>';
	 			}
	 			if(isset($_GET['requestpwd']))
	 			{

	 				if($_GET['requestpwd'] == "empty")
		 			{
		 				echo "<p class='error'> Fill out password</p>";
		 			}
		 			if($_GET['requestpwd'] == "pwfalse")
		 			{
		 				echo "<p class='error'> Password is wrong </p>";
		 			}
	 				if($_GET['requestpwd'] == "success")
		 			{
		 				$pwdResult = htmlentities($_GET['pwdhash']);
		 				echo "<p class='error'> $pwdResult </p>";
		 			}
	 			}
	 			
			  ?>
			  </div>
		</div>
	</div>

	<div>
		<h1>Change Password</h1>
		<?php if(!isset($_GET['startpwdr']) && !isset($_GET['form'])) echo '<form class ="signUp">
		<button type="submit" name="startpwdr">Change Password</button>
		</form>' ?>
		
		<?php if(isset($_GET['startpwdr']) || isset($_GET['form'])) echo
		'<form method="POST" class="signUp" action="includes/changepwd.inc.php">
			<input type="password" name="pwdOld" placeholder="Old Password">
			<input type="password" name="pwd" placeholder="New Password">
			<input type="password" name="pwdr" placeholder="Repeat Password">
			<button type="submit" name="submit">Change Password</button>
		</form>' ?>
	</div>

	<?php 
	if(!isset($_GET['form']))
	{
	}
	else
	{
		$formResult = htmlentities($_GET['form']);
		if($formResult == "empty")
		{
			echo "<p class='error'>Fill out all fields.</p>";
		}
		if($formResult == "passwordmm")
		{
			echo "<p class='error'>New password does not match repeated password.</p>";
		}
		if($formResult == "passwordshort")
		{
			echo "<p class='error'>New password is too short.</p>";
		}
		if($formResult == "usererror")
		{
			echo "<p class='error'>User not found in database</p>";
		}
		if($formResult == "pwfalse")
		{
			echo "<p class='error'>Current password is incorrect.</p>";
		}
		if($formResult == "success")
		{
			echo "<p class='error'>Password has been successfully changed!</p>";
		}
	}

	?>

	<?php 
		if(isset($_SESSION['u_uid']))
		{
			echo '<h1>Wishlist</h1>';
			echo '<div class="signUp">';
			if($_SESSION['wl_public'] === false) echo '<form action="includes/makepublic.inc.php" method="POST">
					<button type="submit" name="makePublic">Make Wishlist Public</button>
				</form>
			</div>';
			else echo '<h3>Public wishlist link: </h3> <br/><h4><a style="color:black" href="publicWishlist.php?user='.$_SESSION['u_uid'].'"> www.herjus.no.publicWishlist.php?user='.$_SESSION['u_uid'].'</a></h4><br/>

				<form action="includes/makepublic.inc.php" method="POST">
					<button type="submit" name="makePrivate">Make Wishlist Private</button>
				</form>
			</div>';
		}
	?>
	
</div>
<?php include_once 'footer.php' ?>
