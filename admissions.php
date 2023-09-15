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
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $menuid, $goal, $current, $pct, $userid;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;
    global $enrollments_tablename, $enrollid, $euserid , $eprogid, $ecourseid, $examscore, $passed, $compdate, $rating;
    global $courses_tablename, $courseid, $cprogid , $coursecode, $coursename, $coursedesc, $overview, $credits, $filename, $validcourse, $brief_desc, $course_photo, $course_cost, $course_discount, $hours, $videos, $cont_one, $cont_one_desc, $cont_two, $cont_two_desc, $cont_three, $cont_three_desc, $head_photo, $top_course;

    information_modal();
    $menuid = 5;
    testadmin();
    ?>
    <div class="height-100">
        <!-- <h4>Courses</h4> -->
        <br>
        <div id="boxed">
            <div class="row ml-12 mr-12 clearfix">
                <div class="col" align="center">
                    <span style="font-size: 36px; font-weight: bold;"><strong>Admissions</strong></span>
                </div>
            </div>
        </div>

        <!-- <div id="boxed" class="text-center">
            <p><span style="font-size: 32px;">What You Will Find Here</span></p>
                    
            <div class="row ml-12 mr-12 clearfix">
                <div class="col-sm-4" align="center">
                    <div class="card" style="width: 18rem;">
                        <img src="img/card_1.jpg" style="width: 100%;" class="card-img-top" alt="...">
                        <div class="card-body">
                            <span class="card-title">Apply For Enrollment</span>
                            <p class="card-text">Fill out the admissions application below and start your Biblical education today!</p>
                        </div>
                        <div class="modal-footer card-btn">
                            <a href="#applicate"><button class="btn btn-primary btn-sm" style="width: 250px;">Apply Now</button></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" align="center">
                    <div class="card" style="width: 18rem;">
                        <img src="img/card_2.jpg" style="width: 100%;" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Become a Volunteer</h5>
                            <p class="card-text">We need educators, administrators, writers, web developers, and so much more. Join our team!</p>
                        </div>
                        <div class="modal-footer card-btn">
                            <a href="volunteer.php" style="width: 250px;" class="btn btn-primary btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" align="center">
                    <div class="card" style="width: 18rem;">
                        <img src="img/card_3.jpg" style="width: 100%;" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Join Our Prayer Warriors</h5>
                            <p class="card-text">View our prayer list and pray over the issues and concerns. Join with others and witness God's power.</p>
                        </div>
                        <div class="modal-footer card-btn">
                            <a href="prayerlist.php" style="width: 250px;" class="btn btn-primary btn-sm">Join Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div id="boxed">
            <div class="row ml-12 mr-12">
                <div class="col" align="center">
                    <span style="font-size: 36px; font-weight: bold;"><strong>Already Registered As a Student?<br>Enroll Into a Program or Course Now!</strong></span>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div id="boxed" class="col-sm-8" align="center">
                        <span style="font-size: 24px; font-weight: bold;">List of Programs</span>
                        <p>When enrolling into a program you will automatically be enrolled into the individual courses which are required by the program. There is no need to enroll into a course that is in a program if you intend to enroll into that program. However, if you have already enrolled into a course and then decide later to enroll into a program in which has the course you have already enrolled into, that course will automatically be connected to the program, and you will receive credit if you have successfully completed the course.</p>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div id="boxed" class="col-sm-8" align="center">
                        <p><span style="font-size: 32px;">List of Courses</span></p>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            < ?php
                            // Attempt select query execution
                            if ($result = $mysqli->query("SELECT * FROM $courses_tablename")) {
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                                        $courseid = $row['courseid'];
                                        $cprogid = $row['cprogid'];
                                        $coursecode = $row['coursecode'];
                                        $coursename = $row['coursename'];
                                        $coursedesc = $row['coursedesc'];
                                        $credits = $row['credits'];
                                        $validcourse = $row['validcourse'];
                                        if($validcourse){
                                            ?>
                                            <div class="col">
                                                <div class="card course-cards">
                                                    <div class="card-body">
                                                        <span class="card-title" style="font-size: 18px; font-weight: bold;">< ?php echo $coursename; ?></span>
                                                        <br>
                                                        <span class="card-title" style="font-size: 14px; font-weight: bold;">< ?php echo $coursecode." - ".$credits." Credits"; ?></span>
                                                        <p class="card-text">< ?php echo substr_replace($coursedesc, "...", 140); ?></p>
                                                    </div>
                                                    <div class="card-footer d-grid gap-2">
                                                        < ?php
                                                        if(empty($_SESSION['userid'])){
                                                            ?>
                                                            <a href="#applicate" class="btn btn-primary btn-sm btn-block">Register or Login To Study</a>
                                                            < ?php
                                                        }else{
                                                            ?>
                                                            <a href="enroll.php?id=< ?php echo $courseid; ?>" class="btn btn-primary btn-sm">Enroll Into Course</a>
                                                            < ?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            < ?php
                                        }
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
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div> -->

        <!-- <div id="boxed" style="margin-bottom: 50px;">
            <h5 id="applicate"></h5>
            <div class="row ml-12 mr-12 clearfix">
                <div class="col" align="center">
                    <span style="font-size: 36px; font-weight: bold;"><strong>REGISTRATION APPLICATION</strong></span>
                </div>
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div id="boxed" class="col-sm-8">
                        <form action="<?php echo $PHP_SELF ?>" method="post">
                            <div class="text-center">
                                <span style="font-size: 24px; font-weight: bold;">Student Registration Application</span>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="userfname" class="form-label">First Name:</label>
                                        <input type="text" name="userfname" class="form-control" id="userfname">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="usermname" class="form-label">Middle Name:</label>
                                        <input type="text" name="usermname" class="form-control" id="usermname">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="userlname" class="form-label">Last Name:</label>
                                        <input type="text" name="userlname" class="form-control" id="userlname">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="useraddress" class="form-label">Mailing Address:</label>
                                        <input type="text" name="useraddress" class="form-control" id="useraddress">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="usercity" class="form-label">City:</label>
                                        <input type="text" name="usercity" class="form-control" id="usercity">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="userstate" class="form-label">State/Province:</label>
                                        <input type="text" name="userstate" class="form-control" id="userstate">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email address</label>
                                        <input type="email" name="useremail" class="form-control" id="useremail" placeholder="name@example.com">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="userzip" class="form-label">Zip/Postal Code:</label>
                                        <input type="text" name="userzip" class="form-control" id="userzip">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="usercountry" class="form-label">Country:</label>
                                        <input type="text" name="usercountry" class="form-control" id="usercountry">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="userphone" class="form-label">Phone Number:</label>
                                        <input type="text" name="userphone" class="form-control" id="userphone" placeholder="+1-123-456-7890">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="highgrade" class="form-label">Highest Grade Completed:</label>
                                        <input type="text" name="highgrade" class="form-control" id="highgrade">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="dob" class="form-label">Date of Birth:</label>
                                        <input type="text" name="dob" class="form-control" id="dob">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="usersaved" class="form-label">Are you saved?:</label>
                                        <div class="form-check">
                                            <input name="usersaved" class="form-check-input" type="checkbox" value="" id="usersaved">
                                            <label class="form-check-label" for="usersaved">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="baptized" class="form-label">Are you baptized?:</label>
                                        <div class="form-check">
                                            <input name="baptized" class="form-check-input" type="checkbox" value="" id="baptized">
                                            <label class="form-check-label" for="baptized">
                                                Yes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label for="baptismdate" class="form-label">Baptism Date:</label>
                                        <input type="text" name="baptismdate" class="form-control" id="baptismdate">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="profile" class="form-label">Please give us some information about yourself.</label>
                                <textarea class="form-control" name="profile" id="profile" rows="5"></textarea>
                            </div>

                            <button type="submit" name="action" class="btn btn-primary btn-small btn-block" value="Submit">SUBMIT</button>
                        </form>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div> -->

    <div id="boxed" style="margin-bottom: 50px;"></div>

    </div>
    <?php
    include "tmp/footer.php";
}

function submit_app(){
    global $PHP_SELF, $mysqli, $msg;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;
    
    main_form();
}

//*******************************************************
//**********************  SWITCH  ***********************
//*******************************************************
switch($action) {
    case "Submit":
        submit_app();
    break;
	default:
		main_form();
	break;
}

?>