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

// Fetch data from the "vehicles" table
$stmt = $conn->prepare("SELECT * FROM vehicles ORDER BY id DESC");
$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["update_status"])) {
    $vehicleId = $_POST["vehicle_id"];
    $status = $_POST["status"];

    // Perform the update query
    $updateStmt = $conn->prepare("UPDATE vehicles SET status = :status WHERE id = :id");
    $updateStmt->bindParam(':status', $status);
    $updateStmt->bindParam(':id', $vehicleId);
    if ($updateStmt->execute()) {
      header('Location: view_all_vehicle.php');
    }
  }
}
// Handle the form submission for delete action
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   if (isset($_POST["delete_vehicle"])) {
//     $vehicleId = $_POST["vehicle_id"];

//     // Perform the delete query
//     $deleteStmt = $conn->prepare("DELETE FROM vehicles WHERE id = :id");
//     $deleteStmt->bindParam(':id', $vehicleId);
//     if ($deleteStmt->execute()) {
//       header('Location: view_all_vehicle.php');
//     }
//   }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Add the DataTable CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>View All Vehicle</title>
  <style>
    .container {
      margin-top: 30px;
    }
  </style>
</head>

<body>
  <?php include 'newAdmin.php'; ?>

  <div class="container">
    <h1>All Vehicles</h1>
    <!-- Add a table wrapper -->
    <div class="table-responsive">
      <table class="table" id="vehiclesTable">
        <thead>
          <tr>
            <th>Sr No.</th>
            <th>Vehicle ID</th>
            <th>Vehicle Type</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Color</th>
            <th>Year</th>
            <th>Price</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
            <!-- Add more vehicle details columns here if needed -->
          </tr>
        </thead>
        <tbody>
          <?php
          // Display the data in the table rows
          $sno = 1;
          foreach ($vehicles as $vehicle) {
            echo "<tr>";
            echo "<td>{$sno}</td>";
            echo "<td>{$vehicle['id']}</td>";
            echo "<td>{$vehicle['type']}</td>";
            echo "<td>{$vehicle['brand']}</td>";
            echo "<td>{$vehicle['model']}</td>";
            echo "<td>{$vehicle['color']}</td>";
            echo "<td>{$vehicle['year']}</td>";
            echo "<td>{$vehicle['price']}</td>";
            // Display the vehicle image
            echo "<td><img src='./uploads/vehicles/{$vehicle['image']}' alt='Vehicle Image' style='max-height: 100px; max-width: 100px;'></td>";

            // Display the Active Status with buttons
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='vehicle_id' value='{$vehicle['id']}'>";
            if ($vehicle['status'] == 1) {
              echo "<button type='submit' name='status' value='0' class='btn btn-success'>Active</button>";
            } else {
              echo "<button type='submit' name='status' value='1' class='btn btn-danger'>Inactive</button>";
            }
            // Add a hidden field for form submission
            echo "<input type='hidden' name='update_status' value='1'>";
            echo "</form>";
            echo "</td>";

            // Add buttons for Update and Delete actions
            //    echo "<td>
            //    <a href='update_vehicle.php?vehicle_id={$vehicle['id']}' class='btn btn-primary' style='background-color: #0066ff;'>Edit</a>
            //    <form method='post' onsubmit='return confirm(\"Are you sure you want to delete this vehicle?\")'>
            //      <input type='hidden' name='vehicle_id' value='{$vehicle['id']}'>
            //      <button type='submit' name='delete_vehicle' class='btn btn-danger'>Delete</button>
            //    </form>
            //  </td>";
            // Add more vehicle details columns here if needed
          
            // Add buttons for Update action
            echo "<td>
                        <a href='update_vehicle.php?vehicle_id={$vehicle['id']}' class='btn btn-primary' style='background-color: #0066ff;'>Edit</a>
                  </td>";
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
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function () {
      // Initialize the DataTable
      $('#vehiclesTable').DataTable();
    });
  </script>
</body>

</html>