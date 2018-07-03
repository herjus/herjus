<?php include 'mainHeader.php' ?>

<div class="main-1">
	<h2>String Fixing Function</h2>
	<div class= "testForm-1">
		<form method="POST">
			<input type="input" name="input" placeholder="Input" value="herJUs">
			<input type="name" name="name" placeholder="Name" value="risBakken">
			<input type="submit" name="submit1">
		</form>
		<div class="testBox">
			<?php
			
		    function fixString($string){
		        return $result = ucwords(mb_strtolower($string));
		    }
		    if(isset($_POST['submit1']))
		    {
		    	$testInput = fixString($_POST['input']);
		    	$testName = fixString($_POST['name']);
		    	echo "-" . $testInput . "-" . $testName . "-";
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
					$sql = "SELECT * FROM users WHERE user_uid=? OR user_email=?;";
	                //create the prepared statement
	                $stmt = mysqli_stmt_init($conn);

					$username = mysqli_real_escape_string($conn, fixString($_POST['username']));
					$email = mysqli_real_escape_string($conn, fixString($_POST['email']));
					
					mysqli_stmt_prepare($stmt, $sql);

					mysqli_stmt_bind_param($stmt, "ss", $username, $email);
			        //run parameters inside database
			        mysqli_stmt_execute($stmt);
			        $result = mysqli_stmt_get_result($stmt);
			        
			        $resultsCheck = mysqli_num_rows($result);
			        
			        while ($row = mysqli_fetch_assoc($result)) 
		            {
		                if(htmlentities($row['user_uid']) === $username) echo "Username exists in db";
		                if(htmlentities($row['user_email']) === $email) echo "<br> Email exists in db";
		            }
		            if($resultsCheck > 0);
	                else 
	                {
	                    $formFilledOkey = true;
	                    echo "Form filled out okey.";  
	                }
				}
			?>
			
		</div>
	</div>
	
	<div class="testForm-1">
		<h3>Char test</h3>
		<form method="GET">
			<?php 
			/*if(isset($_GET['submit4']))
			{
				$testname = $_GET['testname'];
				$testname = mysqli_real_escape_string($conn, fixString($_GET['testname']));
			}
			else $testname = "testname";*/
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
						$first = mysqli_real_escape_string($conn, fixString($name));
						if(isset($_REQUEST['testname']))
						{
							echo "request set: " . $_REQUEST['testname'] . '<br>';
						}
						
						echo "preg_match /^[a-zA-Z]*$/  Result: " . preg_match("/^[a-zA-Z]*$/", $name) . '<br>';
						echo "preg_match /^[a-åA-Å]*$/  Result: " . preg_match("/^[a-åA-Å]*$/", $name) . '<br>';
						echo "name: "." $name " . '<br>';
						
						echo "htmlspecialchars: "." $htmlspecialchars  " . '<br>';
						echo "htmlentities: "." $htmlentities " . '<br>';
						echo "mysqli_real_escape_string(conn, fixString(name)): "." $first " . '<br>';
					}
				
			 ?>
		</div>
		
	</div>
</div>


<?php include 'footer.php' ?>