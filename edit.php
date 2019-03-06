<?php // Script edit.php
/* This script edits a customers description. */

// Include the configuration file:
require ('includes/config.inc.php');

// Set the page title and include the HTML header:
$page_title = 'Edit Customers';
include ('includes/header.html');

print '<h2>Edit a Description</h2>';

// The database connection.
require (MYSQL);

if (isset($_GET['desc_id']) && is_numeric($_GET['desc_id']) && ($_GET['desc_id'] > 0)) {
	// Display in a form:

	// Define the query.
	$query = "SELECT customers.customer_id, CONCAT_WS('', first_name, middle_name, last_name) AS customer_name, description
	FROM customers, descriptions WHERE description_id={$_GET['desc_id']}";

	if ($r = mysqli_query($dbc, $query)) { // Retrieve the information.
	
		$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

		// Make the form:
		print '<form action="edit.php" method="post">
		<p><label>' . $row['customer_name'] . '</label></p>
		<p><label>Description <textarea name="description" rows="5" cols="30">' . htmlentities($row['description']) . '</textarea></label></p>
		<input type="hidden" name="desc_id" value="' . $_GET['desc_id'] . '">
		<p><input type="submit" name="submit" value="Udate This Description!"></p>
		</form>';

	} else { // Couldn't get the information:
		print '<p class="error">Could not retrieve the description because:<br>' . mysqli_error($dbc) . '.</p>
		<p>The query being run was: ' . $query . '</p>';
	
	}

} elseif (isset($_POST['desc_id']) && is_numeric($_POST['desc_id']) && ($_POST['desc_id'] > 0)){ // Handle the form:
	
	if (!empty($_POST['description'])) {
	
	// Prepare updated description for storing.

	$desc = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['description'])));

	// Define the query:
	$query = "UPDATE descriptions SET description='$desc' WHERE description_id={$_POST['desc_id']}";

	if ($result = mysqli_query($dbc, $query)){
		print '<h3>The description has been updated!</h3>';
	} else {
		print '<p class=\"error\">Could not update description:<br>' . mysqli_error($dbc) . '.</p>
		<p>The query being run was: ' . $query .'</p>';
	}

	} // No problem!
} else {
	print '<p class=\"error\">This page has been accessed in error.</p>';
}

mysqli_close($dbc);
include ('includes/footer.html');
?>