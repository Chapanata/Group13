
<?php

include '../session.php';
date_default_timezone_set("America/New_York");
$today_date = date("Y_m_dHis");
/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */
$fileName = "exportedContacts_".$today_date.".csv";
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
// Set response header

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);


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







//The name of the CSV file that will be downloaded by the user.
$fileName = 'myContacts.csv';

//Set the Content-Type and Content-Disposition headers.
header('Content-Type: application/excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

//A multi-dimensional array containing our CSV data.
$data = array();
$header = array("ContactID","First Name","Last Name","Email","Address","Date Created");
array_push($data,$header);
$result = $conn->prepare("SELECT ContactID,FirstName,LastName,PhoneNumber,Email,Address,DateCreated FROM $ContactsTbl WHERE OwnerID='$currentUser' ORDER BY FirstName ASC");
$result->execute();
foreach($result as $row)
{
	$n_array = array($row['ContactID'],$row['FirstName'],$row['LastName'],$row['Email'],$row['Address'],$row['DateCreated']);
	array_push($data,$n_array);
}







//Open up a PHP output stream using the function fopen.
$fp = fopen('php://output', 'w');

//Loop through the array containing our CSV data.
foreach ($data as $row) {
    //fputcsv formats the array into a CSV format.
    //It then writes the result to our output stream.
    fputcsv($fp, $row);
}

//Close the file handle.
fclose($fp);

?>
