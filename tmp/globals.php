<?php
global $dbhost, $dbusername, $dbpassword, $dbname, $mysqli;

// SERVER
// $dbhost = 'localhost';
// $dbusername = 'teemorco_school2';
// $dbpassword = 'TestSch00l2';
// $dbname = 'teemorco_school2';

// LOCALHOST
$dbhost = 'localhost';
$dbusername = 'admsite';
$dbpassword = 'Adm51t3Kewl';
$dbname = 'admsite';

$users_tablename = 'users';
$ticker_tablename = 'ticker';
$system_tablename = 'system';

//*****************************************************************************
//****************************** DB_CONNECT() *********************************
//*****************************************************************************
function dbconnect() {
    global $dbhost, $dbusername, $dbpassword, $dbname, $mysqli;
	
	$mysqli = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

	// Check connection
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
	}
}

