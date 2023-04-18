<?php
require_once 'db_config.php';

// Check connection
if ($db_conn->connect_error) {
    die("Connection failed: " . $db_conn->connect_error);
}

// Get form data and validate
$email = test_input($_POST["email"]);
$password = test_input($_POST["password"]);
$confirm_password = test_input($_POST["confirm_password"]);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Validate password strength
if (strlen($password) < 8) {
    die("Password must be at least 8 characters long");
}

// Validate password and confirm_password match
if ($password !== $confirm_password) {
    die("Passwords do not match");
}

// Hash password
$password = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists in "student_database" table
$sql = "SELECT email FROM admin_auth WHERE email='$email'";
$result = $db_conn->query($sql);

if ($result->num_rows > 0) {    
    die("Email already in use");
}                                

// Insert data into "student_authentication" table
$sql = "INSERT INTO admin_auth (id, email, password) VALUES (1, '$email', '$password')";

if ($db_conn->query($sql) !== TRUE) {
    die("Error: " . $sql . "<br>" . $db_conn->error);
}

// Get the ID of the newly inserted row
$student_id = $db_conn-> insert_id;
$db_conn->close();

// Function to validate user input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
