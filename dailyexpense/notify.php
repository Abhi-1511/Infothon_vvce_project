<?php
include("session.php");
include("remainder.php");


// Get the current date
$currentDate = date("Y-m-d");

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
echo json_encode(array('notificationCount' => $notificationCount));
?>
