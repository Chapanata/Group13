<?php
session_name('contact');
if(!isset($_SESSION))
{
	session_start();
}
// Loads database config
include('connection.php');
// Storing Session

global $uid;
global $name;
global $email;

if (isset($_SESSION['current_uid']))
{
	$uid = $_SESSION['current_uid'];
	$email = $_SESSION['current_email'];
	$name = $_SESSION['current_name'];
}

?>
