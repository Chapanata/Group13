<?php

function dbConnection()
{
	// Returns a PHP Data Object containing the Database connection
	return (new PDO('mysql:host=localhost;dbname=contact_deluxe','cmd_user','Kjs18E&9'));
}

function error($errorMsg)
{
    $error = array('Error' => $errorMsg);
    echo(json_encode($error));
}

function closeConnectionAndDie($conn)
{
    $conn->close();
    die();
}

?>
