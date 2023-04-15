<!DOCTYPE html>
<html>
<head>
	<title>Page Title</title>
	<link rel="stylesheet" href="main_page.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<header>
		<img src="logo.png" alt="Logo">
		<nav>
			<a href="/student/login_main.php">Login</a>
			<a href="/student/registration.html">Register</a>
		</nav>
	</header>
	
	<main>
    <h1>Placement Graph</h1>
	<form>
		<label for="year">Select a year:</label>
		<select id="year" name="year">
			<?php
			// Create options for the last 3 years
			for ($i = 0; $i < 3; $i++) {
				$year = date("Y") - $i;
				echo "<option value='$year'>$year</option>";
			}
			?>
		</select>
		<input type="submit" value="Update">
	</form>
	<?php
	// Connect to the database
	require_once 'db_config.php';

	// Check connection
	if ($db_conn->connect_error) {
		die("Connection failed: " . $db_conn->connect_error);
	}

	// Get the selected year from the form
	$selected_year = $_GET["year"];

	// Query to fetch data for the selected year
	$sql = "SELECT alum_company.company_name, COUNT(*) as count FROM alum_database JOIN alum_company ON alum_database.id = alum_company.alum_database_id WHERE YEAR(alum_company.start_date) = $selected_year GROUP BY alum_company.company_name";

	$result = $db_conn->query($sql);

	// Initialize arrays to store data
	$company_names = array();
	$counts = array();

	if ($result->num_rows > 0) {
		// Fetch data and store in arrays
		while($row = $result->fetch_assoc()) {
			array_push($company_names, $row["company_name"]);
			array_push($counts, $row["count"]);
		}
	} else {
		echo "No results";
	}

	$db_conn->close();
	?>

	<!-- Display the graph using JavaScript -->
	<div id="chart-container">
		<canvas id="myChart"></canvas>
	</div>

	<script>
		var ctx = document.getElementById('myChart').getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($company_names); ?>,
				datasets: [{
					label: '# of Placements',
					data: <?php echo json_encode($counts); ?>,
					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				},
				plugins: {
					title: {
						display: true,
						text: 'Placement Graph for <?php echo $selected_year; ?>'
					}
				}
			}
		});
	</script>
	</main>

	<footer>
		<p>© 2023 Example Company</p>
		<nav>
			<a href="#">About Us</a>
			<a href="#">Terms of Service</a>
			<a href="#">Privacy Policy</a>
		</nav>
	</footer>
</body>
</html>