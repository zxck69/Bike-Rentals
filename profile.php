<?php
session_start();

// Define variables to hold error messages and user data
$errorMessage = '';

// Connect to the database
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

if (isset($_SESSION['user_id'])) {
  $userID = $_SESSION['user_id'];

  // Fetch user data from the database for the specified ID using prepared statement
  $sql = "SELECT * FROM users WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);

  // Bind the parameter (userID) to the prepared statement
  mysqli_stmt_bind_param($stmt, "i", $userID);

  // Execute the prepared statement
  $result = mysqli_stmt_execute($stmt);

  // Check if the query was successful
  if (!$result) {
    $errorMessage = "Error fetching user data: " . mysqli_error($conn);
  } else {
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);
  }
} else {
  // User ID not set in session
  echo "User ID not set.";
  header('Location: login.php');

  exit;
}

// Close the prepared statement
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
  <title>User Profiles</title>
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
            <?php while ($userData = mysqli_fetch_assoc($result)): ?>
              <div class="card mb-3">
                <div class="card-body profile-card-body">
                  <h4 class="card-title text-center profile-title">Profile Information</h4>
                  <hr>
                  <table class="table table-bordered table-sm">
                    <tbody>
                      <tr>
                        <th scope="row">Profile Picture</th>
                        <td>
                          <?php if (!empty($userData['profile_picture'])): ?>
                            <a href="#" data-toggle="modal" data-target="#profileModal<?php echo $userData['id']; ?>">
                              <img src="uploads/profile/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture"
                                class="img-thumbnail rounded-circle" style="max-width: 150px;">
                            </a>
                          <?php else: ?>
                            No Profile Picture available
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Full Name</th>
                        <td>
                          <?php echo $userData['name']; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Email</th>
                        <td>
                          <?php echo $userData['email']; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Phone Number</th>
                        <td>
                          <?php echo $userData['phone']; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Present Address</th>
                        <td>
                          <?php echo $userData['address']; ?>
                        </td>
                      </tr>

                      <tr>
                        <th scope="row">Identification Document</th>
                        <td>
                          <?php if (!empty($userData['identification'])): ?>
                            <a href="#" data-toggle="modal"
                              data-target="#identificationModal<?php echo $userData['id']; ?>">
                              <img src="uploads/identification/<?php echo $userData['identification']; ?>"
                                alt="Identification Document" class="img-thumbnail" style="max-width: 150px;">
                            </a>
                          <?php else: ?>
                            No Identification Document available
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Driver's License</th>
                        <td>
                          <?php if (!empty($userData['license'])): ?>
                            <a href="#" data-toggle="modal" data-target="#licenseModal<?php echo $userData['id']; ?>">
                              <img src="uploads/license/<?php echo $userData['license']; ?>" alt="Driver's License"
                                class="img-thumbnail" style="max-width: 150px;">
                            </a>
                          <?php else: ?>
                            No Driver's License available
                          <?php endif; ?>
                        </td>

                      </tr>
                      <!-- Add a row for Status, Approved Icon, and Remarks -->
                      <tr>
                        <th scope="row">Status</th>
                        <td>
                          <?php if ($userData['status'] === 'approved'): ?>
                            <i class="fas fa-check-circle text-success"></i> Approved
                          <?php elseif ($userData['status'] === 'pending'): ?>
                            <i class="fas fa-clock text-warning"></i> Pending
                          <?php elseif ($userData['status'] === 'rejected'): ?>
                            <i class="fas fa-times-circle text-danger"></i> Rejected
                          <?php endif; ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="text-center">
                          <a href="update_profile.php" class="btn btn-primary">Update Profile</a>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Modal for Profile Picture -->
              <div class="modal fade" id="profileModal<?php echo $userData['id']; ?>" tabindex="-1" role="dialog"
                aria-labelledby="profileModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="profileModalLabel">Profile Picture</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body d-flex justify-content-center">
                      <!-- Center the image using d-flex and justify-content-center -->
                      <img src="uploads/profile/<?php echo $userData['profile_picture']; ?>" alt="Profile Picture"
                        class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal for Identification Document -->
              <div class="modal fade" id="identificationModal<?php echo $userData['id']; ?>" tabindex="-1" role="dialog"
                aria-labelledby="identificationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="identificationModalLabel">Identification Document</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php if (!empty($userData['identification'])): ?>
                        <img src="uploads/identification/<?php echo $userData['identification']; ?>"
                          alt="Identification Document" class="img-fluid">
                      <?php else: ?>
                        No Identification Document available
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modal for Driver's License -->
              <div class="modal fade" id="licenseModal<?php echo $userData['id']; ?>" tabindex="-1" role="dialog"
                aria-labelledby="licenseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="licenseModalLabel">Driver's License</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <?php if (!empty($userData['license'])): ?>
                        <img src="uploads/license/<?php echo $userData['license']; ?>" alt="Driver's License"
                          class="img-fluid">
                      <?php else: ?>
                        No Driver's License available
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
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
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>