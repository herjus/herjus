<?php include 'mainHeader.php' ?>


<div class="webForm">
	<div class="webFormIn">
		<h1>Web Form Input</h1>
		<div class="webBox-1">
			<h1>Get Form - open</h1>
			<form method="GET" action="get_post.php">
				<div>
					<label>Name</label>
					<input type="text" name="firstName">
				</div>
				<div>
					<label>Last Name</label>
					<input type="text" name="lastName">
				</div>
				<input type="submit" name="Submit">
			</form>
		</div>

		<div class="webBox-1">
			<h1>Post Form - hidden</h1>
			<form method="POST" action="get_post.php">
				<div>
					<label>Name</label>
					<input type="text" name="firstName">
				</div>
				<div>
					<label>Last Name</label>
					<input type="text" name="lastName">
				</div>
				<input type="submit" name="Submit">
			</form>
		</div>
	</div>

	<div class="webFormOut">
		<h1>Web Form Output</h1>
		<div class="webBox-1">
			<h1>Get Form</h1>
			<?php 
			$firstName ='First Name: ';
			$lastName = 'Last Name: ';

			if(isset($_GET['Submit']))
			
			{
				$first = htmlentities($_GET['firstName']);
				$last = htmlentities($_GET['lastName']);
				echo $firstName . $first . '<br>'. $lastName . $last . '<br>' . 
					'String Query: ' . '<br>' . $_SERVER['QUERY_STRING'];
			}
			else{
				echo $firstName . '<br>'. $lastName;
			}
			?>
		</div>
		
		<div class="webBox-1">
			<h1>Post Form</h1>
			<?php 
			
			if(isset($_POST['Submit']))
			{
				$first = htmlentities($_POST['firstName']);
				$last = htmlentities($_POST['lastName']);
				echo $firstName . $first . '<br>' . $lastName . $last;
			}
			else{
				echo $firstName . '<br>'. $lastName;
			}
		?>
		</div>
	</div>
</div>

<div class="profileBox">
	<h1>
		<?php 
		if(isset($first) || isset($last)) {
			echo "{$first} {$last}'s profile";} 
			else echo "Welcome"; 
		?>
				
	</h1>
</div>


<?php include 'footer.php' ?>