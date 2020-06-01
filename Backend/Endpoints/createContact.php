<?php
include '../session.php';
date_default_timezone_set("America/New_York");
$today_date = date("Y-m-d H:i:s");

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];
$ContactsTbl = $GLOBALS['table_contacts'];

$currentUser = "";

// Instance Verification
if (isset($data->SessionToken))
{
	// Through API
	$sToken = $data->SessionToken;
	$getuid = $conn->prepare("SELECT UserID FROM $UsersTbl WHERE SessionToken='$sToken'");
	$getuid->execute();
	$getuid = $getuid->fetch();
	$currentUser = $getuid['UserID'];
}
else
{
	// If UserID is missing, SessionToken must be missing
	if (!isset($uid))
	{
		error("Missing SessionToken");
		die();
	}

	// Through Session
	$currentUser = $uid;
}


// Contact Data
$FirstName = (isset($data->FirstName)?$data->FirstName:"");
$LastName = (isset($data->LastName)?$data->LastName:"");
$PhoneNumber = (isset($data->PhoneNumber)?$data->PhoneNumber:"");
$Email = (isset($data->Email)?$data->Email:"");
$Address = (isset($data->Address)?$data->Address:"");

// INSERT
$result = $conn->prepare("INSERT INTO $ContactsTbl VALUES ('$currentUser',DEFAULT, '$FirstName', '$LastName', '$PhoneNumber', '$Email','$Address','$today_date','$today_date')");
$result->execute();
$result = null;

$result = $conn->prepare("SELECT MAX(ContactID) AS LU FROM $ContactsTbl WHERE OwnerID='$currentUser'");
$result->execute();
$result = $result->fetch();

echo (json_encode(array('Success' => TRUE,'ReturnedID' => $result['LU'])));

// Close connection
$conn = null;


?>
