<?php
/****************************************************
****   IHN Bible College
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
include 'tmp/globals.php';
session_start();
dbconnect();

if ($mysqli->connect_error) {
    echo 'Failed to connect to server: (' . $mysqli->connect_error . ') ' . $mysqli->connect_error;
}

$uid = $_GET["uid"];

global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body;
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

$url = "https://ihnschool.org/newschool2/resetpwd.php?uid=" . $uid;
$subject = "Password Reset Request";
$message = "Someone has requested your password be changed.

If this is not you then simply disregard this email. Nothing more will happen.<br>Test

However, if you did requst to change your password please click the link below to reset your password now.

" . $url;
//$to = $_POST['to'];

$header = "From:ihnbible@gmail.com \r\n";
// $header .= "Cc:afgh@somedomain.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";


// send email
$retval = mail($email,$subject,$message,$header);

// Send email
// hesk_mail($email, $subject, $message);

// Show success
//$show_sent_email_message = true;
//$msg = "<br>Mail supposedly sent.";

    include "tmp/loginhead.php";
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4" style="padding-top: 50px;">
                <?php echo $msg; ?>
                <h4>An email has been sent to you.</h4>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <p>An email has been sent to you. Please click the link in the email and follow the directions.</p>
                    </div>
                    <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Submit">Continue</button>
                    <br>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
    <?php
    include "tmp/footer.php";
?>