 <?php
 session_start();
 
 if ($_SESSION["status"] != true){
 
     header("Location: login.php");
 }
 

// Check if the user is not logged in, redirect to the login page
// if (!isset($_SESSION['email']) || !$_SESSION['password']) {
//     header("Location: login.php");
//     exit;
// }

 ?>
 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Booking Success</title>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h1 class="text-center">Booking Successful</h1>
        <p>Your booking has been successfully processed.</p>
        <p>Thank you for choosing our services. We hope you have a great experience!</p>
        <p>For any further assistance, please contact our customer support.</p>
        <form action="success.php" method="POST">
        <input class="btn btn-primary" type="submit"  name="logout" value="Logout!">
        </form>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html> 
<?php
if(isset($_POST["logout"])){
    header("Location: index.php");
}
?>

<!-- <?php
// session_start();

// Check if the booking was successful
// if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']) {
//   // Clear the booking success flag
//   unset($_SESSION['booking_success']);
// } else {
//   // Redirect to the home page if accessed directly without a successful booking
//   header("Location: index.php");
//   exit;
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Booking Successful</title>
</head>

<body>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h1 class="text-center">Booking Successful</h1>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <img src="./image/<?php echo $_SESSION['vehicle_image']; ?>" alt="Vehicle Image" style="max-width: 100%;">
          </div>
          <div class="col-md-8">
            <p><strong>Type:</strong> <?php echo $_SESSION['vehicle_type']; ?></p>
            <p><strong>Brand:</strong> <?php echo $_SESSION['vehicle_brand']; ?></p>
            <p><strong>Model:</strong> <?php echo $_SESSION['vehicle_model']; ?></p>
          </div>
        </div>
        <div class="text-center">
          <a href="index.php" class="btn btn-primary">Back to Home</a>
        </div>
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html> -->

