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

// Get form data and validate
$fname = test_input($_POST["fname"]);
$lname = test_input($_POST["lname"]);
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

// Check if email already exists in "users" table
$sql = "SELECT email FROM student_database WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die("Email already in use");
}

// Insert data into "users" table
$sql = "INSERT INTO users (first_name, last_name, email, password)
        VALUES ('$fname', '$lname', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    // Show success message and login button
    echo "<div class='success-message'>Account created Successfully!</div>";
    echo "<a class='login-button' href='login_main.php'>go to Login</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
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
