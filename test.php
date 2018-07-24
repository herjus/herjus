<?php 
include 'mainHeader.php'; 
include 'class/dbh.class.php'; 
?>

<div class=mainContent>
<h1>Test Site</h1>

<div>
	<div class="main-1">
	<h2>String Fixing Function</h2>
	<div class= "testForm-1">
		<form method="POST">
			<input type="text" name="input" placeholder="Input" value="herJUs">
			<input type="text" name="name" placeholder="Name" value="risBakken">
			<input type="submit" name="submit1">
		</form>
		<div class="testBox">
			<?php
			
		    /*function fixString($string){
		        return $result = ucwords(mb_strtolower($string));
		    }*/
		    if(isset($_POST['submit1']))
		    {
		    	$testInput = fixString($_POST['input']);
		    	$testName = fixString($_POST['name']);
		    	echo "-" . $testInput . "-" . $testName . "-";
		    }
		    

			?>
		</div>
	</div>

	<h2>Multi Array</h2>
	<div class= "testForm-1">
		<form method="POST">
			<input type="text" name="color" placeholder="Input" value="red">
			<input type="text" name="shape" placeholder="Name" value="box">
			<input type="submit" name="submitArray">
		</form>
		<div class="testBox">
			<?php
			if(isset($_POST['submitArray']))
			{
				$color = $_POST['color'];
				$shape = $_POST['shape'];
			    $a1 = array('color' => $color, 'shape' => $shape);
			    echo 'Array: ';print_r($a1); echo '<br>';
			    
			    $jsonencode = json_encode($a1);
			    echo 'json_encode: ';print_r($jsonencode); echo '<br>';echo '<br>';

			    $jsondecodet = json_decode($jsonencode, true);
			    echo 'json_decode, true: ';print_r($jsondecodet); echo '<br>';

			    $jsondecodef = json_decode($jsonencode, false);
			    echo 'json_decode, false: ';print_r($jsondecodef); echo '<br>';
			}

			?>
		</div>
	</div>

	<div class="testForm-1">
		<h1>--</h1>
		<h3>FILTHER_VALIDATE_EMAIL</h3>
		<form method="POST">
			<input type="email" name="email" placeholder="email" value="herjus@hotmail.com">
			<input type="submit" name="submit2">
		</form>
		<div class="testBox">
			<?php
			// Variable to check
			if(isset($_POST['submit2']))
			{
				$email = $_POST['email'];

				// Remove all illegal characters from email
				$email = htmlentities(fixString($email));
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);

				// Validate e-mail
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				    echo("$email is a valid email address");
				} else {
				    echo("$email is not a valid email address");
				}
			}
			?> 	
		</div>

	</div>
	<div class="testForm-1">
		<h3>Server username/email check</h3>
		<form method="POST">
			<input type="text" name="username" placeholder="Username" value="herjus">
			<input type="text" name="email" placeholder="email" value ="herjus@hotmail.com">
			<button type="submit" name="submit3">test</button>
		</form>
		<div class="testBox">
			<?php 
				if(isset($_POST['submit3']))
				{
					if(isset($_POST['username'])) $username = htmlentities(fixString($_POST['username']));
					if(isset($_POST['email']))  $email = htmlentities(fixString($_POST['email']));

					$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?";
					$conn = new Dbh;
					$stmt = $conn->connect()->prepare($sql);
					$stmt->execute([$username, $email]);

					
			        
			        if($row = $stmt->fetch()) 
		            {
		                if(htmlentities($row['user_uid']) === $username) echo "Username exists in db";
		                if(htmlentities($row['user_email']) === $email) echo "<br> Email exists in db";
		            }
		            else echo 'Nothing found.';
				}
			?>
			
		</div>
	</div>
	
	<div class="testForm-1">
		<h3>Char test</h3>
		<form method="GET">
			<?php 
			if(isset($_GET['submit4']))
			{
				$testname = htmlentities($_GET['testname']);
			}
			else $testname = "testname";
			 ?>

			<input type="text" name="testname" placeholder="testname "value="<?php if(isset($testname))echo $testname; else echo "øæå" ?>">
			<button type="submit" name="submit4">char test</button>
		</form>
		<div class="testBox">
			<?php 
					if(isset($_GET['submit4']))
					{
						$name = $_GET['testname'];
						$htmlspecialchars = htmlspecialchars(fixString($name));
						$htmlentities = fixString(htmlentities($name));
						if(isset($_REQUEST['testname']))
						{
							echo "request set: " . $_REQUEST['testname'] . '<br>';
						}
						
						echo "preg_match /^[a-zA-Z]*$/  Result: " . preg_match("/^[a-zA-Z]*$/", $name) . '<br>';
						echo "preg_match /^[a-åA-Å]*$/  Result: " . preg_match("/^[a-åA-Å]*$/", $name) . '<br>';
						echo "preg_match /\.pdf$/  Result: " . preg_match("/\.pdf$/", $name) . '<br>';
						echo "name: "." $name " . '<br>';
						
						echo "htmlspecialchars: "." $htmlspecialchars  " . '<br>';
						echo "htmlentities: "." $htmlentities " . '<br>';
					}
				
			 ?>
		</div>
		</div>
	</div>

<?php 
	function pwdCheck($pwd, $pwdHash){
		$match = password_verify($pwd, $pwdHash);
		if($match)
		{
		echo  $pwd . ": " . ' - Password matched' . '<br>';
		}
		else echo " Password didn't match <br> ";
	}

?>
	<div class="box-2">
		<h1>Password Hashing</h1>
		<?php 
		
		$newhash4 = "\$2y\$10\$RkubHJrrrhYB9UE1xF57CetCfjoQRgj5eOpbi5C2rvXbKGM7dKkQe";
		$newhash42 ="\$2y\$10\$Bu3aMLbSVEMcWqZmNW3sTuPii60WJItBHUdmrBx/Nriqftx5wta4O";

		$testArray = array("", "123", "333456999", "3334569991113416");
		list($test1, $test2, $test3, $test4) = $testArray;
		$hash1 = password_hash($test1, PASSWORD_DEFAULT);
		$hash2 = password_hash($test2, PASSWORD_DEFAULT);
		$hash3 = password_hash($test3, PASSWORD_DEFAULT);

		echo 'empty pw: ' . $test1 . 'hash: ' . $hash1 . '<br>'; 
		echo 'pwd: ' . $test2 . 'hash: ' . $hash2 . '<br>';
		echo 'pwd: ' . $test2 . 'hash: ' . $hash3 . '<br>';
		echo " <br> Empty string hash test: ";
		pwdCheck("", password_hash("", PASSWORD_DEFAULT));
		pwdCheck($test2, $hash2);
		pwdCheck($test3, $hash3);
		echo '<br>';
		pwdCheck($test2, $hash2);
		pwdCheck($test2, $hash2);
		echo "<br>". "<br>";
		?>

		<?php 
		if(isset($_POST['submit']))
		{
			$pwd = htmlspecialchars($_POST['pwd']);
		}
		elseif(isset($_POST['verify']))
		{
			$pwd = htmlspecialchars($_POST['pwd']);
			$pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
		}
		else
		{
			$pwd = "";
			$pwdHash = "";
		}

		//no need to preview hash of an empty string
		if(isset($_POST['pwd']))
		{
			$pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
		}
		else
		{
			$pwdHash = "";
		}
		?>
		
		<form method="POST" class="form-2">
			<input type="password" name="pwd" placeholder="Password" value="<?php echo $pwd?>">
			<button type="submit" name="submit">Hash</button><br>
			<input type="text" name="hash" placeholder="Hashed Password" value="<?php  echo $pwdHash?>">
			<button type="submit" name="verify">Verify</button>
		</form>
		
		<?php 
		//if(isset()) 
		echo '<p>'. 'Password Hash: '; if(isset($pwdHash)) echo $pwdHash; echo'</p>'; ?>

		<form method="POST">
			
		</form>
		<?php 
		if(isset($_POST['verify']))
		{
			if(isset($_POST['pwd']))
			{
				$pwd = htmlspecialchars($_POST['pwd']);
				$pwdHash = password_hash($pwd, PASSWORD_DEFAULT);
			}
						
			if(password_verify($pwd, $_POST['hash']) == 1)
			{
				echo "Password is a match";
			}
		}

		 ?>
	</div>
	<div class="box-2"> 
		<h4>Session variables currently stored</h4>
		<?php 
			if(isset($_SESSION))
			{
				foreach($_SESSION as $key => $item)
				{
					if(is_string($item)) echo $key." : ". $item."<br>";
					else {
						echo $key. ' : '; print_r($item); echo '<br>';
					}
				}
				echo '<br><div><form action="includes/userhandler.inc.php" method="POST">
									<button type="submit" name="submit" value="logout">Logout</button>
								</form>';
			}

		 ?>


	</div>

<div class="conn">
	<h1>Connection</h1>
    <h2>MySQL Server status</h2>
       <?php
            $dbh = new Dbh;
            $sql = "SELECT * FROM users;";
            $stmt = $dbh->connect()->query($sql);
            $resultsCheck = $stmt->rowCount();
        ?>
    <div class ="connectionStatus">
        <?php
            echo $stmt ? 'Connection established with server' : 'no connection with server' ; 
        ?>
        
    </div>
    
    <?php
    echo '<br>' . '<br>' . 'Members signed up: ' . '<br>';
    if ($resultsCheck > 0)
    {
        echo $resultsCheck;
    }


    ?> 
</div>

<div class="conn">
    <h2>Server Info</h2>
    <?php
    $server = [
            'Host Server Name' => $_SERVER['SERVER_NAME'],
            'Host Header' => $_SERVER['HTTP_HOST'],
            'Server Software' => $_SERVER['SERVER_SOFTWARE'],
            'Server Protocol' => $_SERVER['SERVER_PROTOCOL'],
            'Document Root' => $_SERVER['DOCUMENT_ROOT'],
            'Current Page' => $_SERVER['PHP_SELF'],
            'Script Name' => $_SERVER['SCRIPT_NAME'],
            'Absolute Path' => $_SERVER['SCRIPT_FILENAME'],
            'Request Uri' => $_SERVER['REQUEST_URI']
        ];
        echo 'Host Server Name: ' . $server['Host Server Name'] . '<br>';
        echo 'Host Header: ' . $server['Host Header'] . '<br>';
        echo 'Server Software: ' . $server['Server Software'] . '<br>';
        echo 'Server Protocol: ' . $server['Server Protocol'] . '<br>';
        echo 'Document Root: ' . $server['Document Root'] . '<br>';
        echo 'Current Page: ' . $server['Current Page'] . '<br>';
        echo 'Script Name: ' . $server['Script Name'] . '<br>';
        echo 'Absolute Path: ' . $server['Absolute Path'] . '<br>';
        echo 'Request Uri: ' . $server['Request Uri'] . '<br>';
        ?>
</div>

<div class="conn">
    <h2>Client Info</h2>
    <?php

    $client = [
        'Client System Info' => $_SERVER['HTTP_USER_AGENT'],
        'Client IP' => $_SERVER['REMOTE_ADDR'],
        'Remote Port' => $_SERVER['REMOTE_PORT']
    ];
    echo 'Client System Info: ' . $client['Client System Info'] . '<br>';
    echo 'Client IP: ' . $client['Client IP'] . '<br>';
    echo 'Remote Port: ' . $client['Remote Port'] . '<br>-';


    ?>
</div>

</div>
</div>

<?php include 'footer.php' ?>