<?php
include 'connection.php';
include 'forgotPasswordEmailTemplate.php';


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
if(isset($data->Email) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Confirm valid email
if(filter_var($data->Email, FILTER_VALIDATE_EMAIL) == FALSE)
{
    error("Email is not valid");
    die();
}

// Get data
$Email = $data->Email;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT Email, Confirmed FROM $UsersTbl WHERE Email='$Email'");
$result->execute();
$amount = $result->rowCount();

if($amount <= 0)
{
    error("User does not exist");
    closeConnectionAndDie($conn);
}

// Check if user is confirmed
$result = $result->fetch();
if($result['Confirmed'] == 0)
{
    error("User not confirmed");
    closeConnectionAndDie($conn);
}

// Generate confirm code
$confirmCode = rand(1000,9999);

// Send email
$mail = new PHPMailer;

// Don't use SMTP, just use mail function
//$mail->SMTPDebug = 3;
//$mail->isSMTP();
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//$mail->Host = "smtp.gmail.com";
//$mail->SMTPAuth = true;
//$mail->Username = $app_email;
//$mail->Password = $app_pass;
//$mail->Port = 587;

$mail->setFrom($app_email, "Contact Manager Deluxe");
$mail->addAddress($Email);
$mail->isHTML(true);
$mail->Subject = "Forgotten Password to Contact Manager Deluxe";
$mail->Body = getEmail($confirmCode, $Email);
$mail->AltBody = "Your reset code is " . $confirmCode;

if(!$mail->send())
{
    error("Internal Error " . $app_pass . $app_email . $conn->error);
    closeConnectionAndDie($conn);
}

// Add user entry
$result = null;

// Update user's confirmed status
$updateUser = $conn->prepare("UPDATE $UsersTbl SET ConfirmCode='$confirmCode' WHERE Email='$Email'");
$updateUser->execute();

// Close connection
$conn = null;

success(TRUE);

?>
