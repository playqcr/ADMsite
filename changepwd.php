<?php
/****************************************************
****   Advanced Data Manager
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
require('email_functions.php');
require('smtp.php');
include "tmp/header.php";

$uid = $_GET["uid"];
// echo "uid: ".$uid."<br>";
// exit;

global $PHP_SELF, $mysqli, $msg;
global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

//***************************************************************
// Attempt select query execution
$sql = "SELECT * FROM $users_tablename WHERE userid = '$uid'";
if ($result = mysqli_query($mysqli, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $uid = $row['userid'];
        $email = $row['useremail'];
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

$url = "http://localhost/__REPOSITORIES/admsite/resetpwd.php?uid=" . $uid;
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