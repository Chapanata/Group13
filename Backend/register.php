<?php
include 'connection.php';
include 'confirmCodeEmailTemplate.php';


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


// Get data
$Email = $data->Email;
$Username = $data->Username;
// Hash password
$Password = md5($data->Password);

echo $Email;
echo $Username;
echo $Password;

// Create connection
$conn = dbConnection();
$UsersTbl = $GLOBALS['table_users'];

// Check if user exists
$result = $conn->prepare("SELECT Username FROM $UsersTbl WHERE Username='$Username'");
$result->execute();
$amount = $result->rowCount();

if($amount > 0)
{
    error("Internal Error" . $conn->error);
    closeConnectionAndDie($conn);
}

// Generate confirm code
$confirmCode = rand(1000,9999);
/*
// Send email
$mail = new PHPMailer;
$mail->SMTPDebug = 3;
$mail->isSMTP();
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = $app_email;
$mail->Password = $app_pass;
$mail->Port = 587;

$mail->From = $app_email;
$mail->addAddress($Email);
$mail->isHTML(true);
$mail->Subject = "Your Registration to POOP";
$mail->Body = getEmail($confirmCode);
$mail->AltBody = "Your confirmation code is " . $confirmCode;

if(!$mail->send())
{
    error("Internal Error " . $app_pass . $app_email . $conn->error);
    closeConnectionAndDie($conn);
}
*/
// Add user entry
$result = null;

$createUser = $conn->prepare("INSERT INTO $UsersTbl (UserID,Email, Username, Password, ConfirmCode) VALUES (DEFAULT,'$Email', '$Username', '$Password', '$confirmCode')");
$createUser->execute();

// Close connection
$conn = null;

?>
