<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Company Details</title>
  </head>
  <body>
    <?php
      // Connect to database
      $db_host = "localhost"; // Change to your database host
      $db_username = "username"; // Change to your database username
      $db_password = "password"; // Change to your database password
      $db_name = "company_database"; // Change to your database name
      
      $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      
      // Check if company details are completed
      $result = mysqli_query($conn, "SELECT completed FROM company_details WHERE id=1"); // Assuming the company details are stored in the 'company_details' table with ID 1
      $row = mysqli_fetch_assoc($result);
      $completed = $row['completed'];
      
      if ($completed == 0) {
        // Company details are not completed
        echo "<p>Submit your complete details first.</p>";
      } else {
        // Company details are completed, show student data
        $result = mysqli_query($conn, "SELECT id, name, roll_no, cpi, graduation_year, salary FROM student_database");
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Roll No.</th><th>CPI</th><th>Graduation Year</th><th>Salary</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>".$row['id']."</td>";
          echo "<td>".$row['name']."</td>";
          echo "<td>".$row['roll_no']."</td>";
          echo "<td>".$row['cpi']."</td>";
          echo "<td>".$row['graduation_year']."</td>";
          echo "<td>".$row['salary']."</td>";
          echo "</tr>";
        }
        echo "</table>";
      }
      
      mysqli_close($conn); // Close database connection
    ?>

    <!-- header section -->
    <header>
      <img src="company_logo.png" alt="Company Logo" width="50" height="50">
      <span>Company Name</span>
      <div>
        <button>Submit Proposal</button>
        <button>Update Details</button>
        <button>Logout</button>
      </div>
    </header>

    <footer>
      &copy; 2023 Company Name. All rights reserved.
    </footer>
  </body>
</html>
