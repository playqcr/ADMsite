<?php
include "tmp/header.php";

global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
global $menuid, $goal, $current, $pct, $userid;

information_modal();

$menuid = 4;

testadmin();

?>
<div class="height-100">
    <!-- <h4>Courses</h4> -->
    <br>
    <div id="boxed">
        <div class="row ml-12 mr-12 clearfix">
            <div class="col" align="center">
                <font size="+3"><strong>Welcome, <?php echo $userfname; ?>!</strong></font>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" id="btnrounded" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#information_modal">Update as of <?php echo date('m/d/Y'); ?></button>
            </div>
        </div>
    </div>

    <div id="boxed">
        <p class="text-center"><span style="font-size: 32px;">INTRODUCTION</span></p>
                
        <div class="row ml-12 mr-12">
            <div class="col-sm-6" style="text-align: left;">
                <h3>The Program</h3>
                <p>Our Associates Degree of Biblical Studies (also known as a Diploma Program) is offered to give a well-balanced education in the Bible. It is designed as an introduction to all other studies. There is nothing more important to the Christian student than to have a strong, working knowledge of the Bible and its contents.</p>
            </div>
            <div class="col-sm-6" style="text-align: left;">
                <h3>Requirements</h3>
                <p>The requirement for enrollment is very easy and open to anyone. Anyone can study and receive a certificate of completion. However, if you are seeking a diploma you will need to provide your High School transcripts which show a successful graduation or a GED equivalent.</p>
                <p>If this is the first time you are enrolling, you will need to go to the <a href="admissions.php">Admissions page</a> and fill out an application. Once this is done you will be sent a response to your email account with login instructions.</p>
            </div>
        </div>
    </div>

    <div id="boxed">
        <p class="text-center"><span style="font-size: 32px; font-weight: bold;">Associates of Biblical Studies Program</span></p>

        <div class="row">
            <div class="col-sm-12" id="asc">
                <div class="card spacing">
                    <div class="card-body">
                        <span style="font-weight: bold; font-size: 18px;">Associates Degree of Biblical Studies</span>
                        <p class="card-text">20 Courses 60 Credits</p>
                        <div class="row">
                            <div class="col-4">
                                <strong>BIB101</strong><br>Old Testament Survey I<br>
                                <strong>BIB102</strong><br>New Testament Survey I<br>
                                <strong>BIB103</strong><br>Foundations of Faith<br>
                                <strong>BIB104</strong><br>Bible Study Methods I<br>
                                <strong>BIB105</strong><br>Biblical World View<br>
                                <strong>BIB106</strong><br>Kingdom Living<br>
                                <strong>BIB107</strong><br>Knowing God's Voice<br>
                            </div>
                            <div class="col-4">
                                <strong>MIN108</strong><br>Management By Objectives<br>
                                <strong>MIN109</strong><br>Environmental Analysis<br>
                                <strong>BIB110</strong><br>Spiritual Warfare<br>
                                <strong>MIN111</strong><br>Mobilization Methodologies<br>
                                <strong>MIN112</strong><br>Introduction to Evangelism<br>
                                <strong>MIN113</strong><br>Spiritual Harvest<br>
                                <strong>MIN114</strong><br>Holy Spirit Ministry<br>
                            </div>
                            <div class="col-4">
                                <strong>MIN115</strong><br>Multiplication Methodologies<br>
                                <strong>MIN116</strong><br>Jail And Prison Ministry<br>
                                <strong>BIB117</strong><br>Women: A Biblical Profile<br>
                                <strong>MIN118</strong><br>Intercessory Prayer<br>
                                <strong>BIB119</strong><br>Power Principles<br>
                                <strong>MIN120</strong><br>Introduction to the Principles of Teaching<br>
                            </div>
                        </div>
                        <a href="admissions.php" class="btn btn-primary" style="margin-top: 20px;">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <div style="margin-bottom: 50px;">&nbsp;</div>
</div>
<?php
include "tmp/footer.php";
?>