<?php
global $dbhost, $dbusername, $dbpassword, $dbname, $mysqli;

// SERVER
$dbhost = 'localhost';
$dbusername = 'teemorco_ihnschl';
$dbpassword = '1nh15nam3';
$dbname = 'teemorco_ihnschool';

// LOCALHOST
// $dbhost = 'localhost';
// $dbusername = 'ihnschl';
// $dbpassword = '1nh15nam3';
// $dbname = 'ihnbc';

$users_tablename = 'users';
$answers_tablename = 'answers';
$courses_tablename = 'courses';
$enrollments_tablename = 'enrollments';
$exams_tablename = 'exams';
$programs_tablename = 'programs';
$progenroll_tablename = 'progenroll';
$prog_det_tablename = 'prog_det';
$progenroll_tablename = 'progenroll';
$registration_tablename = 'registration';
$ticker_tablename = 'ticker';
$volunteers_tablename = 'volunteers';
$volunteerpos_tablename = 'volunteerpos';
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

