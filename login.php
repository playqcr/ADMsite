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
                <h4>Welcome</h4>
                Students, please login.
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="mb-3" style="padding-top: 50px;">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input name="useremail" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                        <input name="userpassword" type="password" class="form-control" id="inputPassword">
                    </div>
                    <br>
                    <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Submit">Login</button>
                    <br><br>
                    Want to become a student? Simply click the "Register a New Account" button below to begin the registration process.
                    <div class='row'>
                        <div class='col-6' align="left" style="padding-top: 20px;">
                            <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Register">Register a New Account</button>
                        </div>
                        <div class='col-6' align="left" style="padding-top: 20px;">
                            <button type="submit" name="action" class="btn btn-danger btn-small btn-block" value="Forgot">I Forgot My Password</button>
                        </div>
                    </div>
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
    $userpassword1 = filter_var($_POST['userpassword'], FILTER_SANITIZE_STRING);
    $remember = $_POST['remember'];
    $pwd = hash('sha512', $userpassword1);

    // echo "useremail1: ".$useremail1."<br>";
    // echo "pwd: ".$pwd."<br>";
    // exit;

    // Attempt select query execution
    if ($result = $mysqli->query("SELECT * FROM $users_tablename WHERE useremail = '$useremail1' AND userpassword = '$pwd'")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $userid = $row['userid'];
            $useremail2 = $row['useremail'];
            $userpassword2 = $row['userpassword'];
            $isadmin = $row['isadmin'];
            $role = $row['role'];
            // Free result set
            mysqli_free_result($result);
        } else{
            $msg = "<font color='#FF0000'><strong>Account not found!</strong></font>";
            main_form();
            exit;
        }
    } else{
        echo "ERROR: Was not able to execute Query on line #152. " . mysqli_error($mysqli);
    }
    // End attempt select query execution

    $pattern_ue = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/";
    if (!preg_match($pattern_ue, $useremail1)) {
        $msg = "Invalid email format";
        main_form();
        exit;
    }

    $pattern_up = "/^.*(?=.{8,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
    if (!preg_match($pattern_up, $userpassword1)) {
        $msg = "Password must be at least 8 characters long, 1 upper case, 1 lower case letter and 1 number.";
        main_form();
        exit;
    }


    if (empty($useremail1)) {
        $msg = "You Must Enter An Email Address";
        main_form();
        exit;
    }

    if (empty($userpassword1)) {
        $msg = "You Must Enter A Password";
        main_form();
        exit;
    }
    
    // Attempt select query execution
    if ($result = $mysqli->query("SELECT * FROM $users_tablename WHERE useremail = '$useremail1' AND userpassword = '$pwd'")) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $uid = $row['userid'];
            $useremail = $row['useremail'];
            $userpwd = $row['userpassword'];
            $isadmin = $row['isadmin'];
            $role = $row['role'];
            mysqli_free_result($result);
        } else {
            $msg = "<font color='#FF0000'><strong>Account Does Not Exsist!</strong></font>";
            main_form();
            exit;
        }
    } else {
        $msg = "ERROR: Was not able to execute Query on line #228. " . mysqli_error($mysqli);
        main_form();
        exit;
    }
    // End attempt select query execution

    // echo "useremail1: ".$useremail1."<br>";
    // echo "useremail: ".$useremail."<br>";
    // echo "pwd: ".$pwd."<br>";
    // echo "userpwd: ".$userpwd."<br>";
    // exit;

    if ($useremail1 != $useremail) {
        $msg = "Email Address Is Not In Our Records!";
        main_form();
        exit;
    }

    if ($userpwd != $pwd) {
        $msg = "Password Does Not Match Our Records";
        main_form();
        exit;
    }

    $_SESSION['userid'] = $userid;
    $_SESSION['isadmin'] = $isadmin;
    $_SESSION['role'] = $role;

    // SET COOKIE IF REMEMBER ME IS CHECKED
    if($remember){
        $cookie_name = "ihnuid";
        $cookie_value = $userid;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 14), "/"); // 86400 = 1 day | 3600 = 1 hour
    }

    header('Location: index.php');
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
    case "Register":
        header('Location: register.php');
    break;
    case "Forgot":
        header('Location: lostpwd.php');
    break;
	default:
		main_form();
	break;
}

?>