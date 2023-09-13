<?php
/****************************************************
****   IHN Bible College
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/

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
    global $$volunteers_tablename, $vid, $vfname , $vmname, $vlname, $vemail, $vphone, $vaddress, $vcity, $vstate, $vzip;
    global $$volunteerpos_tablename, $vposid, $vtitle , $vdescription, $vneeded;
    global $menuid, $goal, $current, $pct, $userid;
    include "tmp/header.php";
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
        <p class="text-center"><span style="font-size: 32px;">Join Us In Prayer</span></p>
                
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <p>HOLD</p>
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