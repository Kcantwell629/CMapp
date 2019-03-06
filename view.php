<?php # Script - view.php
// This page displays the customers.

// Set the page title and include the HTML header:
$page_title = 'View Customers';
include ('includes/header.html');

// Include the configuration file:
require ('includes/config.inc.php'); 

require (MYSQL);

// Default query for this page:
$q = "SELECT customers.customer_id, CONCAT_WS('', first_name, middle_name, last_name) AS customer_name, company, phone, description, description_id, customer_id, email, date_entered
FROM customers, descriptions WHERE customers.customer_id = descriptions.customer ORDER BY customers.last_name ASC";

// Are we looking at a particular customer?
if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	// Overwrite the query:
	$q = "SELECT customers.customer_id, CONCAT_WS('', first_name, middle_name, last_name) AS customer_name, company, phone, description, description_id, customer_id, email, date_entered
	FROM customers, descriptions WHERE customers.customer_id = descriptions.customer AND customers.customer_id={$_GET['cid']} ORDER BY customers.last_name ASC";

}

// Are we looking at a particular company?
if (isset($_GET['coid']) && filter_var($_GET['coid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	// Overwrite the query:
	$q = "SELECT customers.customer_id, CONCAT_WS('', first_name, middle_name, last_name) AS customer_name, company, phone, description, description_id, customer_id, email, date_entered
	FROM customers, descriptions WHERE customers.customer_id = descriptions.customer AND customers.customer_id={$_GET['coid']} ORDER BY customers.last_name ASC";

}

if (isset($_GET['desc_id']) && filter_var($_GET['desc_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	// Overwrite the query:
	$q = "SELECT descriptions.description_id, description FROM descriptions WHERE desc_id={$_GET['description_id']}";

}
// Define the description query.
//$query = "SELECT description_id, description FROM description WHERE id={$_GET['description_id']}";

// Create the table head:

echo '<table border="0" width="100%" cellspacing="10" cellpadding="5" align="right">
		<tr>
			<td align="left" width="20%"><b>Customer</b></td>
			<td align="left" width="20%"><b>Company</b></td>
			<td align="left" width="80%"><b>Description</b></td>
			<td align="left" width="20%"><b>Phone</b></td>
			<td align="left" width="40%"><b>Email</b></td>
			<td align="left" width="20%"><b>Date</b></td>
			<td align="left" width="20%"><b>Admin</b></td>
		</tr>';

// Display all the prints, linked to URLs:
$r = mysqli_query ($dbc, $q);
While ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
	
	// Display each record:
	echo "\t<tr>
		<td align=\"left\"><a href=\"view.php?cid={$row['customer_id']}\">{$row['customer_name']}</a></td>
		<td align=\"left\"><a href=\"view.php?coid={$row['customer_id']}\">{$row['company']}</a></td>
		<td align=\"left\">{$row['description']}</td>
		<td align=\"left\">{$row['phone']}</td>
		<td align=\"left\"><a href=\"mailto:{$row['email']}\">{$row['email']}</td>
		<td align=\"left\">{$row['date_entered']}</td>
		
		<td align=\"left\"><a href=\"edit.php?desc_id={$row['description_id']}\">Edit</a><-><a href=\"delete_customer.php?desc_id={$row['description_id']}\">Delete</a></td>
					
	</tr>\n";
	

} // End of While loop.

echo '</table>';
mysqli_close($dbc);
include ('includes/footer.html');
?>




















