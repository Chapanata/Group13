<?php

include 'config.php';

function dbConnection()
{
	// Returns a PHP Data Object containing the Database connection

	return (new PDO('mysql:host='.$GLOBALS['database_host']. ';dbname=' . $GLOBALS['database_name'], $GLOBALS['database_user'] , $GLOBALS['database_pass']));
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

function user($userID, $name)
{
    $error = array('UserID' => $userID, 'Name' => $name);
    echo(json_encode($error));
}

function closeConnectionAndDie($conn)
{
    $conn->close();
    die();
}

?>
