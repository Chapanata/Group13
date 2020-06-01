<?php
include '../session.php';
date_default_timezone_set("America/New_York");
$today_date = date("Y-m-d H:i:s");

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->Task))
{
	error("Missing Task Parameter");
	die();
}

if (!isset($data->ContactID))
{
	error("Missing ContactID Parameter");
	die();
}

$Task = intval($data->Task);
$ContactID = $data->ContactID;

// Create connection
$conn = dbConnection();
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
		error("Missing SessionToken Parameter");
		die();
	}

	// Through Session
	$currentUser = $uid;
}

if ($Task == 1)
{
	$FirstName = (isset($data->FirstName)?"FirstName='".$data->FirstName."',":"");
	$LastName = (isset($data->LastName)?"LastName='".$data->LastName."',":"");
	$PhoneNumber = (isset($data->PhoneNumber)?"PhoneNumber='".$data->PhoneNumber."',":"");
	$Email = (isset($data->Email)?"Email='".$data->Email."',":"");
	$Address = (isset($data->Address)?"Address='".$data->Address."',":"");

	$result = $conn->prepare("UPDATE $ContactsTbl SET $FirstName $LastName $PhoneNumber $Email $Address LastUpdated='$today_date' WHERE ContactID='$ContactID' and OwnerID='$currentUser'");
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

