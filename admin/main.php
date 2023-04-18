<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
  header("Location: login_main.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="main_page.css">
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
            // mysqli_close($db_conn);
        }
    ?>

<?php
// Replace database credentials with your own
require_once 'db_config.php';

// Check connection
if (!$db_conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create dropdown list
echo "<h2>Select Table:</h2>";
echo "<form method='post'>";
echo "<select name='table_name'>";
echo "<option value='student_auth'>Student</option>";
echo "<option value='alum_auth'>Alumni</option>";
echo "<option value='company_auth'>Company</option>";
echo "</select>";
echo "<br><br>";
echo "<input type='submit' value='Show Data'>";
echo "</form>";

// Show table data on submit
if (isset($_POST['table_name'])) {
    $table_name = $_POST['table_name'];
    $sql = "SELECT * FROM $table_name";

    if ($table_name == 'student_auth') {
        $sql .= "  JOIN student_database on student_auth.id = student_database.id";
        $sql .= "  JOIN student_pref on student_auth.id = student_pref.id";
        $sql .= "  JOIN student_placed on student_auth.id = student_pref.id";
        $sql .= "  JOIN student_marks on student_auth.id = student_marks.id";
    } elseif ($table_name == 'alum_auth') {
        $sql .= " JOIN alum_database on alum_auth.id = alum_database.id";
        $sql .= " JOIN alum_placed on alum_auth.id = alum_placed.id";
    } elseif ($table_name == 'company_auth') {
        $sql .= " JOIN company_database on company_auth.id = company_database.id";
        $sql .= " JOIN company_roles on company_auth.id = company_roles.id";
    } 

    $result = mysqli_query($db_conn, $sql);

    // Create table header with search fields
    echo "<h2>$table_name</h2>";
    echo "<form method='post'>";
    echo "<table>";
    echo "<tr>";
    $search_values = array(); // store search values for each column
    while ($column = mysqli_fetch_field($result)) {
        echo "<th>";
        echo "<input type='text' name='" . $column->name . "_search' placeholder='Search " . $column->name . "'>";
        echo "</th>";
        $search_values[$column->name] = ''; // initialize search value for each column
    }
    echo "<th><input type='submit' value='Search'></th>";
    echo "</tr>";

    // Process search and show table data
    if (isset($_POST['submit'])) {
        foreach ($search_values as $key => $value) {
            if (isset($_POST[$key . '_search'])) {
                $search_values[$key] = mysqli_real_escape_string($db_conn, $_POST[$key . '_search']); // get search value for each column
            }
        }
        $where_clause = '';
        foreach ($search_values as $key => $value) {
            if ($value != '') {
                if ($where_clause == '') {
                    $where_clause = "WHERE $key LIKE '%$value%'";
                } else {
                    $where_clause .= " AND $key LIKE '%$value%'";
                }
            }
        }
        if ($where_clause != '') {
            $sql .= " $where_clause";
        }
    }
    $result = mysqli_query($db_conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            echo "<td>" . $value . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
    echo "<input type='submit' name='submit' value='Search'>";
    echo "</form>";
}

// Close connection
mysqli_close($db_conn);

?>



</body>
</html>