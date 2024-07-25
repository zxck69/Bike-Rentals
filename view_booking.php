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
$stmt = $conn->prepare("SELECT b.*, v.type, v.brand, v.model, v.color, u.name, u.email, u.phone, u.address 
                       FROM bookings AS b
                       INNER JOIN vehicles AS v ON b.vehicle_id = v.id
                       INNER JOIN users AS u ON b.user_id = u.id
                       ORDER BY b.created_at DESC");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Add the DataTable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <title>View Bookings</title>
  <style>
    .container {
      margin-top: 30px;
    }


    /* Set a fixed width for the columns that need more space */
    .table th:nth-child(7),
    .table td:nth-child(7),
    .table th:nth-child(10),
    .table td:nth-child(10) {
      min-width: 0px;
    }
  </style>
</head>

<body>
  <?php include 'newAdmin.php'; ?>

  <div class="container mt-4">
    <h1>Bookings Details</h1>
    <!-- ... Table wrapper (same as before) ... -->
    <div class="table-responsive">
      <table class="table" id="bookingsTable">
        <thead>
          <tr>
            <th>Sr No.</th>
            <th>Booking ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Vehicle Type</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Color</th>
            <th>Pickup Location</th>
            <th>Start Date</th>
            <th>Pickup Time</th>
            <th>End Date</th>
            <th>Dropoff Time</th>
            <th>Total Price</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Display the data in the table rows
          $sno = 1;
          foreach ($bookings as $booking) {
            echo "<tr>";
            echo "<td>{$sno}</td>";
            echo "<td>{$booking['id']}</td>";
            echo "<td>{$booking['name']}</td>";
            echo "<td>{$booking['email']}</td>";
            echo "<td>{$booking['phone']}</td>";
            echo "<td>{$booking['address']}</td>";
            echo "<td>{$booking['type']}</td>";
            echo "<td>{$booking['brand']}</td>";
            echo "<td>{$booking['model']}</td>";
            echo "<td>{$booking['color']}</td>";
            echo "<td>{$booking['pickup_location']}</td>";
            echo "<td>{$booking['start_date']}</td>";
            echo "<td>{$booking['pickup_time']}</td>";
            echo "<td>{$booking['end_date']}</td>";
            echo "<td>{$booking['dropoff_time']}</td>";
            echo "<td>{$booking['total_price']}</td>";
            echo "<td>{$booking['created_at']}</td>";
            echo "</tr>";
            $sno += 1;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Add the DataTable JS -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      // Initialize the DataTable
      $('#bookingsTable').DataTable();
    });
  </script>
</body>

</html>