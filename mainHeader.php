<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Herjus.no</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
	<div class=mainContainer>
		<div class="mainHeader">
			<header>
				<h1>Welcome!</h1>
				<div class="nav-login">
					
					<?php 
					$profile_name ="twitter";
					if(isset($_SESSION['u_uid']) && !empty($_SESSION['u_uid'])) $profile_name = $_SESSION['u_uid'];
					elseif (isset($_SESSION['twitter_name'])) $profile_name = $_SESSION['twitter_name'];

					if(isset($_GET['origin'])) $origin = htmlspecialchars($_GET['origin']);
    				else $origin = "index";

					if(isset($_SESSION['u_id']))
					{
						echo '<div class="loggedin-box"><form action="includes/userhandler.inc.php" method="POST">
									<button type="submit" name="submit" value="logout">Logout</button>
								</form>';
						echo '<form action="profile.php" class="profile-button">
									<button>'. $profile_name . '</button>
								</form></div>';
					}
					else
					{
						echo 
						'<div><form method="POST" action="includes/userhandler.inc.php">
							<input type="hidden" name="origin" value="'.$origin.'">
							<input type="text" name="uid" placeholder="username/e-mail">
							<input type="password" name="pwd" placeholder="password">
							<button type="submit" name="submit" value="login">Login</button>
						</form>

						<form action="twitter/twlogin.php" method="POST">
							<button>Twitter</button>
						</form>
						<a href="signup.php">Sign Up</a>
						</div>';
					}
					?>
					
					
				</div>

			</header>
			<nav>
				<div class="navBar">
					<div class="nav-1">
						<ul>
				    	<li><a href="index.php">Home</a></li>
				    	<?php if(!isset($_SESSION['u_id'])) echo 
				    	'<li><a href="publicWishlist.php">Public Wishlist</a></li>
				    	<li><a href="signup.php?origin=calculator">Calculator</a></li>
				        <li><a href="test.php">Test Site</a></li>
				        <li><a href="twitter.php">Twitter</a></li>
				        <li><a href="signup.php">Sign up</a></li>';
				        else
				    	echo 
						'<li><a href="wishlist.php">Wish List</a></li>
						<li><a href="publicWishlist.php?user='.$profile_name.'">Public Wishlist</a></li>
						<li><a href="calculator.php">Calculator</a></li>
				        <li><a href="test.php">Test Site</a></li>
				        <li><a href="twitter.php">Twitter</a></li>
				        <li><a href="profile.php">Profile</a></li>'; ?>
				    	</ul>	
					</div>
					
			    	<div class="timeBox">
					    <?php
					            function getDay(){
					                $day = "";
					                switch (date("w")){
					                    case 0:	$day = "Sunday"; break;
					                    case 1; $day = "Monday"; break;
					                    case 2; $day = "Tuesday"; break;
					                    case 3; $day = "Wednesday"; break;
					                    case 4; $day = "Thursday"; break;
					                    case 5; $day = "Friday"; break;
					                    case 6; $day = "Saturday"; break;
					                }
					                return $day;
					            }
					        echo date("H:i")." ".getDay().' '. date("d.m.Y ");
					        ?> 
				    </div>

				</div>

			    
			</nav>
		</div>
		<div class="mainContent">
