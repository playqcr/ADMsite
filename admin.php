<?php
/****************************************************
****   Advanced Data Manager
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
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

function main_form() {
	global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $cuurentnotes, $goalamt, $curgoal;
    global $menuid, $goal, $current, $pct;
    global $progenroll_tablename, $progenrollid, $enrprogid , $enruserid, $enrolldate;
    global $programs_tablename, $progid, $progname , $enabled, $cost, $charge, $accordian_header, $progtype;
    global $selected_progid, $selected_progname , $selected_enabled, $selected_cost, $selected_charge, $selected_accordian_header, $selected_progtype;
    global $volunteers_tablename, $vid, $vfname , $vmname, $vlname, $vemail, $vphone, $vaddress, $vcity, $vstate, $vzip;
    global $volunteerpos_tablename, $vposid, $vtitle, $vdescription, $vneeded;

    // *******************************************************************************************
    // ********   FINANCIAL GOAL CALCULATIONS
    // *******************************************************************************************
    // Attempt select query execution
    if ($result = $mysqli->query("SELECT releasenotes, cuurentnotes, goalamt, curgoal FROM $system_tablename")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $releasenotes = $row['releasenotes'];
            $cuurentnotes = $row['cuurentnotes'];
            $goalamt = $row['goalamt'];
            $curgoal = $row['curgoal'];
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

    $menuid = 0;
    testadmin();

    $g = $goalamt;
    $c = $curgoal;

    $gresult = str_replace('$', '', $g);
    $goal = str_replace(',', '', $gresult);
    
    $cresult = str_replace('$', '', $c);
    $current = str_replace(',', '', $cresult);

    $pct = ($current / $goal) * 100;

    // *******************************************************************************************
    // ********   VOLUNTEER CALCULATIONS
    // *******************************************************************************************
    // Attempt select query execution
    $totalpos = 0;
    if ($resultx = $mysqli->query("SELECT vneeded FROM $volunteerpos_tablename")) {
        if(mysqli_num_rows($resultx) > 0){
            while($rowx = mysqli_fetch_array($resultx)){
                $vneeded = $rowx['vneeded'];
                $totalpos += $vneeded;
            }
            // Free result set
            mysqli_free_result($resultx);
        } else{
            $msg = "<font color='#FF0000'><strong>Account not found!</strong></font>";
            main_form();
            exit;
        }
    } else{
        echo "ERROR: Was not able to execute Query on line #55. " . mysqli_error($mysqli);
    }
    // End attempt select query execution

    // Attempt select query execution
    if ($result = $mysqli->query("SELECT COUNT(*) AS 'totalv' FROM $volunteers_tablename")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $totalv = $row[0];
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

    // $vpercent = ($vneeded / $totalv) * 100;
    $vpercent = ($totalv / $totalpos) * 100;

    // *******************************************************************************************
    // ********   END VOLUNTEER CALCULATIONS
    // *******************************************************************************************
    ?>
    <div class="height-100">
        <?php echo $msg; ?>
        <br>
        <div class="d-flex">
            <div id="boxed">
                <div class="card-group">

                    <div class="card card_margins text-bg-light mb-3">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Go somewhere">Go somewhere</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card card_margins text-bg-light mb-3">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Go somewhere">Go somewhere</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card card_margins text-bg-light mb-3">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Go somewhere">Go somewhere</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card card_margins text-bg-light mb-3">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Go somewhere">Go somewhere</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="card-group">
            <!--********************************************************************************************
            *******  RELEASE NOTES
            *********************************************************************************************-->
            <div class="card">
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="card-body release-body-height">
                        <h4 class="card-title">Add Notes</h4>
                        <textarea name="relnotes" id="relnotes" style="width: 100%; height: 400px;" placeholder="<?php echo $releasenotes; ?>"></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button name="action" type="submit" value="addnotes" class="btn btn-success btn-block">Add Notes</button>
                        </div>
                    </div>
                </form>
            </div>

            <!--********************************************************************************************
            *******  CURRENT NOTES
            *********************************************************************************************-->
            <div class="card">
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="card-body release-body-height">
                        <h4 class="card-title">View Notes</h4>
                        <textarea name="currentnotes" id="curnotes" style="width: 100%; height: 400px;" placeholder="<?php echo $cuurentnotes; ?>"></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button name="action" type="submit" value="updatenotes" class="btn btn-success btn-block">Update Notes</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        
        <div id="boxed" style="margin-bottom: 50px; margin-top: 50px;">&nbsp;</div>
    </div>

    <script>
        tinymce.init({
            selector: '#relnotes',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo| bold italic underline strikethrough | bullist numlist indent outdent  | link image media table | align lineheight| emoticons charmap | removeformat | blocks fontfamily fontsize ',
            width: '100%',
            height: 420,
            readonly: 0
        });
    </script>

    <script>
        tinymce.init({
            selector: '#curnotes',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo| bold italic underline strikethrough | bullist numlist indent outdent  | link image media table | align lineheight| emoticons charmap | removeformat | blocks fontfamily fontsize ',
            width: '100%',
            height: 420,
            readonly: 0
        });
    </script>

    <?php
    include "tmp/footer.php";
}

//*******************************************************
//*******************  SAVE NOTES  **********************
//*******************************************************
function save_notes(){
    global $PHP_SELF, $mysqli, $msg;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $cuurentnotes, $goalamt, $curgoal;

    $newrelnotes = filter_var($_POST['relnotes'], FILTER_SANITIZE_STRING);
    $newreleasenotes = addslashes($newrelnotes);

    if (empty($newreleasenotes) || $newreleasenotes == null) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating Developer Note record: Empty release notes field.
        </div>";
        main_form();
    }

    // echo "newrelnotes: ".$newrelnotes."<br>";
    // echo "newdelenotes: ".$newreleasenotes."<br>";
    // exit;

    date_default_timezone_set('America/Phoenix');
    $newdate = date("m/d/Y");

    // Attempt select query execution
    $sql = "SELECT * FROM $system_tablename";
    if ($result = mysqli_query($mysqli, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $sysadminver = $row['sysadminver'];
            $verdate = $row['verdate'];
            $releasenotes = $row['releasenotes'];
            // Free result set
            mysqli_free_result($result);
        } else {
            $_SESSION['msg'] = "<font color='#FF0000'><strong>Account Does Not Exsist!</strong></font>";
            main_form();
            exit;
        }
    } else {
        echo "ERROR: Was not able to execute Query on line #228. " . mysqli_error($mysqli);
    }
    // End attempt select query execution

    if (empty($newreleasenotes) || $newreleasenotes == null) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating User record: Empty release notes field.
        </div>";
        main_form();
    }

    $relnotes = $newreleasenotes . "<br><br><strong>" . $newdate . "</strong><hr>" . $releasenotes;

    // Attempt select query execution
    $sql = "UPDATE $system_tablename SET releasenotes = '$relnotes'";
    if ($mysqli->query($sql) === TRUE) {
        $msg = "<div class='alert alert-success' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>SUCCESS!</strong> User Record successfully!
        </div>";
        //exit;
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating User record: " . $mysqli->error . "
        </div>";
    }
    // End attempt select query execution


    // Attempt select query execution
    $sql = "UPDATE $system_tablename SET  sysadminver = '$sysadminver', verdate = '$newdate'";
    if ($mysqli->query($sql) === TRUE) {
        //header("Location:admin.php");
        $msg = "<div class='alert alert-success' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>SUCCESS!</strong> Release notes updated!
        </div>";
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating release notes: " . $mysqli->error . "
        </div>";
    }
    // End attempt select query execution

    main_form();
}

//*******************************************************
//*******************  SAVE NOTES  **********************
//*******************************************************
function save_current_notes(){
    global $PHP_SELF, $mysqli, $msg, $oldreleasenotes;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $cuurentnotes, $goalamt, $curgoal;

    date_default_timezone_set('America/Phoenix');

    $newcurnotes = filter_var($_POST['currentnotes'], FILTER_SANITIZE_STRING);
    $newcurrentnotes = addslashes($newcurnotes);

    if (empty($newcurrentnotes) || $newcurrentnotes == null) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating current Note record: Empty current notes field.
        </div>";
        main_form();
    }

    date_default_timezone_set('America/Phoenix');
    $newdate = date("m/d/Y");

    $curnotes = $newcurrentnotes . "<br><br><strong>" . $newdate . "</strong>";

    // Attempt select query execution
    $sqlb = "UPDATE $system_tablename SET cuurentnotes = '$curnotes'";
    if ($mysqli->query($sqlb) === TRUE) {
        $msg = "<div class='alert alert-success' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>SUCCESS!</strong> Notes updated successfully!
        </div>";
        //exit;
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating notes: " . $mysqli->error . "
        </div>";
    }
    // End attempt select query execution

    main_form();
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
    case "Select Program":
        select_program();
    break;
    case "Save Goals":
        save_goals();
    break;
    case "updatenotes":
        save_current_notes();
    break;
    case "addnotes":
        save_notes();
        break;
    case "Register":
        header('Location: register.php');
    break;
    default:
        main_form();
    break;
}

?>