<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login_main.php");
  exit();
}

// Retrieve user data from session
$user_email = $_SESSION['user_email'];

if (isset($_POST['delete'])) {
	// Display confirmation message
	echo "<p>Are you sure you want to delete your account?</p>";
	echo "<form action='delete.php' method='post'>";
	echo "<input type='submit' name='confirm_delete' value='Yes'>";
	echo "<input type='submit' name='cancel_delete' value='No'>";
	echo "</form>";
} elseif (isset($_POST['confirm_delete'])) {
	// Delete user data from "users" table
	$servername = "localhost";
	$username = "newuser";
	$password = "niibtarana";
	$dbname = "dblab8";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "DELETE FROM users WHERE email='$user_email'";
	if ($conn->query($sql) === TRUE) {
		// Delete user session data and redirect to login page
		session_unset();
		session_destroy();
		echo "<div class='success-message'>Registration Successful!</div>";
        echo "<a class='login-button' href='login_main.php'>Login</a>";
		exit();
	} else {
		echo "Error deleting account: " . $conn->error;
	}

	$conn->close();
} elseif (isset($_POST['cancel_delete'])) {
	// Redirect to welcome page
	header("Location: welcome.php");
	exit();
} else {
	// Redirect to welcome page
	header("Location: welcome.php");
	exit();
}
?>
