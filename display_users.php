<?php
session_start();

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  // Use the $userId as needed
 // echo "User is logged in";
} else {
  // User ID is not set in the session, handle the case accordingly
  //echo "User is not logged in";
}

$uploadDirectory = 'uploads/';

// Connect to the database (replace with your own credentials)
$servername = 'localhost';
$username = 'root';
$dbpassword = '';
$dbname = 'bike';

$conn = new mysqli($servername, $username, $dbpassword, $dbname);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Retrieve user data from the database
$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
  die('Error retrieving user data from the database: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css" />
  <title>User Profile</title>
  <style>
    
  </style>
</head>

<body>
<div class="menu-bar">
    <h1 class="logo">Bike<span>Rentals</span></h1>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#">About</a></li>
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
      <li><a href="#">Contact us</a></li>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
        <li><a href="#"><span>
              <div class="badge bg-primary text-wrap" style=""> Welcome
                <?php echo isset($_SESSION['name']) ? strtoupper($_SESSION['name']) : ''; ?>
                <i class="fas fa-caret-down"></i>
              </div>
            </span></a>
            <div class="dropdown-menu">
              <ul>
                <li><a href="#">Profile</a></li>
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

  </div>

<div class="container">
  <div class="card">
    <div class="card-img">
      <!-- Display user profile picture -->
      <?php while ($row = $result->fetch_assoc()): ?>
        <img src="<?php echo $uploadDirectory . 'profile/' . $row['profile_picture']; ?>" alt="Profile Picture">
      <?php endwhile; ?>
    </div>

    <div class="card-details">
      <!-- Display user details -->
      <?php mysqli_data_seek($result, 0); ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <h3>Name: <?php echo $row['name']; ?></h3>
        <p>Email: <?php echo $row['email']; ?></p>
        <p>Phone: <?php echo $row['phone']; ?></p>
        <p>Address: <?php echo $row['address']; ?></p>

        <?php $identification = $row['identification']; ?>
        <?php if (!empty($identification)): ?>
          <h3>Identification Document:</h3>
          <img src="<?php echo $uploadDirectory . 'identification/' . $identification; ?>" alt="Identification Document">
        <?php endif; ?>

        <?php $license = $row['license']; ?>
        <?php if (!empty($license)): ?>
          <h3>Driver's License:</h3>
          <img src="<?php echo $uploadDirectory . 'license/' . $license; ?>" alt="Driver's License">
        <?php endif; ?>
      <?php endwhile; ?>
    </div>
  </div>
</div>
</body>

</html>