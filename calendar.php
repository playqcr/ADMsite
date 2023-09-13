<?php
include "tmp/header.php";

global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
global $menuid, $goal, $current, $pct, $userid;

information_modal();

$menuid = 3;

testadmin();

?>
<div class="height-100">
    <!-- <h4>Courses</h4> -->
    <br>
    <!-- <div id="boxed">
        <div class="row ml-12 mr-12 clearfix">
            <div class="col" align="center">
                <font size="+3"><strong>About IHN Bible</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" id="btnrounded" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#information_modal">Update as of <?php echo date('m/d/Y'); ?></button>
            </div>
        </div>
    </div> -->

    <div id="boxed">
        <p class="text-center"><span style="font-size: 32px;">Calendar</span></p>
                
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=America%2FPhoenix&showTitle=0&showPrint=0&showTabs=1&showCalendars=0&src=aWhuYmlibGVAZ21haWwuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
</div>
<?php
include "tmp/footer.php";
?>

