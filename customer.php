<?php # Script  - customer.php // This page allows the administrator to add a customer.

	// Include the configuration file:
	require ('includes/config.inc.php'); 

	// Set the page title and include the HTML header:
	$page_title = 'Welcome to CMApp!';
	include ('includes/header.html');

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{// Handle the form.
		
		// Validate the data (none required):
		$fn = (!empty($_POST['first_name'])) ?
		trim($_POST['first_name']) : NULL;
		$mn = (!empty($_POST['middle_name'])) ?
		trim($_POST['middle_name']) : NULL;
		$t = (!empty($_POST['title'])) ?
		trim($_POST['title']) : NULL;
		$c = (!empty($_POST['company'])) ?
		trim($_POST['company']) : NULL;
		$e = (!empty($_POST['email'])) ?
		trim($_POST['email']) : NULL;
		$p = (!empty($_POST['phone'])) ?
		trim($_POST['phone']) : NULL;
		
		// Check for a last_name...
		if (!empty($_POST['last_name'])) {
		
			$ln = trim($_POST['last_name']);
			
			// Add the customer to the database:
			require (MYSQL);
			$q = 'INSERT INTO customers (first_name, middle_name, last_name, title, company, email, phone)
			VALUES (?,?,?,?,?,?,?)';
			$stmt = mysqli_prepare($dbc, $q);
			mysqli_stmt_bind_param($stmt, 'sssssss', $fn, $mn, $ln, $t, $c, $e, $p);
			mysqli_stmt_execute($stmt);
			
			// Check the results...
			if (mysqli_stmt_affected_rows($stmt) == 1) {
				echo '<p>The customer has been added.</p>';
				$_POST = array();
				} else { // Error!
					$error = 'The new customer could not be added to the database!';
				}
			
				// Close this prepared statement:
				mysqli_stmt_close($stmt);
				mysqli_close($dbc); // Close the database connection.

		} else { // No last name value.
			$error = 'Please enter the customer\'s name!';
		}
				
} // End of submission IF.

// Check for an error and print it:

if (isset($error)) {
	echo '<h1>Error!<h1>
	<p style="font-weight: bold; color: #C00">' . $error . ' Please try again.</p>';
	
}

// Display the form...

?>
<h1> Add a Customer</h1>
<form action="customer.php" method="post">

	<fieldset><legend>Fill out the form to add a customer:</legend>

		<p><b>First Name:</b> <input type"text" name="first_name" size="20" maxlength="20" 
		value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name'];  ?>" /></p>
		<p><b>Middle Name:</b> <input type"text" name="middle_name" size="20" maxlength="20" 
		value="<?php if (isset($_POST['middle_name'])) echo $_POST['middle_name'];  ?>" /></p>
		<p><b>Last Name:</b> <input type"text" name="last_name" size="20" maxlength="40" 
		value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name'];  ?>" /></p>
		<p><b>Title:</b> <input type"text" name="title" size="20" maxlength="40" 
		value="<?php if (isset($_POST['title'])) echo $_POST['title'];  ?>" /></p>
		<p><b>Company:</b> <input type"text" name="company" size="20" maxlength="40" 
		value="<?php if (isset($_POST['company'])) echo $_POST['company'];  ?>" /></p>
		<p><b>Email:</b> <input type"text" name="email" size="20" maxlength="40" 
		value="<?php if (isset($_POST['email'])) echo $_POST['email'];  ?>" /></p>
		<p><b>Phone:</b> <input type"text" name="phone" size="20" maxlength="40" 
		value="<?php if (isset($_POST['phone'])) echo $_POST['phone'];  ?>" /></p>

	</fieldset>

	<div align="center"><input type="submit" name="submit" value="submit" /></div>

</form>

</body>
</html>
<?php include ('includes/footer.html'); ?>