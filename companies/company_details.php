<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Company Registration</title>
  </head>
  <body>
    <form action="company_details_update.php" method="post" enctype="multipart/form-data">
      <label for="company-name">Company Name:</label>
      <input type="text" id="company-name" name="company-name" required>

      <label for="company-email">Company Email:</label>
      <input type="email" id="company-email" name="company-email" required>

      <label for="min-graduation">Minimum Graduation:</label>
      <select id="min-graduation" name="min-graduation" required>
        <option value="btech">B.Tech</option>
        <option value="mtech">M.Tech</option>
        <option value="phd">PhD</option>
        <option value="others">Others</option>
      </select>

      <label for="min-cpi">Minimum CPI:</label>
      <input type="number" id="min-cpi" name="min-cpi" step="0.01" required>

      <label for="interview-mode">Interview Mode:</label>
      <select id="interview-mode" name="interview-mode" required>
        <option value="online">Online</option>
        <option value="offline">Offline</option>
      </select>

      <label for="salary">Salary (LPA):</label>
      <input type="number" id="salary" name="salary" step="0.01" required>

      <label for="role">Role:</label>
      <select id="role" name="role" required>
        <option value="sde">SDE</option>
        <option value="ml-engineer">ML Engineer</option>
        <option value="research">Research</option>
        <option value="data-scientist">Data Scientist</option>
        <option value="analytics">Analytics</option>
        <option value="consultant">Consultant</option>
        <option value="hr">HR</option>
        <option value="core">Core</option>
      </select>

      <label for="placement-since">Placement Since Year:</label>
      <input type="number" id="placement-since" name="placement-since" min="1900" max="2099" step="1" value="2022" required>

      <label for="contact-name">Contact Person Name:</label>
      <input type="text" id="contact-name" name="contact-name" required>

      <label for="contact-email">Contact Person Email:</label>
      <input type="email" id="contact-email" name="contact-email" required>

      <button type="submit">Update Details</button>
    </form>

    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
    
        h2 {
            color: #008080;
            text-align: center;
        }
    
        form {
            margin: 0 auto;
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.2);
        }
    
        label {
            display: block;
            margin-bottom: 5px;
            color: #333333;
        }
    
        input[type=text],
        input[type=email],
        input[type=password],
        input[type=number],
        select {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #cccccc;
            box-sizing: border-box;
            font-size: 16px;
            color: #333333;
        }
    
        input[type=checkbox] {
            margin-right: 5px;
        }
    
        button[type=submit] {
            background-color: #008080;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
    
        button[type=submit]:hover {
            background-color: #005959;
        }
    </style>
    
  </body>
</html>

<?php
// start session
session_start();

// establish database connection
$conn = mysqli_connect("localhost", "newuser", "niibtarana", "dblab8");

// retrieve company data using email from session
$email = $_SESSION['company_email'];
$query = "SELECT * FROM company_database WHERE company_email = '$email'";
$result = mysqli_query($conn, $query);

// check if data exists for given email
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    // fill form inputs with company data
    echo '<script>
          document.getElementById("company-name").value = "'.$row["company_name"].'";
          document.getElementById("company-email").value = "'.$row["company_email"].'";
          document.getElementById("min-graduation").value = "'.$row["min_graduation"].'";
          document.getElementById("min-cpi").value = "'.$row["min_cpi"].'";
          document.getElementById("interview-mode").value = "'.$row["interview_process"].'";
          document.getElementById("salary").value = "'.$row["max_salary"].'";
          document.getElementById("role").value = "'.$row["role"].'";
          document.getElementById("placement-since").value = "'.$row["placement_since_year"].'";
          document.getElementById("contact-name").value = "'.$row["contact_person_name"].'";
          document.getElementById("contact-email").value = "'.$row["contact_person_email"].'";
          </script>';
}
mysqli_close($conn);
?>

