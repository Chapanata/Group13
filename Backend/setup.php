<?php
include 'connection.php';
include 'config.php';

/* Desription: This sets up our enviornment.
 * Step 1. Setup User table
 *	 - Drop table
 *	 - Create table
 * Step 2. Setup Contacts table
 *	 - Drop table
 *	 - Create table
 **/

// Create connection
$conn = dbConnection();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/********************************************************************
 *********************** USERS TABLE ********************************
 ********************************************************************/
// Drop Users table
$sql =
    "DROP TABLE `" . $table_users . "`;";
$conn->query($sql);

// Create Users table
$sql =
    "CREATE TABLE `$table_users` (
		`UserID` INT NOT NULL AUTO_INCREMENT,
		`Password` VARCHAR(255),
		`Email` VARCHAR(255),
		`ConfirmCode` INT,
		`Confirmed` BOOLEAN,
		`Name` VARCHAR(255),
		PRIMARY KEY (`UserID`)
		);";
if ($conn->query($sql) === FALSE)
{
    echo "Error creating Users Table: " . $conn->error;
    $conn->close();
    die();
}


/********************************************************************
 ********************** Contacts TABLE ******************************
 ********************************************************************/
// Drop Contacts table
$sql =
    "DROP TABLE `" . $table_contacts . "`;";
$conn->query($sql);

// Create Contacts table
$sql =
    "CREATE TABLE `" . $table_contacts . "` (
		`UserID` INT NOT NULL AUTO_INCREMENT,
		`OwnerID` INT,
		`FirstName` VARCHAR(255),
		`LastName` VARCHAR(255),
		`PhoneNumber` VARCHAR(12),
		`Email` VARCHAR(255),
		PRIMARY KEY (`UserID`)
		);";
if ($conn->query($sql) === FALSE)
{
    echo "Error creating Contacts Table: " . $conn->error;
    $conn->close();
    die();
}


/********************************************************************
 ********************** Completed Setup *****************************
 ********************************************************************/
$conn->close();
echo "Successfully Completed Setup";
?>
