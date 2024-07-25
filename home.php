<?php
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

// Function to get the count of rows from a specific table
function getTableRowCount($conn, $tableName) {
  $sql = "SELECT COUNT(*) as count FROM $tableName";
  $stmt = $conn->query($sql);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row['count'];
}

// Get the number of users, vehicles, bookings, and customer feedback
$numUsers = getTableRowCount($conn, 'users');
$numVehicles = getTableRowCount($conn, 'vehicles');
$numBookings = getTableRowCount($conn, 'bookings');
$numFeedback = getTableRowCount($conn, 'contact_messages');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Home</title>
  <style>
    body {
      background-color: #f7f7f7;
      font-family: Arial, sans-serif;
    }

    .container {
      margin-top: 30px;
    }

    .card {
      background-color: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      border-radius: 8px;
    }

    .card-title {
      font-size: 1.9rem;
      font-weight: 600;
      margin-bottom: 10px;
      color: #333;
      text-align: center;
    }

    .card-text {
      font-size: 5rem;
      font-weight: 600;
      color: black;
      text-align: center;
    }

    .card-group {
      margin-bottom: 30px;
    }

    /* Add spacing between the cards */
    .card-group .card {
      margin-right: 20px;
    }

    /* Apply different background colors to the cards */
    .card-users {
      background-color: #ffcccb;
    }

    .card-vehicles {
      background-color: #90ee90;
    }

    .card-bookings {
      background-color: #add8e6;
    }

    .card-feedback {
      background-color: #ffa07a;
    }
  </style>
</head>

<body>
  <?php include 'newAdmin.php'; ?>

  <div class="container">
    <div class="card-group">
      <div class="card card-users">
        <div class="card-body">
          <h5 class="card-title">Number of Users</h5>
          <p class="card-text"><?php echo $numUsers; ?></p>
        </div>
      </div>
      <div class="card card-vehicles">
        <div class="card-body">
          <h5 class="card-title">Number of Vehicles</h5>
          <p class="card-text"><?php echo $numVehicles; ?></p>
        </div>
      </div>
      <div class="card card-bookings">
        <div class="card-body">
          <h5 class="card-title">Number of Bookings</h5>
          <p class="card-text"><?php echo $numBookings; ?></p>
        </div>
      </div>
      <div class="card card-feedback">
        <div class="card-body">
          <h5 class="card-title">Customer Feedback</h5>
          <p class="card-text"><?php echo $numFeedback; ?></p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
