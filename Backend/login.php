<?php
include 'connection.php';
include 'confirmCodeEmailTemplate.php';
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

/*
Created by Samuel Arminana (armi.sam99@gmail.com)
 */

// Set response header
header('Content-Type: application/json');

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(isset($data->Username) == FALSE || isset($data->Password) == FALSE)
{
    // do something
    error("Missing Parameters");
    die();
}

// Get data
$Username = $data->Username;
// Hash password
$Password = md5($data->Password);

// Create connection
$conn = dbConnection();
// Check connection
if ($conn->connect_error) {
    error("Internal Error");
    closeConnectionAndDie($conn);
}

// Check if user exists
$result = $conn->query("SELECT (Confirmed) FROM $table_users WHERE Username='$Username' AND Password='$Password'");

if($result == FALSE)
{
    error("Internal Error");
    closeConnectionAndDie($conn);
}

if(mysqli_num_rows($result) > 0)
{
    $row = $result->fetch_assoc();
    if($row["Confirmed"] == FALSE)
    {
        error("User not confirmed");
        die();
    }
    success($row["Confirmed"]);
    closeConnectionAndDie($conn);
}
success(false);

// Close connection
$conn->close();
?>
