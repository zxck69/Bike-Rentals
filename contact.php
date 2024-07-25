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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="style.css">
  <title>Contact Us</title>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .menu-bar {
      /* Add your menu bar styles here */
    }

    .card {
      border: none;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .card-header {
      background-color: #007bff;
      color: #fff;
      text-align: center;
      font-size: 24px;
      padding: 15px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .card-body {
      padding: 30px;
    }

    .form-group label {
      font-weight: bold;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      margin-top: 20px;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .btn-primary:focus {
      box-shadow: none;
    }

    .contact-form {
      max-width: 400px;
      margin: 0 auto;
    }

    /* Add CSS for showing icons on the left side of the contact information */
    .contact-info p {
      position: relative;
      padding-left: 30px;
    }

    .contact-info p::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      font-family: "Font Awesome 5 Free";
      font-size: 16px;
      font-weight: 900;
    }

    .contact-info p[data-icon="map-marker-alt"]::before {
      content: '\f3c5'; /* Font Awesome code for the map-marker-alt icon */
    }

    .contact-info p[data-icon="phone-alt"]::before {
      content: '\f879'; /* Font Awesome code for the phone-alt icon */
    }

    .contact-info p[data-icon="envelope"]::before {
      content: '\f0e0'; /* Font Awesome code for the envelope icon */
    }
  </style>
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

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-4">
        <!-- Left Card - Contact Information -->
        <div class="card mb-4">
          <div class="card-header">
            Contact Information
          </div>
          <div class="card-body contact-info">
            <p data-icon="map-marker-alt">123 BikeRentals Street, Pune, Maharashtra, India</p>
            <p data-icon="phone-alt">+1 (123) 456-7890</p>
            <p data-icon="envelope"><label for="email" style="color: #007bff; font-size: 18px;">bikerentals2023@gmail.com</label></p>
          </div>
          
        </div>
      </div>
      <div class="col-lg-6">
        <!-- Right Card - Contact Form -->
        <div class="card">
          <div class="card-header">
            Contact Us
          </div>
          <div class="card-body">
            <form action="contact_process.php" method="post" class="contact-form">
              <!-- Status messages section -->
              <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <div class="container">
                  <div class="alert alert-success mt-3" role="alert">
                  Thank you! Your message has been sent successfully. We will get back to you soon.
                  </div>
                </div>
              <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                <div class="container">
                  <div class="alert alert-danger mt-3" role="alert">
                    Sorry, there was an error sending your message. Please try again later.
                  </div>
                </div>
              <?php endif; ?>
              <!-- End of status messages section -->
              <div class="form-group">
                <div class="contact-info">
                  <label for="name" style="font-size: 18px;">GENERAL INQUIRIES &nbsp; &nbsp;</label>
                  <br><br>
                  <label for="email" style="color: #007bff; font-size: 18px;">bikerentals2023@gmail.com</label>
                </div>
              </div>
              <br>
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>

              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
              </div>

              <button type="submit" name="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  &nbsp;
  <footer>
    <div class="footer-content">
      <p>&copy; 2023 BikeRentals. All rights reserved.</p>
    </div>
  </footer>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
