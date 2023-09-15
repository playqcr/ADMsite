<?php

/****************************************************
 ****   QCR Intranet Project                       ***
 ****   Designed by: Tom Moore                     ***
 ****   Written by: Tom Moore                      ***
 ****   (c) 2008 TEEMOR eBusiness Solutions        ***
 ****************************************************/
require('email_functions.php');
require('smtp.php');
require "includes/globals.php";
session_start();
db_connect();

if ($mysqli->connect_error) {
    echo 'Failed to connect to server: (' . $mysqli->connect_error . ') ' . $mysqli->connect_error;
}

$uid = $_GET["uid"];

global $PHP_SELF, $mysqli, $msg;
global $employees_tablename, $userid, $fname, $lname, $empid, $email, $department, $phone, $extension, $fax, $did, $access, $username, $password, $License, $position, $YosAccess, $YosSys, $SecureAccess, $SecureSys, $compname, $CallTraxSys, $dept_market, $dept_safety, $dept_tg, $dept_tga, $dept_training, $dept_evs, $dept_facility, $dept_tgo, $imgpath, $resetpwd, $isactive, $isadmin;

//***************************************************************
// Attempt select query execution
$sql = "SELECT * FROM $employees_tablename WHERE userid = '$uid'";
if ($result = mysqli_query($mysqli, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $uid = $row['userid'];
        $email = $row['email'];
        // Free result set
        mysqli_free_result($result);
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> UserID Not Found!
        </div>";
    }
} else {
    $msg = "<div class='alert alert-danger' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
    </div>";
}
// End attempt select query execution

$url = "http://qcr-net/depts/support/resetpwd.php?uid=" . $uid;
$subject = "Password Reset Request";
$message = "Someone has requested your password be changed.

If this is not you then simply disregard this email. Nothing more will happen.<br>Test

However, if you did requst to change your password please click the link below to reset your password now.

" . $url;
//$to = $_POST['to'];

// Send email
hesk_mail($email, $subject, $message);

// Show success
//$show_sent_email_message = true;
//$msg = "<br>Mail supposedly sent.";
?>
<html>

<head>

</head>

<body>
    <center>
        <h1>An email has been sent to you.</h1>
        <p>An email has been sent to you. Please click the link in the email and follow the directions.</p>
    </center>
</body>

</html>
<?php
//***************************************************************
?>