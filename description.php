<?php # Script  - description.php
// This page allows the user to add a description.


	// Include the configuration file:
	require ('includes/config.inc.php'); 

	// Set the page title and include the HTML header:
	$page_title = 'Welcome to CMApp!';
	include ('includes/header.html');

	require (MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();

		
	// Validate the customer ...
	if ( isset($_POST['customer']) && filter_var($_POST['customer'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
		$c = $_POST['customer'];
	} else { // No customer selected.
		$errors[] = 'Please select a customer';
	}

	// Validate the customer...
	//$c = (!empty($_POST['customer'])) ? trim($_POST['customer']) : NULL;

	// Check for a description (not required):
	$d = (!empty($_POST['description'])) ? trim($_POST['description']) : NULL;
	
	if (empty($errors)) { // If everything's OK.

		// Add the print to the database:
		$q = 'INSERT INTO descriptions (customer, description) VALUES (?, ?)';
		$stmt = mysqli_prepare($dbc, $q);
		mysqli_stmt_bind_param($stmt, 'ss', $c, $d);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {

			// Print a message:
			echo '<p>The description has been added.</p>';
	
				
			// Clear $_POST:
			$_POST = array();
	
		} else { // Error!
			echo '<p style="font-weight: bold; color: #C00">Your submission could not be processed due to a system error.</p>'; 
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.
	
	
} // End of the submission IF.

// Check for any errors and print them:
if ( !empty($errors) && is_array($errors) ) {
	echo '<h1>Error!</h1>
	<p style="font-weight: bold; color: #C00">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo 'Please reselect a customer and try again.</p>';
}

// Display the form...
?>
<h1>Add a Description</h1>
<form enctype="multipart/form-data" action="description.php" method="post">

		
	<fieldset><legend>Fill out the form to add a description to the CMApp database:</legend>
	
	<p><b>Customer:</b> 
	<select name="customer"><option>Select One</option>
	<?php // Retrieve all the customers and add to the pull-down menu.
	$q = "SELECT customer_id, CONCAT_WS(' ', first_name, middle_name, last_name) FROM customers ORDER BY last_name, first_name ASC";		
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) > 0) {
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['customer']) && ($_POST['customer'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	} else {
		echo '<option>Please add a new customer first.</option>';
	}
	mysqli_close($dbc); // Close the database connection.
	?>
	</select></p>
	
	<p><b>Description:</b> <textarea name="description" cols="40" rows="10"><?php if (isset($_POST['description'])) echo $_POST['description']; ?></textarea> (optional)</p>
	
	</fieldset>
		
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>

</form>

</body>
</html>
<?php include ('includes/footer.html'); ?>