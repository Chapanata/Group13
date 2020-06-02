<?php
include '../session.php';

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->SearchQuery))
{
	error("Missing SearchQuery Parameter");
	die();
}

// Create connection
$conn = dbConnection();
$ContactsTbl = $GLOBALS['table_contacts'];

$SearchQuery = trim($data->SearchQuery);
$SearchLength = strlen($SearchQuery);
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


if ($SearchLength > 0)
{
	$result = $conn->prepare("SELECT * FROM $ContactsTbl WHERE OwnerID='$currentUser' AND (FirstName LIKE '%".$SearchQuery."%' OR LastName LIKE '%".$SearchQuery."%' OR Email LIKE '%".$SearchQuery."%' OR Address LIKE '%".$SearchQuery."%' OR PhoneNumber LIKE '%".$SearchQuery."%') ORDER BY LastUpdated DESC");
}
else
{
	$result = $conn->prepare("SELECT * FROM $ContactsTbl WHERE OwnerID='$currentUser' ORDER BY LastUpdated DESC LIMIT 10");
}

$result->execute();
$result = $result->fetchAll();

echo json_encode($result);
// Close connection
$conn = null;
?>
