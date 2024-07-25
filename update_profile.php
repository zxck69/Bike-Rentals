<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
  header('Location: login.php');
  exit;
}

// Include database connection
$servername = "localhost";
$username = "root";
$dbpassword = "";
$database = "bike";

// Create a new MySQLi instance
$conn = mysqli_connect($servername, $username, $dbpassword, $database);

// Check if the connection to the database is successful
if (!$conn) {
  die("Failed to connect to the database: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $userID = $_SESSION['user_id'];
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
  // Handle uploaded profile picture
  if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "./uploads/profile/";
    $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($imageFileType, $allowedTypes)) {
      $imageUniqueName = uniqid() . '_' . $_FILES['profile_picture']['name'];
      move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_dir . $imageUniqueName);

      // Update the profile picture path in the database
      $sql = "UPDATE users SET profile_picture=? WHERE id=?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "si", $imageUniqueName, $userID);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    } else {
      echo "Invalid file format. Please upload a valid image.";
    }
  }

  // Handle uploaded identification document
  if (isset($_FILES['identification']) && $_FILES['identification']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "./uploads/identification/";
    $target_file = $target_dir . basename($_FILES['identification']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    if (in_array($imageFileType, $allowedTypes)) {
      $imageUniqueName = uniqid() . '_' . $_FILES['identification']['name'];
      move_uploaded_file($_FILES['identification']['tmp_name'], $target_dir . $imageUniqueName);

      // Update the identification document path in the database
      $sql = "UPDATE users SET identification=? WHERE id=?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "si", $imageUniqueName, $userID);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    } else {
      echo "Invalid file format. Please upload a valid image.";
    }
  }

  // Handle uploaded driver's license
  if (isset($_FILES['license']) && $_FILES['license']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "./uploads/license/";
    $target_file = $target_dir . basename($_FILES['license']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is a valid image
    if (in_array($imageFileType, $allowedTypes)) {
      $imageUniqueName = uniqid() . '_' . $_FILES['license']['name'];
      move_uploaded_file($_FILES['license']['tmp_name'], $target_dir . $imageUniqueName);

      // Update the driver's license path in the database
      $sql = "UPDATE users SET license=? WHERE id=?";
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "si", $imageUniqueName, $userID);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    } else {
      echo "Invalid file format. Please upload a valid image.";
    }
  }

  // Update user information in the database
  $sql = "UPDATE users SET name=?, phone=?, address=? WHERE id=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $address, $userID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  // Redirect to the profile page after updating the information
  header('Location: profile.php');
  exit;
}

// Fetch user data from the database for the specified ID using prepared statement
$userID = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$userData = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <style>
    .profile-card-body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .profile-title {
      text-align: center;
    }
  </style>

  <link rel="stylesheet" href="style.css" />
  <title>Update Profile</title>
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
        <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card mb-3">
              <div class="card-body profile-card-body">
                <h4 class="card-title text-center profile-title">Update Profile</h4>
                <hr>
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                  <table class="table table-bordered table-sm">
                    <tbody>
                      <tr>
                        <th scope="row">Profile Picture</th>
                        <td>
                          <input type="file" name="profile_picture" accept="image/*" />
                          <?php if (!empty($userData['profile_picture'])): ?>
                            <img src="./uploads/profile/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture"
                              class="img-thumbnail rounded-circle" style="max-width: 150px;">
                          <?php else: ?>
                            No Profile Picture available
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Full Name</th>
                        <td><input type="text" name="name" value="<?php echo $userData['name']; ?>" required></td>
                      </tr>
                      <tr>
                        <th scope="row">Email</th>
                        <td><?php echo $userData['email']; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Phone Number</th>
                        <td><input type="text" name="phone" value="<?php echo $userData['phone']; ?>" required></td>
                      </tr>
                      <tr>
                        <th scope="row">Present Address</th>
                        <td><input type="text" name="address" value="<?php echo $userData['address']; ?>" required></td>
                      </tr>
                      <tr>
                        <th scope="row">Identification Document</th>
                        <td>
                          <input type="file" name="identification" accept="image/*" />
                          <?php if (!empty($userData['identification'])): ?>
                            <img src="./uploads/identification/<?php echo $userData['identification']; ?>" alt="Identification Document"
                              class="img-thumbnail" style="max-width: 150px;">
                          <?php else: ?>
                            No Identification Document available
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Driver's License</th>
                        <td>
                          <input type="file" name="license" accept="image/*" />
                          <?php if (!empty($userData['license'])): ?>
                            <img src="./uploads/license/<?php echo $userData['license']; ?>" alt="Driver's License"
                              class="img-thumbnail" style="max-width: 150px;">
                          <?php else: ?>
                            No Driver's License available
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="text-center">
                          <button type="submit" class="btn btn-primary">Save Changes</button>
                          <a href="profile.php" class="btn btn-danger">Cancel</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
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

  <!-- ... Your existing script links ... -->
</body>

</html>
