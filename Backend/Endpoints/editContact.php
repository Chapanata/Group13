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
if(isset($data->SessionToken) == FALSE || isset($data->ContactID) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$SessionToken = $data->SessionToken;
$ContactID = $data->ContactID;

// Optional data
$FirstName = $data->FirstName;
$LastName = $data->LastName;
$PhoneNumber = $data->PhoneNumber;
$Email = $data->Email;
$DeleteContact = $data->DeleteContact;

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

// Check if contact exists
$result = $conn->prepare("SELECT * FROM $ContactsTbl WHERE ContactID='$ContactID'");
$result->execute();
$amount = $result->rowCount();
if($amount <= 0)
{
    error("Contact not found");
    closeConnectionAndDie($conn);
}

// Check if user owns contact
$result = $result->fetch();
if($result['OwnerID'] != $UserID)
{
    error("No privilege");
    closeConnectionAndDie($conn);
}

// Update contact
$command = "UPDATE $ContactsTbl SET";

$FirstName = $data->FirstName;
$LastName = $data->LastName;
$PhoneNumber = $data->PhoneNumber;
$Email = $data->Email;

if(isset($FirstName))
    $command .= " FirstName='$FirstName', ";
if(isset($LastName))
    $command .= " LastName='$LastName', ";
if(isset($PhoneNumber))
    $command .= " PhoneNumber='$PhoneNumber', ";
if(isset($Email))
    $command .= " Email='$Email', ";
$command = rtrim($command, ', ');
$command .= "  WHERE ContactID='$ContactID'";
$result = $conn->prepare($command);
$result->execute();

// Delete Contact
if(isset($DeleteContact))
{
    if($DeleteContact == TRUE)
    {
        $updateUser = $conn->prepare("DELETE FROM $ContactsTbl WHERE ContactID='$ContactID'");
        $updateUser->execute();
    }
}

// Close connection
$conn = null;

success(TRUE);

?>
