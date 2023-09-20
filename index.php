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
	global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body, $fullname;
    global $system_tablename, $sysid, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $cuurentnotes;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;
    global $menuid, $goal, $current, $pct, $userid;
    information_modal();

    // Attempt select query execution
    if ($result = $mysqli->query("SELECT releasenotes, cuurentnotes FROM $system_tablename")) {
    // if ($result = $mysqli->query("SELECT goalamt, curgoal FROM $system_tablename")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $releasenotes = $row['releasenotes'];
            $cuurentnotes = $row['cuurentnotes'];
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

    $menuid = 1;
    if(!empty($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
    }

    testadmin();

    // $width = round(($c / $g) * 100, 2, PHP_ROUND_HALF_EVEN);
    $width = number_format(($current / $goal) * 100, 2, '.', '');
    ?>
    <div class="height-100">
        <!-- <h4>Dashboard</h4> -->
        <br>
        <div id="boxed">
            <div class="row ml-12 mr-12 clearfix">
                <div class="col" align="center">
                    <?php
                    if(empty($_SESSION['userid'])){
                        ?>
                        <font size="+3"><strong>Welcome to the Dashboard, Visitor!</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                    }else{
                        ?>
                        <font size="+3"><strong>Welcome to your Dashboard, <?php echo $userfname; ?>!</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php
                    }
                    
                    date_default_timezone_set('America/Phoenix');
                    ?>
                    <br><br>
                    <button type="button" class="btn btn-warning" id="opener">Current News</button>
                    <br><br>
                    <button type="button" id="btnrounded" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#information_modal">Release Notes as of <?php echo date('m/d/Y'); ?></button>
                    <br><br>
                </div>
            </div>
        </div>
        
        <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
    </div>


    <?php
    $news = $cuurentnotes;
    ?>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin-top: 80px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Latest News</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo $news; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Video -->
    <div class="modal fade" id="videoOne" tabindex="-1" role="dialog" aria-labelledby="videoOneLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin-top: 80px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Welcome Video</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/4liWMlkpupg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- How to Use This Site Video -->
    <div class="modal fade" id="videoTwo" tabindex="-1" role="dialog" aria-labelledby="videoTwoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin-top: 80px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">How to Use This Site</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/nTL5gtP0nyg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- How to Enroll Video -->
    <div class="modal fade" id="videoThree" tabindex="-1" role="dialog" aria-labelledby="videoThreeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="margin-top: 80px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">How to Enroll</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/D7Ef4kM5BLg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="dialog" class="selector" title="Latest News">
        <?php echo $news; ?>
    </div>

    <?php
    include "tmp/footer.php";
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
	default:
		main_form();
	break;
}
?>