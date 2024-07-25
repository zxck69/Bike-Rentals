<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the selected vehicle ID
  $selectedVehicleId = $_POST['book-now'];
  if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    // Use the $userId as needed
    //echo "user is  login";
  } 
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
    } else {
      echo "No vehicle data found";
    }
  
  $conn->close();
} else {
  header("Location: index.php");

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    /* body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    } */

    .container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      height: 100%;
      margin-top: 55px;
    }

    .vehicle-details {
      flex: 1;
      margin-right: 20px;
    }

    .booking-form {
      flex: 1;
    }

    .vehicle-image {
      flex: 1;
      max-width: 300px;
    }
  </style>
  <title>Book Now</title>
  <script src="https://cdn.jsdelivr.net/npm/dayjs"></script>
  <script>
    function calculateDurationAndPrice() {
      const startDate = dayjs(document.getElementById("start-date").value);
      const endDate = dayjs(document.getElementById("end-date").value);

      const duration = endDate.diff(startDate, 'day');
      const pricePerDay = <?php echo $price; ?>;
      const totalPrice = pricePerDay * duration;

      document.getElementById("duration").textContent = duration > 1 ? duration + " days" : duration + " day";
      document.getElementById("total-price").value = totalPrice;
    }

    function setCurrentDateTime() {
      const currentDate = dayjs().format('YYYY-MM-DD');
      const nextDate = dayjs().add(1, 'day').format('YYYY-MM-DD');
      const currentTime = dayjs().format('HH:mm');

      document.getElementById("start-date").setAttribute("min", currentDate);
      document.getElementById("end-date").setAttribute("min", nextDate);

      document.getElementById("start-date").value = currentDate;
      document.getElementById("pickup-time").value = currentTime;
      document.getElementById("end-date").value = nextDate;
      document.getElementById("dropoff-time").value = currentTime;

      calculateDurationAndPrice();
    }
    function validateForm() {
      const termsCheckbox = document.getElementById("terms-checkbox");
      const pickupLocation = document.getElementById("pickup-location").value;

      if (pickupLocation === "") {
        alert("Please select a pickup location.");
        return false;
      }

      if (!termsCheckbox.checked) {
        alert("Please accept the terms and conditions.");
        return false;
      }
    }
  </script>
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
        </li>
        <li><a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a></li>
      <?php } else { ?>
        <li><a href="login.php">Login / Register</a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="hero">
    <main>
      <div class="container">
        <div class="vehicle-details">
          <div class="card">
            <div class="card-body">
              <h1 class="text-center">Vehicle Details</h1>
              <div>
                <img src="./uploads/vehicles/<?php echo $image; ?>" alt="Vehicle Image" style="max-width: 100%;">
                <hr>
                <p><strong>Type:</strong>
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
                  <?php echo $price; ?>
                </p>
                <p><strong>Description:</strong>
                  <?php echo $description; ?>
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="booking-form">
          <div class="card">
            <div class="card-body">
              <h3 class="text-center">Book Now</h3>
              <form id="myForm" action="handle_booking.php" method="POST" onsubmit="return validateForm()">
                <input type="hidden" name="vehicle-id" value="<?php echo $selectedVehicleId; ?>">
                <div class="form-group">
                  <label for="pickup-location">Pickup Location:</label>
                  <select class="form-control" id="pickup-location" name="pickup-location">
                    <option value="">Select Pickup Location</option>
                    <option value="Hinjewadi Phase 3">Hinjewadi Phase 3</option>
                    <option value="Balewadi">Balewadi</option>
                    <option value="Viman Nagar">Viman Nagar</option>
                    <!-- Add more options for different pickup locations -->
                  </select>
                </div>
                <div class="form-group">
                  <label for="start-date">Start Date:</label>
                  <input type="date" class="form-control" id="start-date" name="start-date"
                    onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="form-group">
                  <label for="pickup-time">Pickup Time:</label>
                  <input type="time" class="form-control" id="pickup-time" name="pickup-time"
                    onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="form-group">
                  <label for="end-date">End Date:</label>
                  <input type="date" class="form-control" id="end-date" name="end-date"
                    onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="form-group">
                  <label for="dropoff-time">Dropoff Time:</label>
                  <input type="time" class="form-control" id="dropoff-time" name="dropoff-time"
                    onchange="calculateDurationAndPrice()" required>
                </div>
                <div class="form-group">
                  <label for="duration">Duration:</label>
                  <span id="duration"></span>
                </div>
                <div class="form-group">
                  <label for="total-price">Total Price:</label>
                  <input type="text" class="form-control" id="total-price" name="total-price" readonly>
                </div>
                <div class="form-group">
                  <label for="terms-checkbox">Terms and Conditions:</label>

                  <button type="button" class="btn btn-link" data-toggle="modal" data-target="#termsModal">
                    View Terms and Conditions
                  </button>

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms-checkbox">
                    <label class="form-check-label" for="terms-checkbox">I accept the terms and conditions</label>
                  </div>

                </div>
                <div class="row">
                  <div class="col-12">


                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                      <!-- <form action="handle_booking.php" method="POST"> -->
                      <button type="submit" name="book-now" class="button-32" role="button"
                        value="<?php echo $selectedVehicleId; ?>">Book Now</button>
                </form>
              <?php else: ?>
                <a href="login.php"> <button type="submit" name="book-now" class="button-32" role="button">Book
                    Now</button></a>
              <?php endif; ?>


            </div>
          </div>
          <!-- </form> -->
        </div>
      </div>
    </main>
  </div>
  <!-- Terms Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Insert your terms and conditions content here -->
          <div style="padding:20px;">
            <ul>

              <li> Documents Required:- Original Aadhar Card and Original Driving License.</li>
              <li>Driving License is mandatory at the time of pickup.</li>
              <li>Rider need to mandatorily share copy of the Driving licence, Adhaar card, Employee ID Card or College
                ID Card & Local address proof where currently residing.</li>
              <li> The rider needs to be 18 years of age or older to rent a bike. If the rider is under the stipulated
                age, his or her order will be cancelled without any refund.</li>
              <li>Rider should respect and follow Traffic rules and regulations. All Challans issued due to rider
                negligence need to be paid in full to the penalizing authority.</li>
              <li>Driving under the influence of Alcohol/Drugs is strictly prohibited. Bike Owner will not be
                responsible to compensate for any mishaps and their consequences in such cases. The customer will be
                liable to pay for all damages to the vendor for the same.</li>
              <li>Customer has to drop the bike at the same location from where it was picked up. No requests will be
                accommodated for a change in the drop location.</li>
              <li>In case a customer feels that they will be late for the drop, they should call the field executive or
                customer care and ask for a trip extension. Extensions are subject to availability.</li>
              <li>The Pick-up date, time and location cannot be changed once a booking is confirmed.</li>
              <li> The riders needs to present all the original documents at the time of pickup.</li>
              <li> Fuel Charges are not included in the rent.</li>
              <li> In case of any damage to the vehicle, the customer is liable to pay the repair charges as per the
                Authorised Service Center.</li>
              <li> In case of any damage to the helmet, the customer is liable to pay the damage charges.</li>
              <li>One Helmet will be given with the bike. Another will be available on request.</li>
              <li>Late penalty 100/hour
              </li>
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
    setCurrentDateTime();
  </script>

</body>

</html>