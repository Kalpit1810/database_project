<?php
if (!isset($_SESSION['company_id'])) {
    header("Location: company_login_ui.php");
    exit();
}

// database connection parameters
$servername = "localhost";
$username = "newuser";
$password = "niibtarana";
$dbname = "dblab8";

// create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// retrieve form data using POST method
$company_name = $_POST["company-name"];
$company_email = $_POST["company-email"];
$min_graduation = $_POST["min-graduation"];
$min_cpi = $_POST["min-cpi"];
$interview_process = $_POST["interview-mode"];
$max_salary = $_POST["salary"];
$placement_since_year = $_POST["placement-since"];
$contact_person_name = $_POST["contact-name"];
$contact_person_email = $_POST["contact-email"];
$role = $_POST["role"];

// retrieve company_id from session
session_start();
$company_id = $_SESSION["company_id"];
session_write_close();

// check if any field is empty
if ( empty($min_graduation) || empty($min_cpi) || empty($interview_process) || empty($max_salary) || empty($placement_since_year) || empty($contact_person_name) || empty($contact_person_email) || empty($role)) {
    die("Error: All fields are required.");
}

// check if company exists in the table
$sql = "SELECT * FROM company_database WHERE id = '$company_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    // update company data
    $sql = "UPDATE company_database SET  min_graduation = '$min_graduation', min_cpi = '$min_cpi', interview_process = '$interview_process', max_salary = '$max_salary', placement_since_year = '$placement_since_year', contact_person_name = '$contact_person_name', contact_person_email = '$contact_person_email', role = '$role', completed = 1  WHERE id = '$company_id'";
    
    if (mysqli_query($conn, $sql)) {
        // send confirmation email to contact person
        $to = $contact_person_email;
        $subject = "Registration Confirmation";
        $message = "Dear $contact_person_name,\n\nThank you for registering your company $company_name with us.\n\nWe have updated your company details in our database.\n\nBest regards,\nThe Company Registration Team";
        $headers = "From: webmaster@example.com" . "\r\n" .
                   "Reply-To: webmaster@example.com" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        mail($to, $subject, $message, $headers);
        
        header('Location: company_webpage.php');
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "Company not found.";
}

mysqli_close($conn);
?>