<?php
session_start();

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  // Use the $userId as needed
  //echo "user is  login";
} else {
  // User ID is not set in the session, handle the case accordingly
 // echo "user is not login";
}
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
  <title>Bike</title>

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
        <div class="row g-3">

          <?php
          // Database connection parameters
          $servername = "localhost";
          $username = "root";
          $dbpassword = "";
          $dbname = "bike";

          // Create a new PDO instance
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);

          // Retrieve the type query parameter from the URL
          $type = $_GET['type'] ?? '';

          // Modify the SQL query based on the vehicle type
          if ($type === 'bike') {
            $stmt = $conn->query("SELECT * FROM vehicles WHERE type = 'Bike' AND status = 1");
          } elseif ($type === 'scooter') {
            $stmt = $conn->query("SELECT * FROM vehicles WHERE type = 'Scooter' AND status = 1");
          } else {
            $stmt = $conn->query("SELECT * FROM vehicles WHERE status = 1");
          }
          
          $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Loop through the vehicles and display them
          foreach ($vehicles as $vehicle) {
            $image = $vehicle['image'];
            $brand = $vehicle['brand'];
            $model = $vehicle['model'];
            $price = $vehicle['price'];
            $description = $vehicle['description'];
            ?>

            <div class="col-12 col-md-6 col-lg-4">
              <div class="card">
                <img src="./uploads/vehicles/<?php echo $image; ?>" class="card-img-top" alt="..." width="400" height="500">
                <hr>
                <div class="card-body">
                  <h3 class="card-title">
                    <?php echo $brand; ?>
                  </h3>
                  <h3 class="card-title">
                    <?php echo $model; ?>
                  </h3>
                  <h3 class="card-title price">&#8377;
                    <?php echo $price; ?>/Day
                  </h3>
                  <p class="card-text">
                    <?php echo $description; ?>
                  </p>
                  <form action="BookNow.php" method="POST">
                    <button class="button-32" type="submit" name="book-now" value="<?php echo $vehicle['id']; ?>">Book
                      Now</button>
                  </form>
                </div>
              </div>
            </div>

            <?php
          }
          ?>

        </div>
      </div>
    </main>

  </div>

  &nbsp;

  <footer>
    <div class="footer-content">
      <p>&copy; 2023 BikeRentals. All rights reserved.</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>