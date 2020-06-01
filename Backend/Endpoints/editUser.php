<?php
include '../session.php';

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);


if (!isset($data->Task))
{
	error("Task Not Initiated");
	die();
}

$Task = intval($data->Task);
$Password = "";
$Name = "";

// Connection
$conn = dbConnection();
$ContactsTbl = $GLOBALS['table_contacts'];
$UsersTbl = $GLOBALS['table_users'];
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


// Tasks
if ($Task == 1)
{
	// Missing Name
	if (!isset($data->FullName))
	{
		error("Missing Name Parameter");
		die();
	}

	// Change Name
	$Name = $data->FullName;
	$result = $conn->prepare("UPDATE $UsersTbl SET Name='$Name' WHERE UserID='$currentUser' ");
	$result->execute();
	success(TRUE);
}
else if ($Task == 2)
{
	// Missing Password & Confirm
	if (!isset($data->Password))
	{
		error("Missing Password Parameter");
		die();
	}

	if (!isset($data->Confirm))
	{
		error("Missing Confirm Parameter");
		die();
	}

	$ers = "";
	if ($data->Password != $data->Confirm)
	{
		// No Match
		$ers .= "Password Must Match.";
	}

	if(!preg_match('/[A-Z]/', $data->Confirm))
	{
		$ers .= "Password Must Contain Uppercases.";
 		// There is no upper
	}

	if (strlen($data->Confirm) < 8)
	{
		// Length is less than 8
		$ers .= "Password Must Be Longer than 8 Characters.";
	}

	if (strlen($ers) > 0)
	{
		// Execute Errors
		error($ers);
		closeConnectionAndDie($conn);
	}
	else
	{
		// Change Password
		$Password = md5($data->Confirm);
		$result = $conn->prepare("UPDATE $UsersTbl SET Password='$Password' WHERE UserID='$currentUser' ");
		$result->execute();
		success(TRUE);
	}
}


// Close connection
$conn = null;

?>


