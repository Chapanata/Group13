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
error_log($json);
$data = json_decode($json);

// Edit: 1 Delete:2
$Task = intval($data->Task);
$ContactID = $data->ContactID;

// Create connection
$conn = dbConnection();
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
error_log($Task);
if ($Task == 1)
{
	$FirstName = $data->FirstName;
	$LastName = $data->LastName;
	$PhoneNumber = $data->PhoneNumber;
	$Email = $data->Email;
	$Address = $data->Address;

	$result = $conn->prepare("UPDATE $ContactsTbl SET FirstName='$FirstName',LastName='$LastName', PhoneNumber='$PhoneNumber', Email='$Email',Address='$Address',LastUpdated='$today_date' WHERE ContactID='$ContactID' and OwnerID='$currentUser'");
	$result->execute();
}
else if ($Task == 2)
{
	$result = $conn->prepare("DELETE FROM $ContactsTbl WHERE OwnerID='$currentUser' AND ContactID='$ContactID';");
	$result->execute();
}


// Close connection
$conn = null;

success(TRUE);

?>

