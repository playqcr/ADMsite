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
                <h4>Update Your Password.</h4>
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Enter New Password</label>
                        <input name="password1" type="password" class="form-control" id="inputPassword">
                    </div>
                    <div class="mb-3">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Re-enter New Password</label>
                        <input name="password2" type="password" class="form-control" id="inputPassword">
                    </div>
                    <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Update">Update</button>
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
//*******************  UPDATE ***************************
//*******************************************************
function update_form() {
	global $PHP_SELF, $mysqli, $msg;
	global $users_tablename, $userid, $useremail, $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $isgm, $isinstructor;

	$uid = $_GET["uid"];
	$password1 = $_POST['password1'];
    $userpassword1 = filter_var($_POST['password1'], FILTER_SANITIZE_STRING);
	$password2 = $_POST['password2'];
    $userpassword2 = filter_var($_POST['password2'], FILTER_SANITIZE_STRING);
    $pwd = hash('sha512', $userpassword1);

    $pattern_up = "/^.*(?=.{8,56})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/";
    if (!preg_match($pattern_up, $userpassword1)) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Password must be at least 8 characters long, 1 upper case, 1 lower case letter and 1 number.
        </div>";
        main_form();
        exit;
    }

	if(empty($password1)) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Enter A Valid Password!
        </div>";
        main_form();
        exit;
	}

	if(empty($password2)) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Re-Enter A Valid Password!
        </div>";
        main_form();
        exit;
	}

	if($password1 != $password2) {
		echo"Your passwords do not match!";
		$msg = "<div class='alert alert-danger' role='alert'>
		<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
		<strong>ERROR!</strong> Passwords Do Not Match!
		</div>";
		main_form();
		exit;
	}
    $pwd = hash('sha512', $userpassword1);

	$sql = $mysqli->query("UPDATE $users_tablename SET userpassword = '$pwd' WHERE userid = '$uid'");

	header('Location: login.php');
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
   case "Update":
      update_form();
   break;
   default:
	  main_form();
   break;
}
?>

