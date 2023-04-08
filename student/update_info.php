<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: login_main.php");
  exit();
}

// Retrieve user data from session
$user_email = $_SESSION['user_email'];
$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Information</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
		}
		form {
			border: 2px solid #ccc;
			padding: 20px;
			background-color: #fff;
			max-width: 500px;
			margin: auto;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		}
		h1 {
			text-align: center;
			color: #333;
			margin-top: 50px;
			margin-bottom: 30px;
		}
		label {
			display: block;
			margin-bottom: 10px;
			color: #666;
			font-size: 16px;
			font-weight: bold;
		}
		input[type="email"],
		input[type="text"],
		input[type="password"] {
			padding: 10px;
			border: none;
			border-radius: 4px;
			background-color: #f2f2f2;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
			margin-bottom: 20px;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s ease;
		}
		input[type="submit"]:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	<h1>Update Information</h1>
	<form action="update.php" method="POST">
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" value="<?php echo $user_email; ?>" readonly><br>
		<label for="fname">First Name:</label>
		<input type="text" id="fname" name="fname" value="<?php echo $user_first_name; ?>"><br>
		<label for="lname">Last Name:</label>
		<input type="text" id="lname" name="lname" value="<?php echo $user_last_name; ?>"><br>
		<label for="old_password">Old Password:</label>
		<input type="password" id="old_password" name="old_password"><br>
		<label for="new_password">New Password:</label>
		<input type="password" id="new_password" name="new_password"><br>
		<label for="confirm_password">Confirm New Password:</label>
		<input type="password" id="confirm_password" name="confirm_password"><br>
		<input type="submit" value="Update">
	</form>
</body>
</html>
