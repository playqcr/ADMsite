<?php
/****************************************************
****   IHN Bible College
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
include 'includes/globals.php';
session_start();
db_connect();

if($mysqli->connect_error) {
    echo "Failed to connect to server: (".$mysqli->connect_error.") ".$mysqli->connect_error;
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

function main_form() {
    global $PHP_SELF, $mysqli, $msg, $nextpage, $prevpage, $perpage, $cookie_name;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages;
    global $system_tablename;

    include "templates/include.tpl";
    include "templates/style.tpl";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style>
</style>
<body>  
<section id="layout">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4" align="center"></div>
            <div id="contentht" class="col-sm-4" align="center">
                <div class="centered" style="top: 350px;">
					<br /><br /><br /><br />
					<img src="img\header.png" width="50%">
					<br><?php echo $msg; ?><br /><br />
                    <font size="+4"><strong>Registration Form</strong></font><br /><br />
                    <form action="<?php echo $PHP_SELF ?>" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="lname" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd1" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd2" placeholder="Re-enter Password">
                        </div>
                        <center>
							<button type="submit" name="action" class="btn btn-success btn-block" value="Submit"><font size="+2">Submit</font></button>
							<br>
						</center>
                        <br /><br /><a href="login.php"><font size="+2">Return To Login</font></a><br /><br />
					</form>

                </div>
            </div>
            <div class="col-sm-4" align="center"></div>
        </div>
    </div>
</section>
<?php
include "templates/footer.tpl";

?>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>
<?php
}


//*******************************************************
//*********************  ADD ITEM  **********************
//*******************************************************
function add_item(){
    global $PHP_SELF, $mysqli, $msg, $nextpage, $prevpage, $perpage, $cookie_name;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages;
    global $system_tablename;

	$email = addslashes($_POST['email']);
	$fname = addslashes($_POST['fname']);
	$mname = addslashes($_POST['mname']);
	$lname = addslashes($_POST['lname']);
	$pwd1 = addslashes($_POST['pwd1']);
	$pwd2 = addslashes($_POST['pwd2']);

    $hash = md5($pwd1);
    $userpassword = $hash;

	$_SESSION['fname'] = $fname;
	$_SESSION['lname'] = $lname;
	$_SESSION['email'] = $email;

    // Attempt select query execution
    $sql = "SELECT * FROM $users_tablename WHERE useremail = '$email'";
    if($result = mysqli_query($mysqli, $sql)){
        if(mysqli_num_rows($result) > 0){
            $msg = "<br><div class='alert alert-danger' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            <strong>ERROR!</strong> That email address is already in use!<br>
            </div>";
            main_form();
            exit;
            // Free result set
            mysqli_free_result($result);
        }
    }
    // End attempt select query execution

	if(empty($email)) {
        $msg = "<br><div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Enter A Valid Email Address!<br>
        </div>";
		main_form();
		exit;
	}
	
	if(empty($fname)) {
        $msg = "<br><div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Enter A First Name!<br>
        </div>";
        main_form();
		exit;
	}
	
	if(empty($lname)) {
        $msg = "<br><div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> You Must Enter A Last Name!<br>
        </div>";
		main_form();
		exit;
	}

    // Attempt select query execution
    $sql = "INSERT INTO $users_tablename (userid, useremail, userpassword, isadmin, userfname, usermname, userlname, useraddress, usercity, userstate, userzip, usercountry, userphone, suspended, highgrade, dob, usersaved, baptized, baptismdate, profile, imagepath, corecompletedate, branchid, role, messages) VALUES(NULL, '$email', '$hash', '0', '$fname', '$mname', '$lname', '', '', '', '', '', '', '0', '', '', '0', '0', '', '', '', '', '', '', '1')";
    if($result = mysqli_query($mysqli, $sql)){
        // TODO
    } else{
        echo "ERROR: Was not able to execute Query on line #272. " . mysqli_error($mysqli);
    }
    // End attempt select query execution


	//***************************************************************
	$to = "ihnbible@gmail.com";
	$subject = "IHNBC Registration";
	$message = "<html><head><title></title></head><body><p><b>Someone has Registered for a new account. Here is the information entered:<br><br>User Email = ".$email."<br>First Name = ".$fname."<br>userlname = ".$lname."<br></body></html>";
	$from = "noreply@ihnbible.org";
	$headers = "From:".$from . "\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	if (mail($to, $subject, $message, $headers)) {
        echo("<p>Message successfully sent!</p>");
    } else {
        echo("<p>Message delivery failed...</p>");
    }
	echo "Mail Sent.";
	
	//***************************************************************
	
	session_destroy();
	session_start();
    header('Location: login.php');
}


//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
	case "Submit":
		add_item();
	break;
	default:
		main_form();
	break;
}

?>