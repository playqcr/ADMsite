<?php
/****************************************************
****   Advanced Data Manager
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
include "tmp/header.php";

global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
global $menuid, $goal, $current, $pct, $userid;

information_modal();

$menuid = 2;

testadmin();

?>
<div class="height-100">
    <br>

    <div id="boxed">
        <p class="text-center"><span style="font-size: 32px;">About ADM</span></p>
                
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam dignissimos quos fugit autem provident voluptas eaque illum? Ducimus blanditiis ullam nesciunt repellat consectetur accusantium laboriosam, distinctio eligendi dolorem exercitationem veritatis.</p>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
</div>
<?php
include "tmp/footer.php";
?>

