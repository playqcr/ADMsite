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

// Grab action
if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = '';
}
//*******************************************************
//*******************  MAIN FORM  ***********************
//*******************************************************

function main_form(){
    global $PHP_SELF, $mysqli, $msg;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

    include "tmp/loginhead.php";
?>
    <script language="JavaScript">
        function function1() {
            document.all.Uname.focus();
        }
    </script>
    
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
                    <?php
                    echo $msg."<br>";
                    ?>
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
                        </form>
                    </center>
                </div>
            </div>
        </div>

        <?php include "tmp/footer.php"; ?>
    </body>

    </html>
    <?php
}

//*******************************************************
//*******************  CHECK LOGIN  *********************
//*******************************************************

function check_login(){
    global $PHP_SELF, $mysqli, $msg;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Attempt select query execution
    $sql = "SELECT * FROM $users_tablename WHERE useremail = '$email'";
    if($result = mysqli_query($mysqli, $sql)){
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
            exit;
        }
    }else{
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
        </div>";
        main_form();
        exit;
    }
    // End attempt select query execution

    // echo "email: ".$email."<br>";
    // echo "uid: ".$uid."<br>";
    // echo "pwd: ".$pwd."<br>";
    // echo "userpwd: ".$userpwd."<br>";
    // exit;

    $_SESSION['uid'] = $uid;
    
    ?>
    <script type="text/javascript">
    <!--
    // window.top.location.href = "changepwd.php?uid=".$uid;
    window.top.location.href = "changepwd.php?uid=<?php echo $uid; ?>";
    -->
    </script>
    <?php
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch ($action) {
    case "Submit":
        check_login();
        break;
    default:
        main_form();
        break;
}

?>