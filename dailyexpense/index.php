<?php
  include("session.php");
 
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory1 FROM monthlydata WHERE u_id = '$userid' GROUP BY expensecategory1");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense1) FROM monthlydata WHERE u_id = '$userid' GROUP BY expensecategory1");

  $exp_date_line = mysqli_query($con, "SELECT expensedate1 FROM monthlydata WHERE u_id = '$userid' GROUP BY expensedate1");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense1) FROM monthlydata WHERE u_id = '$userid' GROUP BY expensedate1");
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Expense Manager - Dashboard</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="style.css" rel="stylesheet">

  <!-- Feather JS for Icons -->
  <script src="js/feather.min.js"></script>
  <script>
function openRemainderPopup() {
  // Create a new div element for the notification popup
  var popupDiv = document.createElement('div');
  popupDiv.style.width = '600px';
  popupDiv.style.height = '500px';
  popupDiv.style.position = 'fixed';
  popupDiv.style.top = '50%';
  popupDiv.style.left = '50%';
  popupDiv.style.transform = 'translate(-50%, -50%)';
  popupDiv.style.background = '#fff';
  popupDiv.style.border = '1px solid #ccc';
  popupDiv.style.overflow = 'scroll';
  popupDiv.style.textAlign = 'auto';

  // Fetch the content of remainder.php and append it to the div element
  fetch('remainder.php')
    .then(response => response.text())
    .then(data => {
      popupDiv.innerHTML = data;

      // Create a close button
      var closeButton = document.createElement('button');
      closeButton.innerText = 'Close';
closeButton.style.margin = 'auto';
closeButton.style.display = 'block';
closeButton.style.padding = '5px 10px';
closeButton.style.border = 'none';
closeButton.style.background = 'red';
closeButton.style.cursor = 'pointer';

      // Add an event listener to close the popup when the button is clicked
      closeButton.addEventListener('click', function() {
        popupDiv.remove();
      });

      // Append the close button to the popup div
      popupDiv.appendChild(closeButton);
    })
    .catch(error => {
      console.error('Error loading remainder content:', error);
    });

  // Append the popup div to the document body
  document.body.appendChild(popupDiv);
}




function updateNotificationCount() {
  // Fetch the notification count from remainder.php using AJAX
  fetch('remainder.php')
    .then(response => response.json())
    .then(data => {
      // Update the notification count on the badge
      const notificationBadge = document.getElementById('notificationBadge');
      if (notificationBadge) {
        notificationBadge.innerText = data.notificationCount;
      }
    })
    .catch(error => {
      console.error('Error fetching notification count:', error);
    });
}

// Call the updateNotificationCount function on page load and at regular intervals (e.g., every 5 seconds)
document.addEventListener('DOMContentLoaded', updateNotificationCount);
setInterval(updateNotificationCount, 5000);
</script>
  <style>
    .card a {
      color: #000;
      font-weight: 500;
    }

    .card a:hover {
      color: #28a745;
      text-decoration: dotted;
    }
    
  </style>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="remainder.php" class="list-group-item list-group-item-action "><span data-feather="check-circle"></span> Remainders</a>
        <a href="target.php" class="list-group-item list-group-item-action "><span data-feather="clock"></span> Expenditures </a>
      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
    
    <!-- /#sidebar-wrapper -->
    
    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


        <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
          <span data-feather="menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="profile.php">Your Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <h3 class="mt-4">Dashboard</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col text-center">
                    <a href="add_expense.php"><img src="icon/addex.png" width="57px" />
                      <p >Add Expenses</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="target.php"><img src="target1.jpg" width="57px" />
                      <p>Expenditures</p>
                    </a>
                  </div>
                  <div class="col text-center">
                    <a href="manage_expense.php"><img src="icon/maex.png" width="57px" />
                      <p>Manage Expenses</p>
                    </a>
                  </div>
                  
                    <div class="col text-center">
  <a href="#" onclick="openRemainderPopup();">
  <div class="noti">
    <img src="remainder.jpg" width="57px" />
    <p>Remainder</p><?php $currentDate = date("Y-m-d");

// Query to fetch expenses with due amount
$query = "SELECT COUNT(*) AS notificationCount FROM expenses WHERE user_id='$userid' AND expense > 0 AND expensedate < '$currentDate'";
$result = mysqli_query($con, $query) or die("Query Failed!");

// Fetch the notification count
$notificationCount = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $notificationCount = $row['notificationCount'];
}

// Close the database connection
mysqli_close($con);

// Return the notification count as JSON
?>
  </div>
    <span class="badge badge-danger" id="notificationBadge"><?php echo $notificationCount ?></span>
  </a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="mt-4">Full-Expense Report</h3>
        <div class="row">
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Yearly Expenses</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_line" height="150"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title text-center">Expense Category</h5>
              </div>
              <div class="card-body">
                <canvas id="expense_category_pie" height="150"></canvas>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
  <script>
    feather.replace()
  </script>
  <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
                    echo '"' . $a['expensecategory1'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Category',
          data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                    echo '"' . $b['SUM(expense1)'] . '",';
                  } ?>],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          borderWidth: 1
        }]
      }
    });

    var line = document.getElementById('expense_line').getContext('2d');
    var myChart = new Chart(line, {
      type: 'line',
      data: {
        labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                    echo '"' . $c['expensedate1'] . '",';
                  } ?>],
        datasets: [{
          label: 'Expense by Month (Whole Year)',
          data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                    echo '"' . $d['SUM(expense1)'] . '",';
                  } ?>],
          borderColor: [
            '#adb5bd'
          ],
          backgroundColor: [
            '#6f42c1',
            '#dc3545',
            '#28a745',
            '#007bff',
            '#ffc107',
            '#20c997',
            '#17a2b8',
            '#fd7e14',
            '#e83e8c',
            '#6610f2'
          ],
          fill: false,
          borderWidth: 2
        }]
      }
    });
  </script>
</body>

</html>