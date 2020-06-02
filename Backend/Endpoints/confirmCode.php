<?php
include '../connection.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Get data
$Email = $_GET['Email'];
$Code = $_GET['Code'];

// Confirm required data
if(isset($Email) == FALSE || isset($Code) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->query("SELECT Email, Confirmed, ConfirmCode FROM $UsersTbl WHERE Email='$Email'");
$amount = $result->rowCount();
if($amount <= 0)
{
    error("Email is not valid");
    closeConnectionAndDie($conn);
}

// Check if code matches
$result = $result->fetch();
if($result['ConfirmCode'] != $Code)
{
    error("Code Does not match");
    closeConnectionAndDie($conn);
}

// Update user's confirmed status
$updateUser = $conn->prepare("UPDATE $UsersTbl SET ConfirmCode = '0', Confirmed = '1' WHERE Email='$Email'");
$updateUser->execute();

// Close connection
$conn = null;

// User is not confirmed, redirect to home page
if($result['Confirmed'] == 0)
{
    header("Location: https://jorde.dev/");
}

// User is confirmed, redirect to reset password page
if($result['Confirmed'] == 1)
{
    header("Location: https://jorde.dev/ResetPassword");
}

die();

success(TRUE);

?>
