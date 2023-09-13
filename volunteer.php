<?php
/****************************************************
****   IHN Bible College
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
	global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body, $fullname;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $volunteers_tablename, $vid, $vfname , $vmname, $vlname, $vemail, $vphone, $vaddress, $vcity, $vstate, $vzip;
    global $volunteerpos_tablename, $vposid, $vtitle, $vdescription, $vneeded;
    global $menuid, $goal, $current, $pct, $userid;
    
    dbconnect();
    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }

    information_modal();
    $menuid = 3;
    
    if(!empty($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
    }

    testadmin();
    ?>
    <div class="height-100">
        <br>
        <div id="boxed">
            <p class="text-center"><span style="font-size: 32px;">Volunteers Needed</span></p>
                    
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Position</th>
                            <th scope="col">Description</th>
                            <th scope="col">Needed</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="<?php echo $PHP_SELF; ?>" method="post">
                                <?php
                                $totalpos = 0;
                                // Attempt select query execution
                                if ($result = $mysqli->query("SELECT * FROM $volunteerpos_tablename")) {
                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_array($result)){
                                            $vposid = $row['vposid'];
                                            $vtitle = $row['vtitle'];
                                            $vdescription = $row['vdescription'];
                                            $vneeded = $row['vneeded'];
                                            if($vneeded > 0){
                                                ?>
                                                <tr>
                                                    <td><?php echo "<strong>".$vtitle."</strong>"; ?></td>
                                                    <td><?php echo $vdescription; ?></td>
                                                    <td><?php echo $vneeded; ?></td>
                                                    <td><button class="btn btn-primary btn-sm" type="submit" name="action" value="apply">Apply For This Position</button></td>
                                                </tr>
                                                <?php
                                            }
                                            $totalpos += $vneeded;
                                        }
                                        // Free result set
                                        mysqli_free_result($result);
                                    } else{
                                        $msg = "<font color='#FF0000'><strong>No records found!</strong></font>";
                                        main_form();
                                        exit;
                                    }
                                } else{
                                    echo "ERROR: Was not able to execute Query on line #38. " . mysqli_error($mysqli);
                                }
                                // End attempt select query execution
                                ?>
                            </form>
                            <tr>
                                <td></td>
                                <td><?php echo "Total Positions Needed: ".$totalpos; ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>

        <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
    </div>
    <?php
    include "tmp/footer.php";
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
function goto_course(){
    $coursename = $_GET['coursename'];

    echo "coursename: ".$coursename."<br>";
    exit;
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
    case "completed":
        goto_course();
    break;
	default:
		main_form();
	break;
}
?>

