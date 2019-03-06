<?php # Script - index.php
// This is the main page for the site.

// Include the configuration file:
require ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to CMApp!';
include ('includes/header.html');

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '!</h1>';
?>
<p>CMApp is an excellent way to record your customer's information. To get started select the Customer page.</p>
<p>Thank you for using CMApp for managing your customer accounts!</p>

<?php include ('includes/footer.html'); ?>