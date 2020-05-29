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

// Confirm required data
if(isset($data->Email) == FALSE || isset($data->Password) == FALSE)
{
    // do something
	error("Missing Parameters");
    die();
}

// Get data
$Email = $data->Email;
// Hash password
$Password = md5($data->Password);

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT UserID, Name, Confirmed FROM $UsersTbl WHERE Email='$Email' AND Password='$Password'");
$result->execute();
$amount = $result->rowCount();

// No user found
if($amount <= 0)
{
    error("Incorrect email or password.");
    closeConnectionAndDie($conn);
}

// Check confirmed
$result = $result->fetch();
if($result['Confirmed'] != 1)
{
    error("User not confirmed");
    closeConnectionAndDie($conn);
}

// Generate Session Token
$SessionToken = uniqid('', TRUE);

// Update user's session token
$updateUser = $conn->prepare("UPDATE $UsersTbl SET SessionToken='$SessionToken' WHERE Email='$Email'");
$updateUser->execute();

// Close connection
$conn = null;

// Return Back
$_SESSION['current_uid'] = $result['UserID'];
$_SESSION['current_name'] = $result['Name'];
$_SESSION['current_email'] = $Email;

user($result['UserID'], $result['Name'], $SessionToken);


?>
