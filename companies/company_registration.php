<?php
// Establish database connection
$servername = "localhost";
$username = "newuser";
$db_password = "niibtarana";
$dbname = "dblab8";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$email = $_POST['email'];
$company_name = $_POST['company_name'];
$first_password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($first_password != $confirm_password) {
  die("Error: Passwords do not match.");
}

// Check if email already exists in database
$email_check_query = "SELECT * FROM company_authentication WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn, $email_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // if user exists
  if ($user['email'] == $email) {
    die("Error: Email already exists.");
  }
}

// Hash password
$hashed_password = password_hash($first_password, PASSWORD_DEFAULT);

// Insert values into company_authentication table
$insert_auth_query = "INSERT INTO company_authentication (email, password) VALUES ('$email', '$hashed_password')";
mysqli_query($conn, $insert_auth_query);

// Get company_authentication id
$id_query = "SELECT id FROM company_authentication WHERE email='$email'";
$result = mysqli_query($conn, $id_query);
$row = mysqli_fetch_assoc($result);
$auth_id = $row['id'];

// Insert values into company_database table
$insert_db_query = "INSERT INTO company_database (id, company_name, company_email) VALUES ('$auth_id', '$company_name', '$email')";
mysqli_query($conn, $insert_db_query);

// Close database connection
mysqli_close($conn);

echo "Registration successful!";
echo "<a class='login-button' href='company_login_ui.php'>go to Login</a>";

?>
