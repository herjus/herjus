<?php include 'mainHeader.php' ?>

<?php 
	function fixString($string){
        return $result = ucwords(mb_strtolower($string));
    }
    if(isset($_GET['signup']))
    {
        if(($_GET['signup'] !=="success"))
        {
            $first = htmlentities(fixString($_GET['first']));
            $last = htmlentities(fixString($_GET['last']));
            $uid = htmlentities(fixString($_GET['uid']));
            $email = htmlentities(fixString($_GET['email']));
            $gender = htmlentities(($_GET['gender']));
        }
    }
    if(isset($_GET['origin'])) $origin = htmlspecialchars($_GET['origin']);
    else $origin = "index";
        
    ?>
    <?php if(!isset($_SESSION['u_id']) || empty($_SESSION['u_id'])) 
        echo '<div class="signUp">
            <h2>Log in</h2>
            <form method="POST" action="includes/userhandler.inc.php">
            <input type="hidden" name="origin" value="<?php echo $origin ?>">
            <input type="text" name="uid" placeholder="username/e-mail">
            <input type="password" name="pwd" placeholder="password">
            <button type="submit" name="submit" value="login">Login</button>
            </form>
            <form method="POST" action="twitter/twlogin.php">
            <input type="hidden" name="origin" value="<?php echo $origin ?>">
            <button type="submit" name="submit">Twitter Login</button>
            </form>
        </div>'
        ?>
    <div class="signUp">
        <h2>Sign Up</h2>
        <form action="includes/userhandler.inc.php" method="POST">
        <input type="hidden" name="origin" value="<?php echo $origin ?>">
        <input type="text" name="first" placeholder="First name" value="<?php if(isset($first)) echo $first?>" /> <br />
        <input type="text" name="last" placeholder="Last name" value="<?php if(isset($last)) echo $last?>"/><br />
        <input type="text" name="uid" placeholder="Username" value="<?php if(isset($uid)) echo $uid?>"/><br />
        <input type="password" name="pwd" placeholder="Password - minimum 8 char"/><br />
        <input type="password" name="pwdr" placeholder="Repeat Password"/><br />
        <input type="text" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email?>"/><br />
        <div class="radio-1">
            <input type="radio" name="gender" value="Male" checked > Male <br>
            <input type="radio" name="gender" value="Female"<?php if(isset($_GET['gender'])) { if ($_GET['gender']=="Female") echo 'checked'; }  ?> > Female <br>
            <input type="radio" name="gender" value="Peoplekind" <?php if(isset($_GET['gender'])) { if ($_GET['gender']=="Peoplekind") echo 'checked'; }  ?> > Peoplekind <br>   
        </div>
        
        <button type="submit" name="submit" value="signup">Sign up</button>
        </form>
    </div>
    <div>
        
    </div>
    <?php 
    	if(isset($_GET['signup']))
    	{
    		$signupCheck = $_GET['signup'];

            if($signupCheck == "empty") 
            {
                echo "<p class='error'>Fill in all the fields.</p>";
            }
            elseif($signupCheck == "passwordmm") 
            {
                echo "<p class='error'>Password does not match.</p>";
            }
            elseif($signupCheck == "char") 
            {
                echo "<p class='error'>Invalid character used.</p>";
            }
            elseif($signupCheck == "passwordshort") 
            {
                echo "<p class='error'>Password is too short.</p>";
            }
            elseif($signupCheck == "invalidemail") 
            {
                echo "<p class='error'>Email is invalid.</p>";
            }
            elseif($signupCheck == "usertaken") 
            {
                echo "<p class='error'>Username is taken.</p>";
            }
            elseif($signupCheck == "emailtaken") 
            {
                echo "<p class='error'>Email is already signed up.</p>";
            }
            elseif($signupCheck == "uidemailtaken") 
            {
                echo "<p class='error'>Email and username are already signed up.</p>";
            }
            elseif($signupCheck == "success") 
            {
                echo "<p class='success'>Sign up complete!</p>";
            }
    	}
    	
     ?>
    
<?php include 'footer.php' ?>