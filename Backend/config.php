<?php

/* Desription: This is our config data and other scripts can include it to access these values
 **/
// Created by Samuel Arminana (armi.sam99@gmail.com)

$ini = parse_ini_file('php.ini');

global $database_host;
global $database_user;
global $database_pass;
global $database_name;

$database_host = $ini['database_host'];
$database_user = $ini['database_user'];
$database_pass = $ini['database_pass'];
$database_name = $ini['database_name'];

$table_users = $ini['table_users'];
$table_contacts = $ini['table_contacts'];

$app_email = $ini['app_email'];
$app_pass = $ini['app_pass'];

?>