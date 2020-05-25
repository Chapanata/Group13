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
if(isset($data->SessionToken) == FALSE || isset($data->SearchQuery) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$SessionToken = $data->SessionToken;
$SearchQuery = trim($data->SearchQuery);

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

/*
 * select
 *
from
mytable a
WHERE
(a.title like 'somthing%'
OR a.title like '%somthing%'
OR a.title like 'somthing%')
ORDER BY case
WHEN a.title LIKE 'somthing%' THEN 1
WHEN a.title LIKE '%somthing%' THEN 2
WHEN a.title LIKE '%somthing' THEN 3
ELSE 4 END;*/
$result = $conn->prepare("SELECT ContactID, FirstName, LastName, PhoneNumber, Email FROM $ContactsTbl WHERE OwnerID='$UserID' AND

(
(FirstName LIKE '$SearchQuery%'
OR FirstName LIKE '%$SearchQuery%'
OR FirstName LIKE '$SearchQuery%')
OR
(
LastName LIKE '$SearchQuery%'
OR LastName LIKE '%$SearchQuery%'
OR LastName LIKE '$SearchQuery%'
)
OR
(
Email LIKE '$SearchQuery%'
OR Email LIKE '%$SearchQuery%'
OR Email LIKE '$SearchQuery%'
)
OR
(
PhoneNumber LIKE '$SearchQuery%'
OR PhoneNumber LIKE '%$SearchQuery%'
OR PhoneNumber LIKE '$SearchQuery%'
)
)
ORDER BY case
WHEN FirstName LIKE '$SearchQuery%' THEN 1
WHEN LastName LIKE '$SearchQuery%' THEN 1
WHEN Email LIKE '$SearchQuery%' THEN 1
WHEN PhoneNumber LIKE '$SearchQuery%' THEN 1
WHEN FirstName LIKE '%$SearchQuery%' THEN 2
WHEN LastName LIKE '%$SearchQuery%' THEN 2
WHEN Email LIKE '%$SearchQuery%' THEN 2
WHEN PhoneNumber LIKE '%$SearchQuery%' THEN 2
WHEN FirstName LIKE '%$SearchQuery' THEN 3
WHEN LastName LIKE '%$SearchQuery' THEN 3
WHEN Email LIKE '%$SearchQuery' THEN 3
WHEN PhoneNumber LIKE '%$SearchQuery' THEN 3
ELSE 4 END

LIMIT 250 ");

//"(FirstName LIKE '%$SarchQuery%'
//OR LastName LIKE '%$SearchQuery%'
//OR Email LIKE '%$SarchQuery%'
//OR PhoneNumber LIKE '%$SarchQuery%'
//) LIMIT 250");
$result->execute();
$result = $result->fetchAll();
$json = json_encode($result);

// Close connection
$conn = null;

die($json);

?>
