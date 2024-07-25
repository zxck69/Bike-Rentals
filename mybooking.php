<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  // Redirect to the login page or any other desired page
  header('Location: login.php');
  exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

// Retrieve bookings for the logged-in user
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  // Use the $userId as needed
  //echo "user is  login";
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css" />
  <title>My Bookings</title>
</head>

<body>
  <div class="menu-bar">
    <h1 class="logo">Bike<span>Rentals</span></h1>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="about_us.php">About Us</a></li>
      <li>
        <a href="#">Vehicle <i class="fas fa-caret-down"></i></a>
        <div class="dropdown-menu">
          <ul>
          <li>
              <a href="index.php?type=bike">Bike</a>
            </li>
            <li>
              <a href="index.php?type=scooter">Scooter</a>
            </li>
          </ul>
        </div>
      </li>
      <li><a href="contact.php">Contact us</a></li>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
        <li><a href="#"><span>
              <div class="badge bg-primary text-wrap" style=""> Welcome
                <?php echo isset($_SESSION['name']) ? strtoupper($_SESSION['name']) : ''; ?>
                <i class="fas fa-caret-down"></i>
              </div>
            </span></a>
            <div class="dropdown-menu">
              <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="mybooking.php">My Bookings</a></li>
              </ul>
            </div>
        </li>
        <li><a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a></li>
      <?php } else { ?>
        <li><a href="login.php">Login / Register</a></li>
      <?php } ?>
    </ul>
  </div>

  <div class="hero">
    <main>
      <div class="container mt-5">
        <?php if (!empty($bookings)) { ?>
          <h2>My Bookings</h2>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Sr. No</th>
                <th scope="col">Booking ID</th>
                <th scope="col">Type</th>
                <th scope="col">Model</th>
                <th scope="col">Brand</th>
                <th scope="col">Color</th>
                <th scope="col">Vehicle Image</th>
                <th scope="col">Pickup Location</th>
                <th scope="col">Start Date</th>
                <th scope="col">Pickup Time</th>
                <th scope="col">End Date</th>
                <th scope="col">Dropoff Time</th>
                <th scope="col">Total Price</th>
              </tr>
            </thead>
            <tbody>
              <?php $counter = 1; ?>
              <?php foreach ($bookings as $booking) { ?>
                <?php
                  // Retrieve vehicle details
                  $vehicle_id = $booking['vehicle_id'];
                  $stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = :vehicle_id");
                  $stmt->bindParam(':vehicle_id', $vehicle_id);
                  $stmt->execute();
                  $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><?php echo $booking['id']; ?></td>
                  <td><?php echo $vehicle['type']; ?></td>
                  <td><?php echo $vehicle['brand']; ?></td>
                  <td><?php echo $vehicle['model']; ?></td>
                  <td><?php echo $vehicle['color']; ?></td>
                  <td><img src="./uploads/vehicles/<?php echo $vehicle['image']; ?>" alt="Vehicle Image" width="200"></td>
                  <td><?php echo $booking['pickup_location']; ?></td>
                  <td><?php echo $booking['start_date']; ?></td>
                  <td><?php echo $booking['pickup_time']; ?></td>
                  <td><?php echo $booking['end_date']; ?></td>
                  <td><?php echo $booking['dropoff_time']; ?></td>
                  <td><?php echo $booking['total_price']; ?></td>
                </tr>
                <?php $counter++; ?>
              <?php } ?>
            </tbody>
          </table>
        <?php } else { ?>
          <p>No bookings found.</p>
        <?php } ?>
      </div>
    </main>
  </div>

  <footer>
    <div class="footer-content">
      <p>&copy; 2023 BikeRentals. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>
