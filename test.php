<?php

?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="stylereport.css" rel="stylesheet" type="text/css">
  <!-- FONTAWESOME : https://kit.fontawesome.com/a23e6feb03.js -->
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.  5/jquery.mCustomScrollbar.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <script src="icons.js"></script>
  <script src="table2excel.js"></script>

  <title>Report</title>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <button id="sidebarCollapse" class="btn navbar-btn">
      <i class="fas fa-lg fa-bars"></i>
    </button>
    <a class="navbar-brand" href="">
      <h3 id="logo">Visitor Entry Management</h3>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" id="link" href="http://localhost/project3/login.php">
            <i class="fas fa-sign-out-alt"></i>
            LogOut<span class="sr-only">(current) </span></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="wrapper fixed-left">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3><i class="fas fa-user"></i>Admin</h3>
      </div>

      <ul class="list-unstyled components">
        <li>
          <a href="index.php"><i class="fas fa-home"></i>Home</a>
        </li>
        <li>
          <a href="manage.php"><i class="fas fa-id-badge"></i>Manage</a>
        </li>
        <li>
          <a href="report.php"><i class="fas fa-id-badge"></i>Report</a>
        </li>


      </ul>
    </nav>

    <div id="content">


      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h4>Between Dates Reports</h4>
              </div>
              <div class="card-body">

                <form action="" method="GET">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="from_date"
                          value="<?php if (isset($_GET['from_date'])) {
                            echo $_GET['from_date'];
                          } ?>"
                          class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="to_date"
                          value="<?php if (isset($_GET['to_date'])) {
                            echo $_GET['to_date'];
                          } ?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Click to Filter</label> &nbsp &nbsp <label>Export to Excel</label> <br>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                        <button id="downloadexcel" type="submit" class="btn btn-success">Excel</button>
                      </div>
                    </div>


                  </div>
                </form>

              </div>
            </div>

            <div class="card mt-4">
              <div class="card-body">
                <table class="table table-borderd" id="example-tabel">
                  <thead>
                    <tr>
                      <th scope="col">S.No.</th>
                      <th scope="col">Visitor Name</th>
                      <th scope="col">Phone Number</th>
                      <th scope="col">Address</th>
                      <th scope="col">Flat No.</th>
                      <th scope="col">Wing</th>
                      <th scope="col">Whom to meet</th>
                      <th scope="col">Reason To Meet</th>
                      <th scope="col">Check In</th>
                      <th scope="col">Check Out</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $con = mysqli_connect("localhost", "root", "", "visitor");

                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                      $from_date = $_GET['from_date'];
                      $to_date = $_GET['to_date'];

                      $query = "SELECT * FROM visitor WHERE Check_In BETWEEN '$from_date' AND '$to_date' ";
                      $query_run = mysqli_query($con, $query);

                      if (mysqli_num_rows($query_run) > 0) {
                        $sno = 0;
                        foreach ($query_run as $row) {
                          $sno = $sno + 1;




                          echo "<tr>
                                                    <th scope='row'>" . $sno . "</th>
                                                    <td>" . $row['Visitor Name'] . "</td>
                                                    <td>" . $row['Phone Number'] . "</td>
                                                    <td>" . $row['Address'] . "</td>
                                                    <td>" . $row['Flat No'] . "</td>
                                                    <td>" . $row['Wing'] . "</td>
                                                    <td>" . $row['Whom to meet'] . "</td>
                                                    <td>" . $row['Reason To Meet'] . "</td>
                                                    <td>" . $row['Check_In'] . "</td>
                                                    <td>" . $row['Check Out'] . "</td>
                                            </tr>";

                        }
                      } else {
                        echo "No Record Found";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

      <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        document.getElementById('downloadexcel').addEventListener('click', function () {
          var table2excel = new Table2Excel();
          table2excel.export(document.querySelectorAll("#example-tabel"));
        })

      </script>
    </div>


  </div>
  <footer class="bg-dark text-center text-white">

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color:#030d16">
      &#169; 2022 Copyright: All Rights Reserved

    </div>


  </footer>



  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>