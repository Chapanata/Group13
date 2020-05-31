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

	$CONN = dbConnection();
	$getUsr = $CONN->prepare("SELECT * FROM users where UserID=?");
	$getUsr->bindValue(1, $uid, PDO::PARAM_STR);
	$getUsr->execute();
	$usrRows = $getUsr->fetch(PDO::FETCH_ASSOC);

	$email = $usrRows['Email'];
	$name = $usrRows['Name'];
}

?>
