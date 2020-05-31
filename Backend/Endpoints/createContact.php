<?php
include '../session.php';
date_default_timezone_set("America/New_York");
$today_date = date("Y-m-d H:i:s");

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Optional data
$FirstName = $data->FirstName;
$LastName = $data->LastName;
$PhoneNumber = $data->PhoneNumber;
$Email = $data->Email;
$Address = $data->Address;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];
$ContactsTbl = $GLOBALS['table_contacts'];

$currentUser = "";
// Running through api
if (isset($data->SessionToken))
{
	$sToken = $data->SessionToken;
	$getuid = $conn->prepare("SELECT UserID FROM $UsersTbl WHERE SessionToken='$sToken'");
	$getuid->execute();
	$getuid = $getuid->fetch();
	$uid = $getuid['UserID'];
}
else
{
	$currentUser = $uid;
}
// Insert contact
$result = $conn->prepare("INSERT INTO $ContactsTbl VALUES ('$currentUser',DEFAULT, '$FirstName', '$LastName', '$PhoneNumber', '$Email','$Address','$today_date','$today_date')");
$result->execute();

$result = null;

$result = $conn->prepare("SELECT MAX(ContactID) AS LU FROM $ContactsTbl WHERE OwnerID='$uid'");
$result->execute();
$result = $result->fetch();

echo (json_encode(array('Success' => TRUE,'ReturnedID' => $result['LU'])));

// Close connection
$conn = null;


?>
