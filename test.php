<?php include 'mainHeader.php' ?>

<div class="main-1">
	<h2>String Fixing Function</h2>
	<div class= "testForm-1">
		<form method="POST">
			<input type="input" name="input" placeholder="Input" value="herJUs">
			<input type="name" name="name" placeholder="Name" value="risBakken">
			<input type="submit" name="submit">
		</form>
	</div>

	<div class="testBox">
		<?php
		
	    function fixString($string){
	        return $result = ucwords(strtolower($string));
	    }
	    if(isset($_POST['submit']))
	    {
	    	$testInput = fixString($_POST['input']);
	    	$testName = fixString($_POST['name']);
	    	echo "-" . $testInput . "-" . $testName . "-";
	    }
	    

		?>
	</div>




	<div class="testForm-2">
		<h1>--</h1>
		<h3>FILTHER_VALIDATE_EMAIL</h3>
		<form method="POST">
			<input type="email" name="email" placeholder="email" value="herjus@hotmail.com">
			<input type="submit" name="submit2">
		</form>
		<DIV class="testBox">
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
		</DIV>
		


	</div>
	<div class="testForm-2">
		<h3>Server username/email check</h3>
		<form method="POST">
			<input type="text" name="username" placeholder="Username" value="herjus">
			<input type="text" name="email" placeholder="email" value ="herjus@hotmail.com">
			<button type="submit" name="testsubmit">test</button>
		</form>

		<?php 
			if(isset($_POST['testsubmit']))
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
			/*
			if(isset($_POST['testsubmit2']))
			{
				$sql = "SELECT * FROM users WHERE username=? OR email=?;";
	            //create the prepared statement
	            $stmt = mysqli_stmt_init($conn);
	            //prepare the prepared statement
	            if(!mysqli_stmt_prepare($stmt, $sql))
	            {
	                echo "Failure: SQL statement failed";
	            }
	            else
	            {
	                //bind parameters to the placeholder
	                mysqli_stmt_bind_param($stmt, "ss", $username, $email);
	                //run parameters inside database
	                mysqli_stmt_execute($stmt);
	                $result = mysqli_stmt_get_result($stmt);
	                
	                $resultsCheck = mysqli_num_rows($result);
	                while ($row = mysqli_fetch_assoc($result)) 
	                    {
	                        if(htmlentities($row['username']) === $username) echo "Username exists";
	                        if(htmlentities($row['email']) === $email) echo "<br> Email exists";
	                    }


	                if($resultsCheck > 0) echo "Username exists";
	                    else 
	                        {
	                            $formFilledOkey = true;
	                            echo "Form filled out okey.";  
	                        }
	    
	            }
			}*/
			
			
        ?>
	</div>
</div>


<div class="sidebar-2">
	<picture>
		<img src="images/trumpmarines.jpg">
	</picture>
</div>
<?php include 'footer.php' ?>