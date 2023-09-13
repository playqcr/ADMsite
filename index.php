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
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;
    global $menuid, $goal, $current, $pct, $userid;
    information_modal();

    // Attempt select query execution
    if ($result = $mysqli->query("SELECT goalamt, curgoal FROM $system_tablename")) {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
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

    $menuid = 1;
    if(!empty($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
    }

    testadmin();

    $g = $goalamt;
    $c = $curgoal;

    $gresult = str_replace('$', '', $g);
    $goal = str_replace(',', '', $gresult);
    
    $cresult = str_replace('$', '', $c);
    $current = str_replace(',', '', $cresult);

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
                    ?>
                    <button type="button" id="btnrounded" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#information_modal">Update as of <?php echo date('m/d/Y'); ?></button>
                    <br>
                    <script src="//myradiostream.com/embed/ihnbible"></script>
                </div>
            </div>
        </div>

        <div id="boxed" class="text-center">
            <p><span style="font-size: 32px;">Get familiar with our online campus!</span></p>
                    
            <div class="row ml-12 mr-12 clearfix">
                <div class="col-sm-4" align="center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoOne">
                        Watch this Introduction video!
                    </button>
                </div>
                <div class="col-sm-4" align="center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoTwo">
                        How to use this site
                    </button>
                </div>
                <div class="col-sm-4" align="center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoThree">
                        How to enroll into a degree program
                    </button>
                </div>
                <!--div class="col-sm-2" align="center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoOne">
                        Coming Soon . . .
                    </button>
                </div-->
                <div class="col-sm-2" align="center"></div>
            </div>
        </div>

        <div id="boxed" class="text-center">
            <p style="font-size: 28px;">Our current financial goal is <?php echo $g; ?>, which supports hundreds of students by providing satelite communications to receive education classes in remote areas. Can you pay it forward and help us reach our goal?</p>
            <p><span style="font-size: 32px;">We have received </span><span style="font-size: 40px; font-weight: bold;"><?php echo $c; ?></span> <span style="font-size: 32px;">of our</span> <span style="font-size: 40px; font-weight: bold;"><?php echo $g; ?></span> <span style="font-size: 32px;">goal!</span></p>
            
            <div class="progress" style="height: 40px;">
            <?php
            if($width >= 100){
                ?>
                <div class="progress-bar bg-success" role="progressbar" aria-label="20px high" style="width: <?php echo $width; ?>%"></div>
                <?php
            }else{
                ?>
                <div class="progress-bar bg-info" role="progressbar" aria-label="20px high" style="width: <?php echo $width; ?>%"></div>
                <?php
            }
            ?>
                <!-- <div class="progress-bar bg-info" role="progressbar" aria-label="20px high" style="width: <?php echo $width; ?>%"></div> -->
                <div style="font-size: 24px; font-weight: bold; padding-top: 4px;"><?php echo $width; ?>%</div>
            </div>

            <a href="#" class="btn btn-danger btn-lg" style="margin-top: 20px; margin-bottom: 20px;"><i class='bx bxs-heart'></i> I want to help - donate now</a>

            <p>A huge thank you to all our current supporters who make this opportunity possible by faithfully supporting this generosity-driven education.</p>
        </div>

        <?php
        if(empty($_SESSION['userid'])){
            ?>
            <div id="boxed" class="text-center">
                <div class="row ml-12 mr-12 clearfix">
                    <div class="col-sm-4" align="center">
                        <div class="card" style="width: 18rem;">
                            <img src="img/card_1.jpg" style="width: 100%;" class="card-img-top" alt="...">
                            <div class="card-body">
                                <span class="card-title">Apply For Enrollment</span>
                                <p class="card-text">Fill out the admissions application below and start your Biblical education today!</p>
                            </div>
                            <div class="modal-footer card-btn">
                                <a href="admissions.php" class="btn btn-primary">Apply Now</a>
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
                                <a href="volunteer.php" class="btn btn-primary">Learn More</a>
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
                                <a href="prayerlist.php" class="btn btn-primary">Join Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div id="boxed" class="text-center">
                <div class="row ml-12 mr-12 clearfix">
                    <div class="col-sm-4" align="center">
                        <div class="card" style="width: 18rem;">
                            <img src="img/card_1.jpg" style="width: 100%;" class="card-img-top" alt="...">
                            <div class="card-body">
                                <span class="card-title">Apply For Enrollment</span>
                                <p class="card-text">Fill out the admissions application below and start your Biblical education today!</p>
                            </div>
                            <div class="modal-footer card-btn">
                                <a href="admissions.php" class="btn btn-primary">Apply Now</a>
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
                                <a href="volunteer.php" class="btn btn-primary">Learn More</a>
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
                                <a href="prayerlist.php" class="btn btn-primary">Join Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- <div id="boxed" class="text-center"> -->
                <div class="card spacing">
                    <div class="card-header">
                        My Courses
                    </div>
                    <div class="card-body">
                        <?php
                        global $enrollments_tablename, $enrollid, $euserid , $eprogid, $ecourseid, $examscore, $passed, $compdate, $rating;
                        global $courses_tablename, $courseid, $cprogid , $coursecode, $coursename, $coursedesc, $overview, $credits, $filename, $validcourse, $brief_desc, $course_photo, $course_cost, $course_discount, $hours, $videos, $cont_one, $cont_one_desc, $cont_two, $cont_two_desc, $cont_three, $cont_three_desc, $head_photo, $top_course;
                        $totalcr = 0;
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Course</th>
                                <th scope="col">Course Status</th>
                                <th scope="col">Credits</th>
                                <th scope="col">Completion Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Attempt select query execution
                                if ($result = $mysqli->query("SELECT eprogid, ecourseid, passed, compdate FROM $enrollments_tablename WHERE euserid = '$userid'")) {
                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_array($result)){
                                            $eprogid = $row['eprogid'];
                                            $ecourseid = $row['ecourseid'];
                                            $psd = $row['passed'];
                                            $compdate = $row['compdate'];
                                            // Attempt select query execution
                                            if ($resultb = $mysqli->query("SELECT courseid, coursecode, coursename, credits FROM $courses_tablename WHERE courseid = '$ecourseid'")) {
                                                if(mysqli_num_rows($resultb) > 0){
                                                    $rowb = mysqli_fetch_array($resultb);
                                                    $courseid = $rowb['courseid'];
                                                    $coursecode = $rowb['coursecode'];
                                                    $coursename = addslashes($rowb['coursename']);
                                                    $credits = $rowb['credits'];
                                                    $totalcr += $credits;
                                                    if($psd){
                                                        $passed = "<a href='course.php?coursename=".$coursename."&courseid=".$courseid."' class='btn btn-success' style='width: 200px;'><span style='font-size: 18px;'>COMPLETED</span></a>";
                                                    }else{
                                                        $passed = "<a href='course.php?coursename=".$coursename."' class='btn btn-success' style='width: 200px;'><span style='font-size: 18px;'>INCOMPLETE</span></a>";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <?php
                                                        if($psd){
                                                            ?>
                                                            <td><?php echo $coursecode; ?> - <?php echo $coursename; ?></td>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <td><a href="#"><?php echo $coursecode; ?> - <?php echo $coursename; ?></a></td>
                                                            <?php
                                                        }
                                                        ?>
                                                        <!-- <td>< ?php echo $coursecode; ?> - < ?php echo $coursename; ?></td> -->
                                                        <td><?php echo $passed; ?></td>
                                                        <td><?php echo $credits; ?></td>
                                                        <td><?php echo $compdate; ?></td>
                                                    </tr>
                                                    <?php
                                                    // Free result set
                                                    // mysqli_free_result($result);
                                                } else{
                                                    $msg = "<font color='#FF0000'><strong>Account not found!</strong></font>";
                                                    main_form();
                                                    exit;
                                                }
                                            } else{
                                                echo "ERROR: Was not able to execute Query on line #152. " . mysqli_error($mysqli);
                                            }
                                            // End attempt select query execution
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
                                <tr>
                                    <td></td>
                                    <td><?php echo "Total Credits: ".$totalcr; ?></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <!-- </div> -->
            <?php
        }
        ?>
        
        <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
    </div>


    <?php
        $news = "<h3><strong>IMPORTANT!</strong></h3>
        We have been having problems with students not being able to change their password. This has just been fixed finally. We deeply apologize for the inconvenience.
        <br /><br />
        If you cannot login to the school page because you forgot your password, go to the login page. Just under the login area you will find a link entitled &quot;I Forgot My Password&quot;. Click this link and follow the directions. It may take several minutes to receive an email. When you do click the link in the email or copy it to your browser and you will get to a screen where you can change your password.
        <br /><br />
        We are very sorry for the inconvenience.
        <br /><br />
        Blessings to you and yours!
        <br /><br />
        <strong>10/21/2020</strong>
        <br /><br />
        <h3><strong>NEW SCHOOL CAMPUS</strong></h3>
        We have just opened another campus in Africa located in the Zimbabwe refugee camp. They will begin classes next week, November 2020 and would like to welcome those students to the IHN Bible College family! You can see more by checking out our <a href='https://ihnbible.org/campus_africa.php'>Africa campus</a> pages.
        <br /><br />
        <strong>11/03/2020</strong>
        ";
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