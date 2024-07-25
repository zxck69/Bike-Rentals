<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Redirect the user to the login page
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the selected vehicle ID
  $selectedVehicleId = $_POST['book-now'];
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // Use the $userId as needed
    // echo "user is  login";
    // Assuming you retrieve the user ID from the $_SESSION variable
  }

  // Retrieve the selected pickup location
  $pickupLocation = $_POST['pickup-location'];

  // Establish a database connection
  $servername = "localhost";
  $username = "root";
  $dbpassword = "";
  $dbname = "bike";

  $conn = new mysqli($servername, $username, $dbpassword, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Fetch vehicle data from the database
  $sql = "SELECT * FROM vehicles WHERE id = $selectedVehicleId";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Store the fetched data in variables

    $type = $row["type"];
    $brand = $row["brand"];
    $model = $row["model"];
    $color = $row["color"];
    $year = $row["year"];
    $price = $row["price"];
    $description = $row["description"];
    $image = $row["image"];

    // Process the booking
    $startDate = $_POST['start-date'] ?? '';
    $pickupTime = $_POST['pickup-time'] ?? '';
    $endDate = $_POST['end-date'] ?? '';
    $dropoffTime = $_POST['dropoff-time'] ?? '';
    $totalPrice = $_POST['total-price'] ?? '';

    // Here, you can add the logic to store the booking information in your database or perform any additional actions required for the booking process.

    // For demonstration purposes, let's assume the booking information is stored in a bookings table
    $bookingSql = "INSERT INTO bookings (vehicle_id, user_id, pickup_location, start_date, pickup_time, end_date, dropoff_time, total_price) VALUES ('$selectedVehicleId', '{$_SESSION['user_id']}', '$pickupLocation', '$startDate', '$pickupTime', '$endDate', '$dropoffTime', '$totalPrice')";

    if ($conn->query($bookingSql) === TRUE) {
      // echo "Booking created successfully";
      // Fetch the inserted booking ID from the database
      $bookingQuery = "SELECT id FROM bookings WHERE id = {$conn->insert_id}";
      $bookingResult = $conn->query($bookingQuery);
      if ($bookingResult && $bookingResult->num_rows > 0) {
        $bookingRow = $bookingResult->fetch_assoc();
        $bookingId = $bookingRow["id"];
        // Update the status of the booked vehicle to inactive (status = 0)
    $updateStatusSql = "UPDATE vehicles SET status = 0 WHERE id = $selectedVehicleId";
    if ($conn->query($updateStatusSql) === TRUE) {
      // echo "Vehicle status updated successfully";
    } else {
      echo "Error updating vehicle status: " . $conn->error;
    }
      }
    } else {
      echo "Error creating booking: " . $conn->error;
    }
  } else {
    echo "No vehicle data found";
  }


  $conn->close();
} else {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Booking Success</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    html,
    body {
      height: 100%;
      margin-top: 55px;
    }

    .card {
      margin-top: 200px;
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .booking-details p strong {
      font-weight: bold;
    }
  </style>
</head>

<body>
  <div class="card">
    <h2 class="card-title text-center">Booking Success</h2>
    <hr>
    <div class="card-body">
      <h4>
        <p class="text-success text-center">Congratulations! Your booking is confirmed.</p>
      </h4>
<hr>
      <!-- Additional booking information or confirmation details can be displayed here -->
      <!-- For example: -->
      <div class="booking-details">
        <p><strong>Booking ID:</strong>
          <?php echo $bookingId; ?>
        </p>
        <p><strong>Vehicle Type:</strong>
          <?php echo $type; ?>
        </p>
        <p><strong>Brand:</strong>
          <?php echo $brand; ?>
        </p>
        <p><strong>Model:</strong>
          <?php echo $model; ?>
        </p>
        <p><strong>Color:</strong>
          <?php echo $color; ?>
        </p>
        <p><strong>Year:</strong>
          <?php echo $year; ?>
        </p>
        <p><strong>Price:</strong> &#8377;
          <?php echo $price; ?>/day
        </p>
        <p><strong>Total Amount:</strong> &#8377; <?php echo number_format($totalPrice, 2); ?></p>
        <!-- <p><strong>Description:</strong> <?php echo $description; ?></p> -->
      </div>
      <img src="./uploads/vehicles/<?php echo $image; ?>" alt="Vehicle Image" style="max-width: 100%;">
      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-primary">Back to Home</a>
      </div>
      <div class="text-center mt-3">
        <form action="logout.php" method="POST">
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>