<?php
include 'dtb.php';
include 'utils.php';
include 'confirmCodeEmailTemplate.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

/* Desription:
 */
// Created by Samuel Arminana (armi.sam99@gmail.com)

$ini = parse_ini_file('php.ini');
$servername = $ini['db_server'];
$username = $ini['db_user'];
$password = $ini['db_password'];
$dbname = $ini['db_name'];
$tableusers = $ini['table_users'];
$tablecontacts = $ini['table_contacts'];

$fromEmail = $ini['app_email'];
$fromEmailPass = $ini['app_pass'];

// Read raw data from the request
$json = file_get_contents('php://input');
$data = json_decode($json);

// Confirm required data
if(isset($data->Email) == FALSE || isset($data->Username) == FALSE || isset($data->Password) == FALSE)
{
    error("Missing Parameters");
    die();
}

header('Content-Type: application/json');

// Get data
$Email = $data->Email;
$Username = $data->Username;
// Hash password
$Password = md5($data->Password);

// Confirm email
if (filter_var($Email, FILTER_VALIDATE_EMAIL) == FALSE)
{
    error("Email is not valid");
    die();
}

// Create connection
$conn = dbConnection();
// Check connection
if ($conn->connect_error) {
    error("Internal Error");
    closeConnectionAndDie($conn);
}

// Check if user exists
$sql =
    "SELECT * FROM `" . $tableusers . "` WHERE Username='" . $Username . "'";
$result = $conn->query($sql);
if($result == FALSE)
{
    error("Internal Error" . $conn->error);
    closeConnectionAndDie($conn);
}
if(mysqli_num_rows($result) > 0)
{
    error("User Exists");
    closeConnectionAndDie($conn);
}

// Generate confirm code
$confirmCode = rand(1000,9999);

// Send email
$mail = new PHPMailer;
$mail->SMTPDebug = 3;
$mail->isSMTP();
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = $fromEmail;
$mail->Password = $fromEmailPass;
$mail->Port = 587;

$mail->From = $fromEmail;
$mail->addAddress($Email);
$mail->isHTML(true);
$mail->Subject = "Your Registration to POOP";
$mail->Body = getEmail($confirmCode);
$mail->AltBody = "Your confirmation code is " . $confirmCode;

if(!$mail->send())
{
    error("Internal Error 2 " . $fromEmailPass . $fromEmail . $conn->error);
    closeConnectionAndDie($conn);
}

// Add user entry
// TODO

// Close connection
$conn->close();
?>
