<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  echo "<p>You are not logged in. Please <a href='login_main.php'>log in</a> to access this page.</p>";
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
	<title>Welcome</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
			text-align: center;
		}
		h1 {
			color: #333;
			margin-top: 50px;
			margin-bottom: 30px;
		}
		p {
			margin-bottom: 20px;
			color: #666;
			font-size: 16px;
		}
		button, input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s ease;
			margin-right: 10px;
		}
		button:hover, input[type="submit"]:hover {
			background-color: #45a049;
		}
		form {
			border: 2px solid #ccc;
			padding: 20px;
			background-color: #fff;
			max-width: 500px;
			margin: auto;
			box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
		}
		form input[type="submit"] {
			background-color: #ff3333;
		}
		form input[type="submit"]:hover {
			background-color: #e60000;
		}
	</style>
</head>
<body>
	<h1>Welcome <?php echo $user_first_name . ' ' . $user_last_name; ?>!</h1>
	<p>Your email is: <?php echo $user_email; ?></p>
	<form action="delete.php" method="post">
		<input type="submit" name="delete" value="Delete Account">
	</form>
	<!-- <button onclick="location.href='update_info.php'">Update</button> -->

    <form action="logout.php" method="post">
		<input type="submit" name="logout" value="Logout">
	</form>

</body>
</html>
