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

      /* CSS code for the company name */
      header span {
        margin-left: auto;
      }
    </style>
  </head>
  <body>

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

    <?php
      // Connect to database
      $db_host = "localhost"; // Change to your database host
      $db_username = "newuser"; // Change to your database username
      $db_password = "niibtarana"; // Change to your database password
      $db_name = "dblab8"; // Change to your database name
      
      $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      
      // Check if company details are completed
      $result = mysqli_query($conn, "SELECT completed FROM company_database WHERE id=1"); // Assuming the company details are stored in the 'company_details' table with ID 1
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

    <footer>
      &copy; 2023 Company Name. All rights reserved.
    </footer>
  </body>
</html>
