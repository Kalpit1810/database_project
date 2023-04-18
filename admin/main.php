<?php
session_start();
// Check if user is logged in
// if (!isset($_SESSION['admin_id'])) {
//   header("Location: login_main.php");
//   exit();
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>MySQL Query</title>
    <style>
      
    input[type="text"] {
  width: 400px;
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f2f2f2;
}

form {
  margin: 20px 0;
}

table {
  border-collapse: collapse;
  width: 100%;
}

table th, table td {
  border: 1px solid #ccc;
  padding: 8px;
}

table th {
  background-color: #0072C6;
  color: #fff;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
}

h1 {
  font-size: 32px;
  color: #0072C6;
  text-align: center;
  margin-top: 50px;
  margin-bottom: 30px;
}

input[type="submit"] {
  background-color: #0072C6;
  color: #fff;
  padding: 8px 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

input[type="submit"]:hover {
  background-color: #00559F;
}

label {
  display: block;
  font-size: 18px;
  color: #0072C6;
  margin-bottom: 10px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #fff;
    background: white;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
}

.header-left {
    display: flex;
    align-items: center;
}

.header-right {
    display: flex;
    align-items: center;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    background-color: #333;
    color: #fff;
    padding: 14px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.dropbtn:hover {
    background-color: #555;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content button {
    color: #333;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    background-color: transparent;
    border: none;
    cursor: pointer;
}

.dropdown-content button:hover {
    background-color: #f1f1f1;
}

.logout-btn {
    color: #fff;
    background-color: #008080;
    border: none;
    border-radius: 4px;
    padding: 14px 20px;
    margin: 8px 0;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #005959;
}
.container {
  display: flex;
  justify-content: center;
}

    </style>
</head>
<body>
<header>
		<div class="header-left">
    <h1>MySQL Query</h1>
		</div>
		<div class="header-right">
			<div class="dropdown">
				<button class="dropbtn">other options</button>
				<div class="dropdown-content">
					<button onclick="location.href='logout.php';" class="logout-btn">Logout</button>
				</div>
			</div>
		</div>
	</header>
  <div class="container">
    <form method="post">
        <label for="query">Enter SQL Query:</label>
        <input type="text" id="query" name="query"><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

    <?php
        if(isset($_POST['query'])) {
            // Get the query from the form input and sanitize it
            $query = filter_input(INPUT_POST, 'query', FILTER_SANITIZE_STRING);

            // Check if the query is empty
            if(empty($query)) {
                echo "Query is empty.";
                exit();
            }

            // Connect to the MySQL server
            require_once 'db_config.php';

            // Prepare the query statement
            if(!($stmt = mysqli_prepare($db_conn, $query))) {
                echo "Error preparing query: " . mysqli_error($db_conn);
                exit();
            }

            // Execute the query and get the result
            if(!mysqli_stmt_execute($stmt)) {
                $error = mysqli_stmt_error($stmt);
                if (strpos($error, 'foreign key constraint fails') !== false) {
                    echo "Error executing query: Foreign key constraint violation";
                } else {
                    echo "Error executing query: " . $error;
                }
                mysqli_stmt_close($stmt);
                mysqli_close($db_conn);
                exit();
            }

            // Get the result and display it in a table
            if (!($result = mysqli_stmt_get_result($stmt))) {
                echo "Error getting result: " . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
                mysqli_close($db_conn);
                exit();
            }

            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                $first_row = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    if($first_row) {
                        // Display column names in the table
                        echo "<tr>";
                        foreach ($row as $key => $value) {
                            echo "<th>" . htmlspecialchars($key) . "</th>";
                        }
                        echo "</tr>";
                        $first_row = false;
                    }

                    // Display row data in the table
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";

                // Free the result variable
                mysqli_free_result($result);
            } else {
                echo "Query executed successfully, but no rows returned.";
            }

            

            // Close the statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($db_conn);
        }
    ?>
</body>
</html>