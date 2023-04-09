<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Company Details</title>
    <style>
      /* CSS code for the header */
      header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #0077b6;
        color: white;
        padding: 10px;
      }

      /* CSS code for the main content */
      main {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 20px;
      }

      label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
      }

      input {
        padding: 5px;
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 3px;
      }

      /* CSS code for the buttons */
      button {
        background-color: #0077b6;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
      }

      button:hover {
        background-color: #004b87;
      }

      /* CSS code for the footer */
      footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        position: fixed;
        bottom: 0;
        width: 100%;
      }
</style>

  <style>

  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  th {
    background-color: #4CAF50;
    color: white;
  }
    </style>
  </head>
  <body>

<!-- header section -->
<header>
  <?php
  
  if (!isset($_SESSION['company_id'])) {
    header("Location: company_login_ui.php");
    exit();
}

    // Connect to database
    $db_host = "localhost"; // Change to your database host
    $db_username = "newuser"; // Change to your database username
    $db_password = "niibtarana"; // Change to your database password
    $db_name = "dblab8"; // Change to your database name
    
    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
    
    // Get the company name from the company_database table using the company_email stored in session
    session_start();
    $company_email = $_SESSION['company_email'];
    $result = mysqli_query($conn, "SELECT company_name FROM company_database WHERE company_email='$company_email'");
    $row = mysqli_fetch_assoc($result);
    $company_name = $row['company_name'];
    
    // Close database connection
    mysqli_close($conn);
    
    // Show the company name in the header
    echo "<span>".$company_name."</span>";
  ?>
  <div>
    <button onclick="window.location.href='company_details.php'">Update Details</button>
    <form action="logout.php" method="post">
		<input type="submit" name="logout" value="Logout">
	</form>
  </div>
</header>

<?php
  // Connect to database
  $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  // Check if company details are completed
  // $result = mysqli_query($conn, "SELECT completed FROM company_database WHERE id=1"); // Assuming the company details are stored in the 'company_details' table with ID 1
  // $row = mysqli_fetch_assoc($result);
  // $completed = $row['completed'];
  
  // if ($completed == 0) {
  //   // Company details are not completed
  //   echo "<p>Submit your complete details first.</p>";
  // } else {
    // Company details are completed, show student data
    echo "<h2>Eligible students</h2>";
    $result = mysqli_query($conn, "SELECT s.id, s.student_name, s.rollno, s.cpi, s.graduation_year, s.salary 
    FROM student_database s, company_database c 
    WHERE s.cpi > c.min_cpi AND s.qualification = c.min_graduation");
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Roll No.</th><th>CPI</th><th>Graduation Year</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>".$row['id']."</td>";
      echo "<td>".$row['student_name']."</td>";
      echo "<td>".$row['rollno']."</td>";
      echo "<td>".$row['cpi']."</td>";
      echo "<td>".$row['graduation_year']."</td>";
      echo "</tr>";
    }
    echo "</table>";
  // }
  
  // Close database connection
  mysqli_close($conn);
?>


<footer>
  &copy; 2023 Company Name. All rights reserved.
</footer>
</body>

</html>
