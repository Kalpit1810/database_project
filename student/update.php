<?php
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

$email = test_input($_POST["email"]);
$fname = test_input($_POST["fname"]);
$lname = test_input($_POST["lname"]);
$old_password = $_POST["old_password"];
$new_password = $_POST["new_password"];
$confirm_password = $_POST["confirm_password"];

// Check if email exists in "users" table
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	// Email exists, retrieve user info
	$row = $result->fetch_assoc();
	$password_hash = $row["password"];

	// Verify old password
	if (password_verify($old_password, $password_hash)) {
		// Check if new password matches confirm password
		if (!empty($new_password)) {
			if ($new_password == $confirm_password) {
				$new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
				$sql = "UPDATE student_database SET first_name='$fname', last_name='$lname', password='$new_password_hash' WHERE email='$email'";
			} else {
				echo "New password does not match confirm password";
				exit();
			}
		} else {
			$sql = "UPDATE users SET first_name='$fname', last_name='$lname' WHERE email='$email'";
		}

		if ($conn->query($sql) === TRUE) {
			echo "Information updated successfully";
		} else {
			echo "Error updating information: " . $conn->error;
		}
	} else {
		echo "Incorrect old password";
	}
} else {
	// Email does not exist, show error message
	echo "Email does not exist";
}

$conn->close();

// Function to validate user input data
function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
