<?php
include 'dtb.php';
include 'confirmCodeEmailTemplate.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

include 'data.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
*/

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data

header('Content-Type: application/json');

// Get data
$Email = $data->Email;
$Username = $data->Username;
// Hash password
$Password = md5($data->Password);

// Confirm email
if (filter_var($Email, FILTER_VALIDATE_EMAIL) == FALSE)
{
    error("Email is not valid");
    die();
}

// Create connection
$conn = dbConnection();
// Check connection
if ($conn->connect_error) {
    error("Internal Error");
    closeConnectionAndDie($conn);
}

// Check if user exists
$result = $conn->query("SELECT * FROM $table_users WHERE Username='$Username'");

if($result == FALSE)
{
    error("Internal Error" . $conn->error);
    closeConnectionAndDie($conn);
}

if(mysqli_num_rows($result) > 0)
{
    error("User Exists");
    closeConnectionAndDie($conn);
}

// Generate confirm code
$confirmCode = rand(1000,9999);

// Send email
$mail = new PHPMailer;
$mail->SMTPDebug = 3;
$mail->isSMTP();
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = $app_email;
$mail->Password = $app_pass;
$mail->Port = 587;

$mail->From = $app_email;
$mail->addAddress($Email);
$mail->isHTML(true);
$mail->Subject = "Your Registration to POOP";
$mail->Body = getEmail($confirmCode);
$mail->AltBody = "Your confirmation code is " . $confirmCode;

if(!$mail->send())
{
    error("Internal Error 2 " . $app_pass . $app_email . $conn->error);
    closeConnectionAndDie($conn);
}

// Add user entry
$result = $conn->query("INSERT INTO $table_users FROM WHERE Username='$Username'");

// Close connection
$conn->close();
?>
