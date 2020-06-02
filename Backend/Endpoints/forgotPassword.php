<?php
include '../connection.php';
include '../Email Templates/forgotPasswordEmailTemplate.php';
include '../../sendmail.php';


// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(!isset($data->Email))
{
    error("Missing Email Parameter");
    die();
}

// Get data
$Email = $data->Email;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT * FROM $UsersTbl WHERE Email='$Email'");
$result->execute();
$amount = $result->rowCount();

if($amount <= 0)
{
    error("Email does not exist");
    closeConnectionAndDie($conn);
}

// Check if user is confirmed
$result = $result->fetch();
if($result['Confirmed'] == 0)
{
    error("Account must be verified first");
    closeConnectionAndDie($conn);
}
$Fullname = $result['Name'];

// Generate Confirm Code and Email
$confirmCode = rand(1000,9999);
$mail = new NewMail();
$mail->Subject = "Reset Your Password - Contact Manager Deluxe";
$mail->Email = $Email;
$mail->Name = $Fullname;
$mail->Body = getEmail($confirmCode, $Email,$Fullname);
$mail->AltBody = "Your reset code is " . $confirmCode;

if(!$mail->send())
{
    error("Couldn't send email");
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
