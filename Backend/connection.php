<?php

include 'config.php';

function dbConnection()
{
    include 'config.php';
	// Returns a PHP Data Object containing the Database connection
	return (new PDO('mysql:host='. $database_host . ';dbname=' . $database_name, $database_user, $database_pass));
}

function error($errorMsg)
{
    $error = array('Error' => $errorMsg);
    echo(json_encode($error));
}

function success($success)
{
    $error = array('Success' => $success);
    echo(json_encode($error));
}

function closeConnectionAndDie($conn)
{
    $conn->close();
    die();
}

?>
