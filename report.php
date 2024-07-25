<?php
session_start();

// Check if the admin_id session variable is set
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header("Location: admin_login.php");
    exit();
}
// Database connection parameters
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "bike";

// Create a new PDO instance
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $dbpassword);
$stmt = $conn->prepare("SELECT b.*, v.type, v.brand, v.model, v.color, u.name, u.email, u.phone, u.address 
                       FROM bookings AS b
                       INNER JOIN vehicles AS v ON b.vehicle_id = v.id
                       INNER JOIN users AS u ON b.user_id = u.id
                       WHERE b.created_at BETWEEN :start_date AND :end_date
                       ORDER BY b.created_at DESC");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filter_dates"])) {
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // If the start date is equal to the end date, adjust the end date to the next day
    if ($startDate == $endDate) {
        $endDate = date('Y-m-d', strtotime($endDate . ' +1 day'));
    }

    // Bind the date range values to the query
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);

    // Execute the query to fetch the data
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Default date range (you can change this as per your requirement)
    $defaultStartDate = date("Y-m-d", strtotime("-7 days"));
    $defaultEndDate = date("Y-m-d");
    $stmt->bindParam(':start_date', $defaultStartDate);
    $stmt->bindParam(':end_date', $defaultEndDate);

    // Set $bookings to an empty array if the "Filter" button is not clicked
    $bookings = [];


}

?>



<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add the DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <title>Booking Detail Reports</title>
    <style>
        .container {
            margin-top: 30px;
        }


        /* Set a fixed width for the columns that need more space */
        .table th:nth-child(7),
        .table td:nth-child(7),
        .table th:nth-child(10),
        .table td:nth-child(10) {
            min-width: 0px;
        }
    </style>
</head>

<body>
    <?php include 'newAdmin.php'; ?>
    <div id="content">


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Between Dates Reports</h4>
                        </div>
                        <div class="card-body">

                            <form action="" method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Start Date:</label>
                                            <input type="date" name="start_date" id="start_date"
                                                value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>End Date:</label>
                                            <input type="date" id="end_date" name="end_date"
                                                value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        &nbsp;&nbsp;&nbsp;&nbsp;<label>Click to Filter</label> &nbsp; &nbsp; &nbsp; 
                                            <!-- <label>Export to Excel</label>--> <br> 
                                            &nbsp; &nbsp; &nbsp;<button type="submit" name="filter_dates"
                                                class="btn btn-primary"
                                                style="background-color: #0066ff;">Filter</button>
                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                            <!-- <button id="downloadexcel" name="excel"
                                                class="btn btn-success">Excel</button> -->

                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        
        <!-- ... Table wrapper (same as before) ... -->
        <div class="table-responsive">
            <table class="table" id="bookingsTable">
            <h1>Booking Detail Reports</h1>
                <!-- <table id="example" style="width:100%"> -->
                <thead>
                    <tr>
                        <th>Sr No.</th>
                        <th>Booking ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Vehicle Type</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>Pickup Location</th>
                        <th>Start Date</th>
                        <th>Pickup Time</th>
                        <th>End Date</th>
                        <th>Dropoff Time</th>
                        <th>Total Price</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display the data in the table rows
                    $sno = 1;
                    foreach ($bookings as $booking) {
                        echo "<tr>";
                        echo "<td>{$sno}</td>";
                        echo "<td>{$booking['id']}</td>";
                        echo "<td>{$booking['name']}</td>";
                        echo "<td>{$booking['email']}</td>";
                        echo "<td>{$booking['phone']}</td>";
                        echo "<td>{$booking['address']}</td>";
                        echo "<td>{$booking['type']}</td>";
                        echo "<td>{$booking['brand']}</td>";
                        echo "<td>{$booking['model']}</td>";
                        echo "<td>{$booking['color']}</td>";
                        echo "<td>{$booking['pickup_location']}</td>";
                        echo "<td>{$booking['start_date']}</td>";
                        echo "<td>{$booking['pickup_time']}</td>";
                        echo "<td>{$booking['end_date']}</td>";
                        echo "<td>{$booking['dropoff_time']}</td>";
                        echo "<td>{$booking['total_price']}</td>";
                        echo "<td>{$booking['created_at']}</td>";
                        echo "</tr>";
                        $sno += 1;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <script>
        $(document).ready(function () {
            $('#bookingsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel','print'
                ]
            });
        });
    </script>
    <!-- <script>
        $(document).ready(function () {
            $('#bookingsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            modifier: {
                                search: 'none'
                            }
                        }
                    }, 'print'
                ]
            });

            // Add click event handler to the existing Excel button
            $('#downloadexcel').on('click', function () {
                $('#bookingsTable').DataTable().button('.buttons-excel').trigger();
            });
        });
    </script> -->
    <!-- Add the DataTable JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>




</body>

</html>