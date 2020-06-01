<?php
include '../session.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Create connection
$conn = dbConnection();
$ContactsTbl = $GLOBALS['table_contacts'];

$SearchQuery = trim($data->SearchQuery);
$SearchLength = strlen($SearchQuery);
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
if ($SearchLength > 0)
{
	error_log("SELECT * FROM $ContactsTbl WHERE OwnerID='$currentUser' AND (FirstName LIKE '".$SearchQuery."%' OR LastName LIKE '".$SearchQuery."%' OR Email LIKE '".$SearchQuery."%' OR Address LIKE '".$SearchQuery."%' OR PhoneNumber LIKE '".$SearchQuery."%') ORDER BY LastUpdated DESC");

	$result = $conn->prepare("SELECT * FROM $ContactsTbl WHERE OwnerID='$currentUser' AND (FirstName LIKE '".$SearchQuery."%' OR LastName LIKE '".$SearchQuery."%' OR Email LIKE '".$SearchQuery."%' OR Address LIKE '".$SearchQuery."%' OR PhoneNumber LIKE '".$SearchQuery."%') ORDER BY LastUpdated DESC");

}
else
{
	$result = $conn->prepare("SELECT * FROM $ContactsTbl WHERE OwnerID='$currentUser' ORDER BY LastUpdated DESC");
}

//"(FirstName LIKE '%$SarchQuery%'
//OR LastName LIKE '%$SearchQuery%'
//OR Email LIKE '%$SarchQuery%'
//OR PhoneNumber LIKE '%$SarchQuery%'
//) LIMIT 250");
$result->execute();
$result = $result->fetchAll();

echo json_encode($result);
// Close connection
$conn = null;
?>
