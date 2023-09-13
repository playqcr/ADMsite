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

// Grab action
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = '';
}
//*******************************************************
//*******************  MAIN FORM  ***********************
//*******************************************************

function main_form() {
	global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

    include "tmp/loginhead.php";
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4" style="padding-top: 50px;">
                <?php echo $msg; ?>
                <h4>Please enter the email address you registered with.</h4>
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" size="30" id="Uname" name="useremail" aria-describedby="emailHelp" style="align-content: center;">
                    </div>
                    <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Submit">Submit</button>
                    <br>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
    <?php
    include "tmp/footer.php";
}

//*******************************************************
//*******************  CHECK LOGIN  *********************
//*******************************************************

function check_login() {
    global $PHP_SELF, $mysqli, $sql, $msg, $pwd, $useremail1, $userpassword1, $useremail2, $userpassword2, $result;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

    $useremail1 = filter_var($_POST['useremail'], FILTER_SANITIZE_EMAIL);

    if (empty($useremail1)) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Enter An Email Address!
        </div>";
        main_form();
        exit;
    }

    // Attempt select query execution
    $sql = "SELECT * FROM $users_tablename WHERE useremail = '$useremail1'";
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
        main_form();
    }
    // End attempt select query execution

    $_SESSION['uid'] = $uid;
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
switch($action) {
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