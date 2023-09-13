<?php


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
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $menuid, $goal, $current, $pct;
    global $progenroll_tablename, $progenrollid, $enrprogid , $enruserid, $enrolldate;
    global $programs_tablename, $progid, $progname , $enabled, $cost, $charge, $accordian_header, $progtype;
    global $selected_progid, $selected_progname , $selected_enabled, $selected_cost, $selected_charge, $selected_accordian_header, $selected_progtype;
    global $$volunteers_tablename, $vid, $vfname , $vmname, $vlname, $vemail, $vphone, $vaddress, $vcity, $vstate, $vzip;
    global $$volunteerpos_tablename, $vposid, $vtitle, $vdescription, $vneeded;

    include "tmp/header.php";
    dbconnect();
    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }


    // *******************************************************************************************
    // ********   FINANCIAL GOAL CALCULATIONS
    // *******************************************************************************************
    // Attempt select query execution
    if ($result = $mysqli->query("SELECT releasenotes, goalamt, curgoal FROM $system_tablename")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $releasenotes = $row['releasenotes'];
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
        <!-- <h4>Dashboard</h4> -->
        <br>
        <div class="d-flex">
            <div id="boxed">
                <div class="card-group">
                    <div class="card card_margins text-bg-light mb-3">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Financial Goal Settings</h4>
                                <div class="mb-3 row">
                                    <label for="totalGoalAmt" class="col-sm-6 col-form-label">Goal Amount</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="goal" class="form-control" id="totalGoalAmt" value="<?php echo $g; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="amtCollected" class="col-sm-6 col-form-label">Amount Collected</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="current" class="form-control" id="amtCollected" value="<?php echo $c; ?>">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="pctCollected" class="col-sm-6 col-form-label">Percentage Collected</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="pct" readonly class="form-control-plaintext" id="pctCollected" value="<?php echo $pct."%"; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Save Goals">Save Goals</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card card_margins text-bg-light mb-3">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body card-body-height">
                                <h4 class="card-title">Volunteers</h4>
                                <div class="mb-3 row">
                                    <label for="totalGoalAmt" class="col-sm-6 col-form-label">Positions Available</label>
                                    <div class="col-sm-6">
                                        <?php echo $totalpos; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="amtCollected" class="col-sm-6 col-form-label">Positions Filled</label>
                                    <div class="col-sm-6">
                                        <?php echo $totalv; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="pctCollected" class="col-sm-6 col-form-label">Percentage Filled</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="pct" readonly class="form-control-plaintext" id="pctCollected" value="<?php echo $vpercent."%"; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Go somewhere">Manage Volunteers</button>
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
        
        <!-- <br>
        <div class="d-flex">
            <div id="boxed">
                <div class="card-group">

                    <div class="card card_margins text-bg-light mb-3" style="width: 100%;">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body release-body-height">
                                <h4 class="card-title">Add Notes</h4>
                                <textarea name="relnotes" id="relnotes" style="width: 100%; height: 400px;"></textarea>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                    <button name="action" type="submit" value="addnotes" class="btn btn-success btn-block">Add Notes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card card_margins text-bg-light mb-3" style="width: 100%;">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="card-body release-body-height">
                                <h4 class="card-title">View Notes</h4>
                                <textarea name="allnotes" id="allnotes" style="width: 100%; height: 400px;"><?php echo $releasenotes; ?></textarea>
                            </div>
                            <div class="card-footer">
                                <div class="d-grid gap-2">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div> -->

        <br>
        <div class="card-group">

            <div class="card">
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="card-body release-body-height">
                        <h4 class="card-title">Add Notes</h4>
                        <textarea name="relnotes" id="relnotes" style="width: 100%; height: 400px;"></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <button name="action" type="submit" value="addnotes" class="btn btn-success btn-block">Add Notes</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="card-body release-body-height">
                        <h4 class="card-title">View Notes</h4>
                        <textarea name="allnotes" id="allnotes" style="width: 100%; height: 400px;"><?php echo $releasenotes; ?></textarea>
                    </div>
                    <div class="card-footer">
                        <div class="d-grid gap-2">
                            <!-- <button name="action" type="submit" value="addnotes" class="btn btn-success btn-block">Add Notes</button> -->
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="card">
            <div class="card-header">
                Programs
            </div>
            <div class="card-body">
                <form action="<?php echo $PHP_SELF ?>" method="post">
                    <div class="row">
                        <div class="col-3">
                            <select name="progname" id="">
                                <option value="">SELECT PROGRAM</option>
                                <?php
                                global $progenroll_tablename, $progenrollid, $enrprogid , $enruserid, $enrolldate;
                                global $programs_tablename, $progid, $progname , $enabled, $cost, $charge, $accordian_header, $progtype;
                                // Attempt select query execution
                                if ($result = $mysqli->query("SELECT * FROM $programs_tablename ORDER BY progname ASC")) {
                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_array($result)){
                                            $progid = $row['progid'];
                                            $progname = $row['progname'];
                                            $enabled = $row['enabled'];
                                            $cost = $row['cost'];
                                            $charge = $row['charge'];
                                            $accordian_header = $row['accordian_header'];
                                            $progtype = $row['progtype'];
                                            ?>
                                            <div class="card-group">
                                                <option value="<?php echo $progname; ?>"><?php echo $progname; ?></option>
                                            </div>
                                            <?php
                                        }
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
                                global $programs_tablename, $progid, $progname , $enabled, $cost, $charge, $accordian_header, $progtype;
                                global $selected_progid, $selected_progname , $selected_enabled, $selected_cost, $selected_charge, $selected_accordian_header, $selected_progtype;
                                ?>
                            </select>
                            <div class="d-grid gap-2" style="margin-top: 10px;">
                                <!-- <input type="hidden" name="progname" value="<?php echo $progname; ?>"> -->
                                <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Select Program">Select Program</button>
                            </div>
                            <div class="d-grid gap-2" style="margin-top: 10px;">
                                <button type="submit" name="action" class="btn btn-info btn-small btn-block" value="Add Program">Add Program</button>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3 row">
                                <label for="staticPID" class="col-sm-5 col-form-label">Program ID:</label>
                                <div class="col-sm-7">
                                    <input type="text" readonly class="form-control-plaintext" name="selected_progid" value="<?php echo $selected_progid; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-5 col-form-label">Program Name:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="selected_progname" value="<?php echo $selected_progname; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Enabled:</label>
                                <div class="col-sm-7">
                                    <input type="text"  class="form-control" name="selected_enabled" value="<?php echo $selected_enabled; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-5 col-form-label">Cost:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="inputPassword" name="selected_cost" value="<?php echo $selected_cost; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-5 col-form-label">Charge:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="inputPassword" name="selected_charge" value="<?php echo $selected_charge; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-5 col-form-label">Accordian Header:</label>
                                <div class="col-sm-7">
                                    <input type="text"  class="form-control" name="selected_accordian_header" value="<?php echo $selected_accordian_header; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-5 col-form-label">Program Type:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="inputPassword" name="selected_progtype" value="<?php echo $selected_progtype; ?>">
                                </div>
                            </div>
                            <div class="mb-3 d-grid gap-2">
                                <!-- <form action="<?php echo $PHP_SELF ?>" method="post"> -->
                                    <button type="submit" name="action" class="btn btn-success btn-small btn-block" value="Add Program">Submit Program</button>
                                <!-- </form> -->
                            </div>
                        </div>
                        <div class="col-3"></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                My Courses
            </div>
            <div class="card-body">
                <!-- <h5 class="card-title">Special title treatment</h5> -->
                <p class="card-text">BIB101 - Old Testament Survey</p>
                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
            </div>
        </div>
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
            selector: '#allnotes',
            // plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            // toolbar: 'undo redo| bold italic underline strikethrough | bullist numlist indent outdent  | link image media table | align lineheight| emoticons charmap | removeformat | blocks fontfamily fontsize ',
            width: '100%',
            height: 420,
            readonly: 1
        });
    </script>

    <?php
    include "tmp/footer.php";
}

//*******************************************************
//*******************  CHECK LOGIN  *********************
//*******************************************************

function save_goals() {
    global $PHP_SELF, $mysqli, $sql, $msg, $pwd, $useremail1, $userpassword1, $useremail2, $userpassword2, $result;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $menuid, $goal, $current, $intgoal, $gfine, $gresult, $intcurrent, $cfine, $cresult;
    include "tmp/globals.php";
    dbconnect();
    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $gresult = str_replace('$', '', $_POST['goal']);
    $gfine = str_replace(',', '', $gresult);
    $g = filter_var($gfine, FILTER_SANITIZE_STRING);

    $cresult = str_replace('$', '', $_POST['current']);
    $cfine = str_replace(',', '', $cresult);
    $c = filter_var($cfine, FILTER_SANITIZE_STRING);
    
    $goal = "$".number_format($g);
    $current = "$".number_format($c);

    if (empty($goal)) {
        $msg = "You Must Enter A Goal";
        main_form();
        exit;
    }

    if (empty($current)) {
        $msg = "You Must Enter A Current Amount";
        main_form();
        exit;
    }

    $sql = "UPDATE $system_tablename SET goalamt = '$goal', curgoal = '$current'";
    if (mysqli_query($mysqli, $sql)) {
        $msg = "<div class='alert alert-success' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>SUCCESS!</strong> Record updated successfully!
        </div>";
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating record: " . mysqli_error($mysqli) . "
        </div>";
    }

    $mysqli->close();

    echo "Line #492<br>";
    header('Location: admin.php');
}

//*******************************************************
//*******************  CHECK LOGIN  *********************
//*******************************************************

function select_program() {
    global $PHP_SELF, $mysqli, $sql, $msg, $pwd, $useremail1, $userpassword1, $useremail2, $userpassword2, $result;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $menuid, $goal, $current;
    global $selected_progid, $selected_progname , $selected_enabled, $selected_cost, $selected_charge, $selected_accordian_header, $selected_progtype;
    
    $progname = filter_var($_POST['progname'], FILTER_SANITIZE_STRING);
    $selected_progid = filter_var($_POST['selected_progid'], FILTER_SANITIZE_STRING);
    $selected_progname = filter_var($_POST['selected_progname'], FILTER_SANITIZE_STRING);
    $selected_enabled = filter_var($_POST['selected_enabled'], FILTER_SANITIZE_STRING);
    $selected_cost = filter_var($_POST['selected_cost'], FILTER_SANITIZE_STRING);
    $selected_charge = filter_var($_POST['selected_charge'], FILTER_SANITIZE_STRING);
    $selected_accordian_header = filter_var($_POST['selected_accordian_header'], FILTER_SANITIZE_STRING);
    $selected_progtype = filter_var($_POST['selected_progtype'], FILTER_SANITIZE_STRING);

    $selected_progname = $progname;

    // echo "progname: ".$progname."<br>";
    // echo "selected_progid: ".$selected_progid."<br>";
    // echo "selected_progname: ".$selected_progname."<br>";
    // echo "selected_enabled: ".$selected_enabled."<br>";
    // echo "selected_cost: ".$selected_cost."<br>";
    // echo "selected_charge: ".$selected_charge."<br>";
    // echo "selected_accordian_header: ".$selected_accordian_header."<br>";
    // echo "selected_progtype: ".$selected_progtype."<br>";
    // exit;

    // if (empty($goal)) {
    //     $msg = "You Must Enter A Goal";
    //     main_form();
    //     exit;
    // }

    // if (empty($current)) {
    //     $msg = "You Must Enter A Current Amount";
    //     main_form();
    //     exit;
    // }

    // Attempt select query execution
    // $sql = "UPDATE $system_tablename SET goalamt = '$goal', curgoal = '$current'";
    // if ($mysqli->query($sql) === TRUE) {
    //     $msg = "<div class='alert alert-success' role='alert'>
    //     <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    //     <strong>SUCCESS!</strong> Record updated successfully!
    //     </div>";
    //     //exit;
    // } else {
    //     $msg = "<div class='alert alert-danger' role='alert'>
    //     <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    //     <strong>ERROR!</strong> Error updating record: " . $mysqli->error . "
    //     </div>";
    // }
    // End attempt select query execution

    main_form();
}

//*******************************************************
//*******************  SAVE NOTES  **********************
//*******************************************************
function save_notes(){
    global $PHP_SELF, $mysqli, $msg;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;

    // $newreleasenotes = filter_var(addslashes($_POST['relnotes']), FILTER_SANITIZE_STRING);
    $newreleasenotes = addslashes($_POST['relnotes']);

    if (empty($newdelenotes) || $newdelenotes == null) {
        $msg = "<div class='alert alert-danger' role='alert'>
        <button type='button' class='close' data-bs-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>ERROR!</strong> Error updating Developer Note record: Empty release notes field.
        </div>";
        main_form();
    }

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
    } else {
        //
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