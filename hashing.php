<?php include 'mainHeader.php';

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
		<?php 
		
		$newhash4 = "\$2y\$10\$RkubHJrrrhYB9UE1xF57CetCfjoQRgj5eOpbi5C2rvXbKGM7dKkQe";
		$newhash42 ="\$2y\$10\$Bu3aMLbSVEMcWqZmNW3sTuPii60WJItBHUdmrBx/Nriqftx5wta4O";

		$testArray = array("", "123", "333456999", "3334569991113416");
		list($test1, $test2, $test3, $test4) = $testArray;
		$hash1 = password_hash($test1, PASSWORD_DEFAULT);
		$hash2 = password_hash($test2, PASSWORD_DEFAULT);
		$hash3 = password_hash($test3, PASSWORD_DEFAULT);
		$hash4 = password_hash($test4, PASSWORD_DEFAULT);

		echo 'empty pw: ' . $test1 . 'hash: ' . $hash1 . '<br>'; 
		echo 'pwd: ' . $test2 . 'hash: ' . $hash2 . '<br>';
		echo 'pwd: ' . $test2 . 'hash: ' . $hash3 . '<br>';
		echo 'pwd: ' . $test4 . 'hash: ' . $hash4 . '<br>';
		echo "<br>". "<br>";
		echo " <br> Empty string hash test: ";
		pwdCheck("", password_hash("", PASSWORD_DEFAULT));
		pwdCheck($test2, $hash2);
		pwdCheck($test3, $hash3);
		pwdCheck($test4, $hash4);
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
		
		<form method="POST">
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
<?php include 'footer.php'; ?>