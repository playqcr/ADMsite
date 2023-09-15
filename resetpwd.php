<?php

/****************************************************
 ****   QCR Intranet Project                       ***
 ****   Designed by: Tom Moore                     ***
 ****   Written by: Tom Moore                      ***
 ****   (c) 2008 TEEMOR eBusiness Solutions        ***
 ****************************************************/
require "includes/globals.php";
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

    $uid = $_GET["uid"];

    $warning = "<div class='alert alert-danger' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>SUCCESS!</strong> We have recently increase our password protection security. Please update your password!
    </div>";
?>
    <html>

    <head></head>

    <body>
        <?php echo $warning; ?>
        <div class='container-fluid'>
            <div class="row" style="padding-top: 100px;">
                <div class="col-4"></div>
                <div class="col-4 text-center">
                    <center>
                        <h1>Update Your Password</h1>
                        <?php echo $msg; ?>
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="mb-3">
                                <label for="password1" class="form-label">Enter New Password</label>
                                <input type="password" name="password1" class="form-control" id="password1">
                            </div>
                            <div class="mb-3">
                                <label for="password2" class="form-label">Re-enter Password</label>
                                <input type="password" name="password2" class="form-control" id="password2">
                            </div>
                            <button type="submit" name="action" class="btn btn-primary" value="Update">Update</button>
                        </form>
                    </center>
                </div>
                <div class="col-4" style="padding-top: 100px;"></div>
            </div>
        </div>
        </div>

        <?php include "templates/footer.tpl"; ?>
    </body>

    </html>
<?php
}

//*******************************************************
//*******************  UPDATE ***************************
//*******************************************************
function update_form()
{
    global $PHP_SELF, $mysqli, $msg;
    global $employees_tablename, $userid, $fname, $lname, $empid, $email, $department, $phone, $extension, $fax, $did, $access, $username, $password, $License, $position, $YosAccess, $YosSys, $SecureAccess, $SecureSys, $compname, $CallTraxSys, $dept_market, $dept_safety, $dept_tg, $dept_tga, $dept_training, $dept_evs, $dept_facility, $dept_tgo, $imgpath, $resetpwd, $isactive, $isadmin;

    $uid = $_GET["uid"];
    $password1 = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
    $password2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);

    $pattern_up = "/^.*(?=.{8,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
    if (!preg_match($pattern_up, $password1)) {
        $msg = "Must be at least 8 characters long, 1 upper case, 1 lower case letter and 1 number.";
        main_form();
        exit;
    }

    if (empty($password1)) {
        $msg = "You must enter a password!";
        main_form();
        exit;
    }

    if (empty($password2)) {
        $msg = "You must re-enter a password!";
        main_form();
        exit;
    }

    if ($password1 != $password2) {
        $msg = "Your passwords do not match!";
        main_form();
        exit;
    } else {
        $password = hash('sha512', $password1);
    }

    // Attempt select query execution
    $sql = "UPDATE $employees_tablename SET password = '$password', resetpwd = '0' WHERE userid = '$uid'";
    if ($mysqli->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>SUCCESS!</strong> Record updated successfully!
        </div>";
        //exit;
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
        </div>";
    }
    // End attempt select query execution

    header('Location: index.php');
}


//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch ($action) {
    case "Update":
        update_form();
        break;
    default:
        main_form();
        break;
}

?>