<?php
include '../session.php';

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);



$Task = intval($data->Task);
if (!isset($Task))
{
	error("Task not init");
	die();
}
$Password = "";
$Name = "";

// Create connection
$conn = dbConnection();
$ContactsTbl = $GLOBALS['table_contacts'];
$UsersTbl = $GLOBALS['table_users'];
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



// Change Name
if ($Task == 1)
{
	$Name = $data->FullName;
	error_log("UPDATE $UsersTbl SET Name='$Name' WHERE UserID='$currentUser' ");
	error_log(" '$Password' '$Task' '$Name'");
	$result = $conn->prepare("UPDATE $UsersTbl SET Name='$Name' WHERE UserID='$currentUser' ");
	$result->execute();
	success(TRUE);

}
else if ($Task == 2)
{
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
	error($ers);
	closeConnectionAndDie($conn);
}else
{
	$Password = md5($data->Confirm);   // Hash password
	$result = $conn->prepare("UPDATE $UsersTbl SET Password='$Password' WHERE UserID='$currentUser' ");
	$result->execute();
	success(TRUE);

}
// Change Password

}


// Close connection
$conn = null;


?>


