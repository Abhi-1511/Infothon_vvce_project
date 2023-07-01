<?php
include("session.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';


?>

<!DOCTYPE html>
<html>
<head>
    <title>Expenses with Due Amount</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .expense {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .amount {
            font-weight: bold;
            color: #ff5a5f;
        }

        .date {
            color: #888;
        }

        .category {
            color: #333;
        }
        
    </style>
</head>
<body>
    <h1>Expenses with Due Amount</h1>

    <?php
    // Get the current date
    $currentDate = date("Y-m-d");

    // Query to fetch expenses with due amount
    $query = "SELECT * FROM expenses WHERE user_id='$userid' AND expense > 0 AND expensedate < '$currentDate'";
    $result = mysqli_query($con, $query) or die("Query Failed!");

    // Check if there are any expenses with due amount
    if (mysqli_num_rows($result) > 0) {
        echo "<p>You have the following expenses with due amount:</p>";

        // Display the expenses with due amount
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="expense">';
            echo '    <p class="category">Expense Category: ' . $row['expensecategory'] . '</p>';
            echo '    <p class="date">Expense Due Date: ' . $row['expensedate'] . '</p>';
            echo '    <p class="amount">Expense Amount: $' . $row['expense'] . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No expenses with due amount.</p>";
    }

    // Close the database connection
    //mysqli_close($con);
    ?>
</body>
</html>

<?php
//include("session.php");


// ... (the existing code before sending emails)

// Check if there are any expenses with due amount
if (mysqli_num_rows($result) > 0) {
    echo "<p>You have the following expenses with due amount:</p>";

    // Display the expenses with due amount
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="expense">';
        echo '    <p class="category">Expense Category: ' . $row['expensecategory'] . '</p>';
        echo '    <p class="date">Expense Due Date: ' . $row['expensedate'] . '</p>';
        echo '    <p class="amount">Expense Amount: $' . $row['expense'] . '</p>';
        echo '</div>';
    }
    mysqli_data_seek($result, 0); // Reset the result pointer to the beginning


    // Initialize the email content
    $to = "abhishekmmgowda6@gmail.com"; // Replace with the user's email address
    $subject = "Reminder: Expenses with Due Amount";
    $message = "<h1>Expenses with Due Amount</h1>";

    // Add the expenses with due amount to the email message
    mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
    while ($row = mysqli_fetch_assoc($result)) {
        $message .= '<div class="expense">';
        $message .= '    <p class="category">Expense Category: ' . $row['expensecategory'] . '</p>';
        $message .= '    <p class="date">Expense Due Date: ' . $row['expensedate'] . '</p>';
        $message .= '    <p class="amount">Expense Amount: $' . $row['expense'] . '</p>';
        $message .= '</div>';
    }

    // Set headers for HTML email
    $mail = new PHPMailer();
    // SMTP configuration
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server host
    $mail->Port = 587; // Replace with your SMTP server port
    $mail->Username = 'wizardwisewallet@gmail.com'; // Replace with your email address
    $mail->Password = 'oqlqnadrgfbbclab'; // Replace with your email password

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->Debugoutput = function ($str, $level) {
    echo "($level) $str\n";
};

    // Sender and recipient
    $mail->setFrom('wizardwisewallet@gmail.com', 'Wise Wallet Wizard'); // Replace with your email and name
    $mail->addAddress($to); // Add recipient email

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // Send the email
    if ($mail->send()) {
        echo "<p>Reminder sent successfully to your email.</p>";
    } else {
        echo "<p>Failed to send the reminder email.</p>";
    }
} else {
    echo "<p>No expenses with due amount.</p>";
}

// Close the database connection
mysqli_close($con);
?>