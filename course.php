<?php
/****************************************************
****   IHN Bible College
****   Designed by: Tom Moore
****   Written by: Tom Moore
****   (c) 2001 - 2021 TEEMOR eBusiness Solutions
****************************************************/
include "tmp/header.php";

	global $PHP_SELF, $mysqli, $msg, $notice, $notice_header, $notice_body, $fullname;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
    global $users_tablename, $userid, $useremail , $userpassword, $isadmin, $userfname, $usermname, $userlname, $useraddress, $usercity, $userstate, $userzip, $usercountry, $userphone, $suspended, $highgrade, $dob, $usersaved, $baptized, $baptismdate, $profile, $imagepath, $corecompletedate, $branchid, $role, $messages, $core_complete, $resetpwd;

    global $courses_tablename, $courseid, $cprogid , $coursecode, $coursename, $coursedesc, $overview, $credits, $filename, $validcourse, $brief_desc, $course_photo, $course_cost, $course_discount, $hours, $videos, $cont_one, $cont_one_desc, $cont_two, $cont_two_desc, $cont_three, $cont_three_desc, $head_photo, $top_course;

    global $menuid, $goal, $current, $pct, $userid;

    information_modal();

    $menuid = 2;

    testadmin();

    $course = $_GET['coursename'];
    $courseid = $_GET['courseid'];
    
    // Attempt select query execution
    $sqlz = "SELECT * FROM $courses_tablename WHERE courseid = '$courseid'";
    if ($resultz = mysqli_query($mysqli, $sqlz)) {
        if (mysqli_num_rows($resultz) > 0) {
            $rowz = mysqli_fetch_array($resultz);
            $courseid = $rowz['courseid'];
            $coursecode = $rowz['coursecode'];
            $coursename = $rowz['coursename'];
            $coursedesc = $rowz['coursedesc'];
            $credits = $rowz['credits'];
            $filename = $rowz['filename'];
            $validcourse = $rowz['validcourse'];
            $brief_desc = $rowz['brief_desc'];
            $course_photo = $rowz['course_photo'];
            $course_cost = $rowz['course_cost'];
            $course_discount = $rowz['course_discount'];
            $hours = $rowz['hours'];
            $videos = $rowz['videos'];
            $cont_one = $rowz['cont_one'];
            $cont_one_desc = $rowz['cont_one_desc'];
            $cont_two = $rowz['cont_two'];
            $cont_two_desc = $rowz['cont_two_desc'];
            $cont_three = $rowz['cont_three'];
            $cont_three_desc = $rowz['cont_three_desc'];
            $head_photo = $rowz['head_photo'];
            $top_course = $rowz['top_course'];
            // Free result set
            mysqli_free_result($resultz);
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
    <div class="height-100">
        <br>
        <div id="boxed">
            <p class="text-center"><span style="font-size: 32px;"><?php echo $course; ?></span></p>
                    
            <div class="row">
                <!-- <div class="col-sm-2"></div> -->
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3" style="padding-left: 50px;">
                            <img src="img/school_books/<?php echo $course_photo; ?>" alt="" style="width: 250px;">
                        </div>
                        <div class="col-sm-5">
                            <p><span style="font-size: 16px; font-weight: bold;">Course ID:</span> <?php echo $courseid; ?></p>
                            <p><span style="font-size: 16px; font-weight: bold;">Course Code:</span> <?php echo $coursecode; ?></p>
                            <p><span style="font-size: 16px; font-weight: bold;">Course Name:</span> <?php echo $coursename; ?></p>
                            <p><span style="font-size: 16px; font-weight: bold;">Credits:</span> <?php echo $credits; ?></p>
                            <p><span style="font-size: 16px; font-weight: bold;">Course Description:</span><br><?php echo $coursedesc; ?></p>
                            <!-- <p>File Name: <?php echo $filename; ?></p> -->
                        </div>
                        <div class="col-sm-4">
                            <p><span style="font-size: 16px; font-weight: bold;">Brief Description:</span><br><?php echo $brief_desc; ?></p>
                            <p><span style="font-size: 16px; font-weight: bold;">Course Overview:</span><br><?php echo $overview; ?></p>
                        </div>
                    </div>
                    <!-- <p>Is Course Valid: <?php echo $validcourse; ?></p> -->
                    <!-- <p>Course Cost: <?php echo $course_cost; ?></p>
                    <p>Course Discount: <?php echo $course_discount; ?></p>
                    <p>Hours: <?php echo $hours; ?></p>
                    <p>Videos: <?php echo $videos; ?></p>
                    <p>Content #1: <?php echo $cont_one; ?></p>
                    <p>Content #1 Description: <?php echo $cont_one_desc; ?></p>
                    <p>Content #2: <?php echo $cont_two; ?></p>
                    <p>Content #2 Description: <?php echo $cont_two_desc; ?></p>
                    <p>Content #3: <?php echo $cont_three; ?></p>
                    <p>Content #3 Description: <?php echo $cont_three_desc; ?></p>
                    <p>Head Photo: <?php echo $head_photo; ?></p>
                    <p>Top Course: <?php echo $top_course; ?></p> -->
                </div>
                <!-- <div class="col-sm-2"></div> -->
            </div>
        </div>

        <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
    </div>
    <?php
    include "tmp/footer.php";
// }

// //*******************************************************
// //**********************  SWITCH  ***********************
// //*******************************************************
// switch($action) {
//     case "Try Again":
//         main_form();
//     break;
//     case "Submit":
//         check_login();
//     break;
//     case "Register":
//         header('Location: register.php');
//     break;
//     case "Forgot":
//         header('Location: lostpwd.php');
//     break;
// 	default:
// 		main_form();
// 	break;
// }
?>

