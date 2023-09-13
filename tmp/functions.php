<?php
/*************************************************************************
 **  RELEASE NOTES MODAL
 *************************************************************************/
function information_modal(){
    global $PHP_SELF, $mysqli, $hdmysqli, $bkcolor, $perpage, $page, $msg;
    global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;

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
            $msg = "<font color='#FF0000'><strong>Account Does Not Exsist!</strong></font>";
            main_form();
            exit;
        }
    } else {
        echo "ERROR: Was not able to execute Query in functions line #3. " . mysqli_error($mysqli);
    }
    // End attempt select query execution

?>
    <div class="modal fade" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="informationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 750px; margin-left: -120px; height: 750px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="informationLabel">Release Notes</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" id="mytextarea">
                        <?php echo $releasenotes; ?>
                    </textarea>
                </div>
                <div class="modal-footer">
                    <!-- <form action="generate_pdf.php" target="_blank" method="post">
                        <button name="action" type="submit" value="DateMonth" class="btn btn-primary"><i class="fas fa-print"></i> Print Release Notes</button>
                    </form> -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/qa5ollct4qx4a9lkzbhdh1ki6763pwyi6jx3m0s5ut86u8by/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea',
            toolbar: '',
            menubar: '',
            width: 720,
            height: 570,
            readonly: 1
        });
    </script>
<?php
}


function menu(){
    global $menuid;

    // DASHBOARD
    if($menuid == 1){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        <a class="nav_link active" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Administration"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // ABOUT
    if($menuid == 2){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Administration"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // CALENDAR
    if($menuid == 3){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Administration"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>
                        <a class="nav_link active" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // MY COURSES
    if($menuid == 4){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Administration"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>
                        <a class="nav_link active" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // COLLEGE ADMISSIONS
    if($menuid == 5){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        <a href="index.php" class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Administration"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>
                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>
                        <a class="nav_link active" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </nav>
        </div>
        <?php
    }
}

function adminmenu(){
    global $menuid;

    // ADMINISTRATION
    if($menuid == 0){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link active" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // DASHBOARD
    if($menuid == 1){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // ABOUT
    if($menuid == 2){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // CALENDAR
    if($menuid == 3){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // MY COURSES
    if($menuid == 4){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }

    // COLLEGE ADMISSIONS
    if($menuid == 5){
        ?>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <a class="nav_logo" onClick="Javascript:window.location.href = 'index.php';">
                        <span class="nav_logo-name">IHN Bible College</span>
                    </a>
                    <div class="nav_list">
                        
                        <a class="nav_link" onClick="Javascript:window.location.href = 'admin.php';">
                            <i class='bx bx-cog' title="Administration"></i><span class="nav_name">&nbsp;&nbsp;ADMINISTRATION</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'index.php';">
                            <i class="bx bx-grid-alt nav_icon" title="Dashboard"></i><span class="nav_name">&nbsp;&nbsp;Dashboard</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'about.php';">
                            <i class='bx bx-universal-access nav_icon' title="About"></i><span class="nav_name">&nbsp;&nbsp;About</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'calendar.php';">
                            <i class='bx bx-calendar nav_icon' title="Calendar"></i><span class="nav_name">&nbsp;&nbsp;Calendar</span>
                        </a>

                        <a class="nav_link" onClick="Javascript:window.location.href = 'courses.php';">
                            <i class='bx bx-book-reader nav_icon' title="Courses"></i><span class="nav_name">&nbsp;&nbsp;Courses</span>
                        </a>

                        <a class="nav_link active" onClick="Javascript:window.location.href = 'admissions.php';">
                            <i class='bx bxs-school nav_icon' title="Admissions"></i><span class="nav_name">&nbsp;&nbsp;Admissions</span>
                        </a>

                        <?php
                        if(!empty($_SESSION['userid'])){
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'logout.php';">
                                <i class="bx bx-log-out nav_icon" title="Logout"></i><span class="nav_name">&nbsp;&nbsp;Logout</span>
                            </a>
                            <?php
                        }else{
                            ?>
                            <a class="nav_link" onClick="Javascript:window.location.href = 'login.php';">
                                <i class='bx bx-log-in nav_icon' title="Student Login"></i><span class="nav_name">&nbsp;&nbsp;Student Login</span>
                            </a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            </nav>
        </div>
        <?php
    }
}

function testadmin(){
    global $isadmin;
    
    if($isadmin == '1'){
        adminmenu();
    }else{
        menu();
    }
}
?>