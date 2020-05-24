<?php
include 'connection.php';
include 'confirmCodeEmailTemplate.php';


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
if(isset($data->Email) == FALSE || isset($data->Password) == FALSE || isset($data->Code) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$Email = $data->Email;
// Hash password
$Password = md5($data->Password);
$Code = $data->Code;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT UserID, Confirmed, ConfirmCode FROM $UsersTbl WHERE Email='$Email'");
$result->execute();
$amount = $result->rowCount();

// No user found
if($amount <= 0)
{
    error("User does not exist");
    closeConnectionAndDie($conn);
}

// Check confirmed
$result = $result->fetch();
if($result['Confirmed'] != 1)
{
    error("User not confirmed");
    closeConnectionAndDie($conn);
}

// Check code
if($result['ConfirmCode'] != $Code)
{
    error("No match found");
    closeConnectionAndDie($conn);
}

// Reset user's password and code
$updateUser = $conn->prepare("UPDATE $UsersTbl SET ConfirmCode = '0', Password = '$Password' WHERE Email='$Email'");
$updateUser->execute();

// Close connection
$conn = null;

success(TRUE);

?>
