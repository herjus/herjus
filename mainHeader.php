<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Herjus</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
	<div class=mainContainer>
		<div class="mainHeader">
			<header>
				<h1>Welcome to Freemdom!</h1>
				<div class="nav-login">
					
					<?php 
					if(isset($_GET['origin'])) $origin = htmlspecialchars($_GET['origin']);
    				else $origin = "index";
					if(isset($_SESSION['u_id']))
					{
						echo '<div class="loggedin-box"><form action="includes/userhandler.inc.php" method="POST">
									<button type="submit" name="submit" value="logout">Logout</button>
								</form>';
						echo '<form action="profile.php" class="profile-button">
									<button type="submit" name="profile">'. $_SESSION['u_uid'] . '</button>
								</form></div>';
					}
					else
					{
						echo '<div><form method="POST" action="includes/userhandler.inc.php">
						<input type="hidden" name="origin" value="'.$origin.'">
						<input type="text" name="uid" placeholder="username/e-mail">
						<input type="password" name="pwd" placeholder="password">
						<button type="submit" name="submit" value="login">Login</button>
						</form>
						<a href="signup.php">Sign Up</a></div>';
					}
					?>
					
					
				</div>
			</header>
			<nav>
				<div class="navBar">
					<ul>
			    	<li><a href="index.php">Home</a></li>
			    	<?php if(!isset($_SESSION['u_id'])) echo 
			    	'<li><a href="publicWishlist.php">Public Wishlist</a></li>
			    	<li><a href="signup.php?origin=calculator">Calculator</a></li>
			        <li><a href="signup.php?origin=calender">Calender</a></li>
			        <li><a href="signup.php?origin=connection">Connection</a></li>
			        <li><a href="signup.php?origin=test">Test Site</a></li>
			        <li><a href="signup.php?origin=hashing">Hashing passwords</a></li>
			        <li><a href="signup.php">Sign up</a></li>' ?>
			    	<?php if(isset($_SESSION['u_id'])) echo 
					'<li><a href="wishlist.php">Wish List</a></li>
					<li><a href="publicWishlist.php?user='.$_SESSION['u_uid'].'">Public Wishlist</a></li>
					<li><a href="calculator.php">Calculator</a></li>
			        <li><a href="calender.php">Calender</a></li>
			        <li><a href="connection.php">Connection</a></li>
			        <li><a href="test.php">Test Site</a></li>
			        <li><a href="hashing.php">Hashing passwords</a></li>
			        <li><a href="profile.php">Profile</a></li>' ?>
			    </ul>
				</div>
			    
			</nav>
		</div>
