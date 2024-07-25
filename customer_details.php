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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the selected status and the user's ID
  $status = $_POST['status'];
  $userId = $_POST['user_id'];

  // Update the status for the user in the database
  $stmt = $conn->prepare("UPDATE users SET status = :status WHERE id = :id");
  $stmt->bindParam(':status', $status);
  $stmt->bindParam(':id', $userId);
  $stmt->execute();
}

// Fetch data from the "users" table
$stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function to get the Bootstrap color class based on the status
function getStatusColorClass($status)
{
    switch ($status) {
        case 'pending':
            return 'bg-warning text-white';
        case 'approved':
            return 'bg-success text-white';
        case 'rejected':
            return 'bg-danger text-white';
        default:
            return '';
    }
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

  <!-- Add jQuery before Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <title>Customer Details</title>
  <style>
    /* .container {
      margin-top: 30px;
    } */
   /* Add custom styles for the dropdown */
   .form-control.status-dropdown {
      padding-left: 30px;
    }
    .form-control.status-dropdown option {
      padding-left: 10px;
    }
  </style>
 
</head>

<body>
  <?php include 'newAdmin.php'; ?>
  <div class="container mt-5">
    <table class="table" id="usersTable">
      <thead>
        <tr>
          <th>Sr No.</th>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Present Address</th>
          <th>Profile Picture</th>
          <th>Identification Document</th>
          <th>Driver's License</th>
          <th>Status</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone']; ?></td>
            <td><?php echo $user['address']; ?></td>
            <td>
              <?php if (!empty($user['profile_picture'])): ?>
                <img src="./uploads/profile/<?php echo $user['profile_picture']; ?>" alt="Profile Picture"
                  class="img-thumbnail" style="max-width: 150px;">
              <?php else: ?>
                No Profile Picture available
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($user['identification'])): ?>
                <img src="./uploads/identification/<?php echo $user['identification']; ?>"
                  alt="Identification Document" class="img-thumbnail" style="max-width: 150px;">
              <?php else: ?>
                No Identification Document available
              <?php endif; ?>
            </td>
            <td>
              <?php if (!empty($user['license'])): ?>
                <img src="./uploads/license/<?php echo $user['license']; ?>" alt="Driver's License"
                  class="img-thumbnail" style="max-width: 150px;">
              <?php else: ?>
                No Driver's License available
              <?php endif; ?>
            </td>
            <td>
            <form action="" method="post" class="form-inline">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <div class="form-group mb-2">
                  <select name="status" class="form-control status-dropdown <?php echo getStatusColorClass($user['status']); ?>" onchange="this.form.submit()">
                    <option value="pending" <?php echo ($user['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo ($user['status'] === 'approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo ($user['status'] === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                  </select>
                </div>
              </form>
            </td>
          

            <td>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal<?php echo $user['id']; ?>">
                View
              </button>
            </td>
          </tr>

          <!-- User Modal -->
          <div class="modal fade" id="userModal<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <?php if (!empty($user['profile_picture'])): ?>
              <!-- Use Lightbox2 for the profile picture -->
              <a href="./uploads/profile/<?php echo $user['profile_picture']; ?>" data-lightbox="user-images">
                <img src="./uploads/profile/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="img-thumbnail" style="max-width: 150px;">
              </a>
            <?php else: ?>
              No Profile Picture available
            <?php endif; ?>
          </div>
          <div class="col-md-8">
            <p><strong>Full Name:</strong> <?php echo $user['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $user['phone']; ?></p>
            <p><strong>Present Address:</strong> <?php echo $user['address']; ?></p>
            <!-- Add more user details here if needed -->
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <?php if (!empty($user['identification'])): ?>
              <!-- Use Lightbox2 for the identification document -->
              <a href="./uploads/identification/<?php echo $user['identification']; ?>" data-lightbox="user-images">
                <img src="./uploads/identification/<?php echo $user['identification']; ?>" alt="Identification Document" class="img-thumbnail" style="max-width: 150px;">
              </a>
            <?php else: ?>
              No Identification Document available
            <?php endif; ?>
          </div>
          <div class="col-md-4">
            <?php if (!empty($user['license'])): ?>
              <!-- Use Lightbox2 for the driver's license -->
              <a href="./uploads/license/<?php echo $user['license']; ?>" data-lightbox="user-images">
                <img src="./uploads/license/<?php echo $user['license']; ?>" alt="Driver's License" class="img-thumbnail" style="max-width: 150px;">
              </a>
            <?php else: ?>
              No Driver's License available
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
          <!-- End User Modal -->

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Add your footer content here -->

  <!-- Add the DataTable JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    // Your JavaScript code here
    $(document).ready(function() {
      // DataTable initialization
      $('#usersTable').DataTable();

    });
  </script>
</body>

</html>

