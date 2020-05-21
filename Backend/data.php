<?php

/* Desription: This is our config data and other scripts can include it to access these values
 **/
// Created by Samuel Arminana (armi.sam99@gmail.com)

$ini = parse_ini_file('php.ini');
$table_users = $ini['table_users'];
$table_contacts = $ini['table_contacts'];
$app_email = $ini['app_email'];
$app_pass = $ini['app_pass'];

?>