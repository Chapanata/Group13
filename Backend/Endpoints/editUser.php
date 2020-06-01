<?php
include '../session.php';

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);


if (!isset($data->Task))
{
	error("Task not initiated");
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
	$uid = $getuid['UserID'];
}
else
{
	// Through Session
	$currentUser = $uid;
}


// Tasks
if ($Task == 1)
{
	// Change Name
	if (!isset($data->FullName))
	{
		error("Missing Name Parameter");
		die();
	}

	$Name = $data->FullName;
	error_log("UPDATE $UsersTbl SET Name='$Name' WHERE UserID='$currentUser' ");
	error_log(" '$Password' '$Task' '$Name'");
	$result = $conn->prepare("UPDATE $UsersTbl SET Name='$Name' WHERE UserID='$currentUser' ");
	$result->execute();
	success(TRUE);

}
else if ($Task == 2)
{
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
		$ers .= "Password Must Contain uppercases.";
 		// There is no upper
	}
	if (strlen($data->Confirm) < 8)
	{
		// Length is less than 8
		$ers .= "Password Must Be Longer than 8 characters.";
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


