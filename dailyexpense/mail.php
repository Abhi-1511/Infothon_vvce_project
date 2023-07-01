<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if (isset($_POST['submit'])) {
    $name = $_POST['firstname'];
    $email = $_POST['email'];

    // Fetch registered email addresses from the database
    $db_host = 'localhost';
    $db_username = 'root';
    $db_password = '';
    $db_name = 'dailyexpense';

    // Connect to the database
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$con) {
        die('Database connection error.');
    }

    // Fetch recipient email addresses from the database table (replace 'users' with your table name)
    $query = "SELECT email FROM users ";
    $result = mysqli_query($con, $query);

    $recipients = [];

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $recipients[] = $row['email'];
            }
        }
    } else {
        // Handle query execution error
        die('Database query error: ' . mysqli_error($con));
    }
    
    $query = "UPDATE users SET registered = 1 WHERE email = '$email'";
    mysqli_query($con, $query);

    // Remove registered recipients from the recipients array
    //$recipients = array_diff($recipients, [$email]);

    mysqli_close($con);
        

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wizardwisewallet@gmail.com';
        $mail->Password = 'oqlqnadrgfbbclab';
        $mail->SMTPSecure = "tls";
        $mail->Port = '587';

        $mail->setFrom('wizardwisewallet@gmail.com');

        // Add recipients using loop
        foreach ($recipients as $recipient) {
            $mail->addAddress($recipient);
        }

        $mail->isHTML(true);
        $mail->Subject = 'Message Received from Contact:'. $name;
        $mail->Body = "Name: $name <br>Email: $email";
        
        $mail->send();
        $alert = "<div class='alert-success'><span>Message Sent!</span></div>";
        unset($recipients[array_search($email, $recipients)]);


    } catch (Exception $e) {
        $alert = "<div class='alert-error'><span>" . $e->getMessage() . "</span></div>";
    }
}
?>