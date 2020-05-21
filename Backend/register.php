<?php
include 'connection.php';
include 'confirmCodeEmailTemplate.php';
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(isset($data->Email) == FALSE || isset($data->Username) == FALSE || isset($data->Password) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

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
$result = $conn->prepare("SELECT FIRST FROM $table_users WHERE Username='$Username'")->execute();

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
    error("Internal Error " . $app_pass . $app_email . $conn->error);
    closeConnectionAndDie($conn);
}

// Add user entry
$result = $conn->prepare("INSERT INTO $table_users (Email, Username, Password, ConfirmCode) VALUES ($Email, $Username, $Password, $confirmCode)")->execute();

// Close connection
$conn->close();
?>
