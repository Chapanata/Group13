<?php
include '../connection.php';
include 'confirmCodeEmailTemplate.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpMailer/Exception.php';
require '../phpMailer/PHPMailer.php';
require '../phpMailer/SMTP.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(isset($data->SessionToken) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$SessionToken = $data->SessionToken;

// Optional data
$FirstName = $data->FirstName;
$LastName = $data->LastName;
$PhoneNumber = $data->PhoneNumber;
$Email = $data->Email;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];
$ContactsTbl = $GLOBALS['table_contacts'];

// Check if user exists
$result = $conn->prepare("SELECT UserID FROM $UsersTbl WHERE SessionToken='$SessionToken'");
$result->execute();
$amount = $result->rowCount();
if($amount <= 0)
{
    error("Token Not Valid");
    closeConnectionAndDie($conn);
}

// Get UserID
$result = $result->fetch();
$UserID = $result['UserID'];

// Insert contact
$result = $conn->prepare("INSERT INTO $ContactsTbl (OwnerID, FirstName, LastName, PhoneNumber, Email) VALUES ('$UserID', '$FirstName', '$LastName', '$PhoneNumber', '$Email')");
$result->execute();

// Close connection
$conn = null;

success(TRUE);

?>
