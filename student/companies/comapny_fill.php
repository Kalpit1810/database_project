<?php
$servername = "localhost";
$username = "newuser";
$password = "niibtarana";
$dbname = "dblab8";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

  $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
  $company_description = mysqli_real_escape_string($conn, $_POST['company_description']);
  $min_qualification = mysqli_real_escape_string($conn, $_POST['min_qualification']);
  $salary_package = mysqli_real_escape_string($conn, $_POST['salary_package']);
  $mode_of_interview = mysqli_real_escape_string($conn, $_POST['mode_of_interview']);
  $recruitment_year = mysqli_real_escape_string($conn, $_POST['recruitment_year']);
  $contact_person_name = mysqli_real_escape_string($conn, $_POST['contact_person_name']);
  $contact_person_email = mysqli_real_escape_string($conn, $_POST['contact_person_email']);

  // Check if required fields are empty
  if(empty($company_name) || empty($salary_package) || empty($mode_of_interview) || empty($recruitment_year) || empty($contact_person_name) || empty($contact_person_email)){
    echo "Please fill all required fields";
  } else {
    // Handle logo upload
    if(isset($_FILES['company_logo'])){
      $file_name = $_FILES['company_logo']['name'];
      $file_size = $_FILES['company_logo']['size'];
      $file_tmp = $_FILES['company_logo']['tmp_name'];
      $file_type = $_FILES['company_logo']['type'];

      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      $extensions = array("jpeg","jpg","png");

      if(in_array($file_ext, $extensions) === false){
        echo "Extension not allowed, please choose a JPEG, JPG or PNG file.";
      } elseif($file_size > 2097152){
        echo "File size must be less than 2 MB";
      } else{
        $upload_path = "logos/";
        $new_file_name = uniqid('', true) . "." . $file_ext;
        $upload_path = $upload_path . $new_file_name;
        if(move_uploaded_file($file_tmp, $upload_path)){
          $company_logo = $new_file_name;

          // Insert data into the table
          $sql = "INSERT INTO company (company_name, company_logo, company_description, min_qualification, salary_package, mode_of_interview, recruitment_year, contact_person_name, contact_person_email)
                  VALUES ('$company_name', '$company_logo', '$company_description', '$min_qualification', '$salary_package', '$mode_of_interview', '$recruitment_year', '$contact_person_name', '$contact_person_email')";

          if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          }
        } else{
          echo "Error uploading file";
        }
      }
    } else {
      echo "Please upload a company logo";
    }
  }

// Close connection
mysqli_close($conn);
?>
