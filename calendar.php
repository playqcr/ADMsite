<?php
include "tmp/header.php";

global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
global $menuid, $goal, $current, $pct, $userid;

information_modal();

$menuid = 3;

testadmin();

?>
<div class="height-100">
    <br>

    <div id="boxed">
        <p class="text-center"><span style="font-size: 32px;">Calendar</span></p>
                
        <div class="row">
            <div class="col-sm-3">
                <div class="d-flex justify-content-center">
                    <span style="fornt-size: 18px; font-weight: bold;">Calendar</span><br>
                </div>
                <div class="d-flex justify-content-center">
                    <div id="datepicker"></div>
                </div>
            </div>
            <div class="col-sm-6 d-flex justify-content-center">
                <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23ffffff&ctz=America%2FPhoenix&showTitle=0&showPrint=0&showTabs=1&showCalendars=0&src=aWhuYmlibGVAZ21haWwuY29t&src=YWRkcmVzc2Jvb2sjY29udGFjdHNAZ3JvdXAudi5jYWxlbmRhci5nb29nbGUuY29t&color=%23039BE5&color=%2333B679" style="border:solid 1px #777" width="800" height="600" frameborder="0" scrolling="no"></iframe>
            </div>
            <div class="col-sm-3">
                <div id="accordion" class="justify-content-center">
                    <h3>News & Upcoming Events</h3>
                    <div>
                        <p>This is where you will find current news and general information about upcoming events that may be of interest. For more detailed information on specific events see the Events section below.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, recusandae reiciendis minus facere iusto laboriosam odit. Et omnis accusamus perspiciatis cumque cum, hic quos exercitationem eveniet laudantium, quia reprehenderit rerum!</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, recusandae reiciendis minus facere iusto laboriosam odit. Et omnis accusamus perspiciatis cumque cum, hic quos exercitationem eveniet laudantium, quia reprehenderit rerum!</p>
                    </div>
                    <h3>Events</h3>
                    <div>
                        <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
                    </div>
                    <h3>Schedules</h3>
                    <div>
                        <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
                        <ul>
                            <li>List item one</li>
                            <li>List item two</li>
                            <li>List item three</li>
                        </ul>
                    </div>
                    <h3>New Things Added</h3>
                    <div>
                        <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
                    </div>
                </div>
            
            <!-- <button id="toggle">Toggle icons</button> -->
            </div>
        </div>
    </div>

    <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
</div>
<?php
include "tmp/footer.php";
?>

