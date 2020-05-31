<?php
include '../connection.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(isset($data->SessionToken) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$SessionToken = $data->SessionToken;

// Optional data
$Name = $data->Name;
if(isset($data->Password))
    $Password = md5($data->Password);   // Hash password
else
    $Password = NULL;
$DeleteUser = $data->DeleteUser;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT * FROM $UsersTbl WHERE SessionToken='$SessionToken'");
$result->execute();
$amount = $result->rowCount();
if($amount <= 0)
{
    error("Token Not Valid");
    closeConnectionAndDie($conn);
}

if(isset($Name) || isset($Password))
{
    $command = "UPDATE $UsersTbl SET";

    // Don't judge me here...

    // Update Name
    if(isset($Name))
    {
        $command .= " Name='$Name'";
    }
    // Update Password
    if(isset($Password))
    {
        if(isset($Name))
        {
            $command .= ",";
        }
        $command .= " Password='$Password'";
    }

    // Resume judgement

    $command .= " WHERE SessionToken='$SessionToken'";
    $updateUser = $conn->prepare($command);
    $updateUser->execute();
}

// Delete User
if(isset($DeleteUser))
{
    if($DeleteUser == TRUE)
    {
        $updateUser = $conn->prepare("DELETE FROM $UsersTbl WHERE SessionToken='$SessionToken'");
        $updateUser->execute();
    }
}

// Close connection
$conn = null;

success(TRUE);

?>


