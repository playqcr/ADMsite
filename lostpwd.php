<?php

/****************************************************
 ****   QCR Intranet Project                       ***
 ****   Designed by: Tom Moore                     ***
 ****   Written by: Tom Moore                      ***
 ****   (c) 2008 TEEMOR eBusiness Solutions        ***
 ****************************************************/
require "includes/globals.php";
require('email_functions.php');
require('smtp.php');
session_start();
db_connect();

if ($mysqli->connect_error) {
    echo 'Failed to connect to server: (' . $mysqli->connect_error . ') ' . $mysqli->connect_error;
}

// Grab action
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = '';
}
//*******************************************************
//*******************  MAIN FORM  ***********************
//*******************************************************

function main_form()
{
    global $PHP_SELF, $mysqli, $msg;
    global $employees_tablename, $userid, $fname, $lname, $empid, $email, $department, $phone, $extension, $fax, $did, $access, $username, $password, $License, $position, $YosAccess, $YosSys, $SecureAccess, $SecureSys, $compname, $CallTraxSys, $dept_market, $dept_safety, $dept_tg, $dept_tga, $dept_training, $dept_evs, $dept_facility, $dept_tgo, $imgpath, $resetpwd, $isactive, $isadmin;

    include 'templates/include.php';
    include 'templates/styles.tpl';

?>
    <script language="JavaScript">
        function function1() {
            document.all.Uname.focus();
        }
    </script>
    <!-- <html>
<head>
<title>Forgot Password</title> -->
    <style type="text/css">
        #Uname {
            width: 200px;
        }
    </style>
    <!-- </head> -->

    <body onLoad="document.all.Uname.focus()">
        <div class='container-fluid'>
            <div class="row">
                <div class="col-12 text-center" style="padding-top: 100px;">
                    <center>
                        <p><b>Please enter your email address below and click on the submit button. You will be sent a link in your email.<br>When you get it just click the link which will take you to a page that allows you to enter a new password.</b></p>
                        <br>
                        <br>
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" size="30" id="Uname" name="email" aria-describedby="emailHelp" style="align-content: center;">
                            </div>
                            <button type="submit" name="action" class="btn btn-primary" value="Submit">Submit</button>
                            <!--table align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="text-align: right">
                                Email Address:</td>
                            <td>
                                <input maxlength="50" id="Uname" name="email" size="30" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            <center><input name="action" type="submit" value="Submit" /></center>
                        </tr>
                    </table-->
                        </form>
                    </center>
                </div>
            </div>
        </div>

        <?php include "templates/footer.tpl"; ?>
    </body>

    </html>
    <?php
}

//*******************************************************
//*******************  CHECK LOGIN  *********************
//*******************************************************

function check_login()
{
    global $PHP_SELF, $mysqli, $msg;
    global $employees_tablename, $userid, $fname, $lname, $empid, $email, $department, $phone, $extension, $fax, $did, $access, $username, $password, $License, $position, $YosAccess, $YosSys, $SecureAccess, $SecureSys, $compname, $CallTraxSys, $dept_market, $dept_safety, $dept_tg, $dept_tga, $dept_training, $dept_evs, $dept_facility, $dept_tgo, $imgpath, $resetpwd, $isactive, $isadmin;

    $email = $_POST['email'];

    // Attempt select query execution
    $sql = "SELECT * FROM $employees_tablename WHERE email = '$email'";
    if ($result = mysqli_query($mysqli, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $uid = $row['userid'];
            // Free result set
            mysqli_free_result($result);
        } else {
            $msg = "<div class='alert alert-danger' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            <strong>ERROR!</strong> Email Address Does Not Exist!
            </div>";
            main_form();
        }
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
        </div>";
        echo "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
        </div>";
    }
    // End attempt select query execution

    $_SESSION['uid'] = $uid;

    if (empty($email)) {
        echo "\rYou Must Enter An Email Address";
    ?>
        <FORM METHOD="POST" ACTION="<?php echo $PHP_SELF ?>">
            <INPUT TYPE="SUBMIT" VALUE="Try Again" name="action">
        </FORM>
    <?php
        exit;
    } elseif (!$uid or empty($uid)) {
        echo "\rNo account found with that email address!";
    ?>
        <FORM METHOD="POST" ACTION="<?php echo $PHP_SELF ?>">
            <INPUT TYPE="SUBMIT" VALUE="Try Again" name="action">
        </FORM>
<?php
        exit;
    }
    welcome_back();
}

//*******************************************************
//*******************  WELCOME BACK  ***********************
//*******************************************************
function welcome_back()
{
    global $PHP_SELF, $mysqli, $msg;
    global $employees_tablename, $userid, $fname, $lname, $empid, $email, $department, $phone, $extension, $fax, $did, $access, $username, $password, $License, $position, $YosAccess, $YosSys, $SecureAccess, $SecureSys, $compname, $CallTraxSys, $dept_market, $dept_safety, $dept_tg, $dept_tga, $dept_training, $dept_evs, $dept_facility, $dept_tgo, $imgpath, $resetpwd, $isactive, $isadmin;

    $uid = $_SESSION['uid'];
    header("Location: changepwd.php?uid=" . $uid);
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch ($action) {
    case "Try Again":
        main_form();
        break;
    case "Submit":
        check_login();
        break;
    default:
        main_form();
        break;
}

?>