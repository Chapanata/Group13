<?php
include '../connection.php';
include '../Email Templates/confirmCodeEmailTemplate.php';
include '../../sendmail.php';

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

if(!isset($data->Email))
{
    error("Missing Email Parameter");
    die();
}

if(!isset($data->Password))
{
    error("Missing Password Parameter");
    die();
}

if(!isset($data->Name))
{
    error("Missing Name Parameter");
    die();
}

// Get data
$Email = $data->Email;
$Fullname = $data->Name;
$Password = md5($data->Password); // Hash password

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT Email FROM $UsersTbl WHERE Email='$Email'");
$result->execute();
$amount = $result->rowCount();

if($amount > 0)
{
    error("User Already Exists");
    closeConnectionAndDie($conn);
}

// Generate Confirm Code and Email
$confirmCode = rand(1000,9999);
$mail = new NewMail();
$mail->Subject = "Your Registration to Contact Manager Deluxe";
$mail->Email = $Email;
$mail->Name = $Fullname;
$mail->Body = getEmail($confirmCode, $Email,$Fullname);
$mail->AltBody = "Your confirmation code is " . $confirmCode;

if(!$mail->send())
{
    error("Couldn't send email");
    closeConnectionAndDie($conn);
}

$result = null;

$updateUser = $conn->prepare("INSERT INTO $UsersTbl (UserID, Email, Password, ConfirmCode, Name) VALUES (DEFAULT, '$Email', '$Password', '$confirmCode', '$Fullname')");
$updateUser->execute();

// Close connection
$conn = null;

success(TRUE);

?>
