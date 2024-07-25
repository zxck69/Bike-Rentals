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
    <link rel="stylesheet" href="style.css">
    <title>About Us</title>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .menu-bar {
            /* Add your menu bar styles here */
        }

        .card {
            margin: 105px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: black;
            color: #fff;
            text-align: center;
            font-size: 24px;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-body {
            padding: 20px;
        }
        .main-word {
            color: black;
            font-weight: bold;
        }
        .main-word-header {
            color: #007bff;
            font-weight: bold;
        }

        /* .footer-content {
            text-align: center;
            padding: 10px;
        } */
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
                <li>
                    <a href="#">
                        <span>
                            <div class="badge bg-primary text-wrap" style="">
                                Welcome
                                <?php echo isset($_SESSION['name']) ? strtoupper($_SESSION['name']) : ''; ?>
                                <i class="fas fa-caret-down"></i>
                            </div>
                        </span>
                    </a>
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

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                    About Bike<span class="main-word-header">Rentals</span>
                    </div>
                    <div class="card-body">
                        <p>Welcome to <span class="main-word">BikeRentals</span>, your go-to destination for hassle-free
                            and eco-friendly commuting. Our platform offers a seamless online bike and scooter booking
                            service, providing you with the freedom to ride your own two-wheeler wherever you go.</p>

                        <p>Our mission is to bridge the gap in last and first-mile connectivity that exists in most major
                            cities in India. We understand the challenges faced by daily commuters who rely on public
                            transportation, and we are here to provide a convenient and affordable solution.</p>

                        <p>With a diverse fleet of bikes and scooters available at affordable prices, you can choose the
                            perfect ride that suits your needs. Whether you need a bike for a quick errand, a scooter for
                            your daily commute, or something for longer periods, <span class="main-word">BikeRentals</span>
                            has got you covered.</p>

                        <p>At <span class="main-word">BikeRentals</span>, safety and quality are our top priorities. We
                            maintain our fleet to the highest standards to ensure a safe and enjoyable ride for our
                            customers. Additionally, our user-friendly platform and transparent pricing make the rental
                            process quick and easy.</p>

                        <p>Join us in promoting sustainable transportation practices and reducing carbon emissions. Rent a
                            bike or scooter today and experience the joy of convenient and eco-friendly commuting with
                            <span class="main-word">BikeRentals</span>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2023 BikeRentals. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
