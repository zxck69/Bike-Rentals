<?
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin</title>

	<link rel="stylesheet" type="text/css" href="admin.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
  <!-- Add the DataTable CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> -->

	<style>
		/* Add custom styles here */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
      
		}

		/* Navbar styles */
		.header {
			background-color: #1a1a1a; /* Dark color */
			color: white; /* White font color */
			line-height: 70px;
			padding-left: 30px;
			font-size: 24px; /* Increased font size */
		}

		.header a, .header a:hover {
			text-decoration: none!important;
			color: white;
			font-weight: bold;
		}

		.logout {
			float: right;
			padding-right: 30px;
		}

		/* Sidebar styles */
		aside {
			background-color: #1a1a1a;
			width: 16%;
			height: 100%;
			position: fixed;
			padding-top: 0%;
			text-align: center;
			left: -16%; /* Move sidebar off-screen */
			transition: left 0.3s ease; /* Add transition effect */
		}

		/* Show the sidebar when the class "show-sidebar" is applied */
		.show-sidebar {
			left: 0;
		}

		ul {
			list-style: none;
			padding-bottom: 30px;
			font-size: 20px;
		}

		ul li a {
			color: white;
		}

		ul li a:hover {
      
			color: red;
			text-decoration: none;
		}

		.content {
			margin-left: 10%;
			margin-top: 3%;
      
      
      /* display: flex;  */
		}
	</style>
</head>
<body>
	<!-- Navbar -->
	<header class="header">
		<!-- Add toggle button for the sidebar -->
    <a href="#">Admin Dashboard</a>
    &nbsp;&nbsp;&nbsp;
		<a href="#" id="sidebarToggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
		<div class="logout">
			<a href="admin_logout.php" class="btn btn-success">Logout</a>
		</div>
	</header>

	<!-- Sidebar -->
	<aside id="sidebar">
		<ul>
			<li><a href="home.php">Home</a></li>
			<li><a href="Admin_AddNewVehicle.php">Add New Vehicle</a></li>
			<li><a href="view_all_vehicle.php">View All Vehicle</a></li>
			<li><a href="view_booking.php">View Bookings</a></li>
			<li><a href="report.php">Report</a></li>
			<li><a href="customer_details.php">Customer Details</a></li>
			<li><a href="customer_feedback.php">Customer Feedback</a></li>
		</ul>
	</aside>

	<!-- Main Content -->
	<div class="content">
	
    <?php include 'AddNewVehicle.php'; ?>
		
	</div>

	<script>
		// Function to toggle the sidebar
		document.getElementById('sidebarToggle').addEventListener('click', function () {
			var sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('show-sidebar');
		});
	</script>
</body>
</html>
