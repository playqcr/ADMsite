<?php
include "tmp/header.php";

global $system_tablename, $sysid, $president , $vice, $treasurer, $secretary, $directorafrica, $deanedu, $corecourses, $followers, $facebook, $twitter, $youtube, $linkedin, $info, $updatedate, $cookietime, $sysadminver, $verdate, $releasenotes, $goalamt, $curgoal;
global $menuid, $goal, $current, $pct, $userid;

information_modal();

$menuid = 2;

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
        <p class="text-center"><span style="font-size: 32px;">About IHN Bible</span></p>
                
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <p>IHN Bible College is not as exclusive as a traditional Bible College or University because it eliminates materials not directly related to spiritual growth and productivity. We are not in competition with the traditional Bible Institution structure but our training is for lay men and women who do not have opportunities, educationally and/or financially, for such training.</p>

                <p>IHN Bible College equips students with creative Bible study skills to enable continued study of Scriptures following basic course training. But the primary focus of our college training is teaching what Jesus taught . . . to move men from observation of the power of God to demonstration of the power of God.</p>

                <p style="font-size: 24px; font-weight: bold;">Our Mission</p>

                <p>The vision and purpose of IHN Bible College is to equip the saints for ministry through timely, free training. We desire to raise a mighty army of men and women who are prepared to spread the Gospel of Jesus Christ through love, vision, spiritual preparation of the heart, training in the Word of God, and its principles and methods.</p>

                <p style="font-size: 24px; font-weight: bold;">Church-Based College Training</p>

                <p>This church-based College, through spiritual leaders, offers aggressive College training for thorough equipping of Christian leadership. We emphasize balanced doctrine, servant-hood, leadership, character development and developing a biblical global perspective.</p>

                <p>IHN Bible College is a place to train men and women called to part-time or full-time College and those interested in becoming better equipped to serve their local church or ministry.</p>

                <p>We offer academic excellence and methods that will train you to maximize your leadership skills and attitude to reach your God-given potential.</p>

                <p style="font-size: 24px; font-weight: bold;">Faculty and Staff</p>

                <p>Bible schools would like to employ full-time personnel if they had sufficient money and the personnel available. But, realistically speaking, you will not find many full-time teachers in our school. Many teachers are also pastors, as well as lay ministers in full-time secular work. Often the Bible schools could not survive without the dedicated efforts of part-time teachers. This is a volunteer organization and everything we do is based on donations and volunteerism.</p>

                <p>The IHN Bible, Inc. board of directors is also a staff of volunteers. Located in Yuma, Arizona, our board is comprised of these individuals:</p>
                <hr>

                <p><img src="img/portraits/tom_moore_school.jpg" alt="" style="float: left; padding-right: 10px; width: 150px;"><strong>Thomas J. Moore, D.D., President and co-founder of IHN Bible.</strong></p>
                <p>With over 35 years of ministry experience, Dr. Moore designed and developed this college ministry and most of the content and curriculum in it. He developed the original ministry called “Oregon Grace” which was a home-schooling ministry. His team and much of that ministry has changed over the years and has evolved to what it is today. If you have any questions, please submit them through our Help Desk system and he will reply as soon as possible.</p>
                <hr>

                <p><img src="img/portraits/ric_pollard.jpg" alt="" style="float: right; padding-left: 10px; width: 150px;"><strong>Ric Pollard, Vice President of IHN Bible.</strong></p>
                <p>Ric is a faithful steward of God and has commited himself to the service of the church and the ministry. A retired veteran of the U.S. Armed Forces he has retired and now serves faithfully as a leader. He not only serves as vice president of IHN Bible, he also serves as president on the Grace Bible Fellowship Board of Directors. He is a gentle man with a huge love for all persons. He strives to bring peace into everyone's life and teaches God's Word with truth and strength.</p>
                <hr>

                <p><img src="img/portraits/terry_shields.jpg" alt="" style="float: left; padding-right: 10px; width: 150px;"><strong>Terry Shields, D.D., Treasurer and co-founder of IHN Bible.</strong></p>
                <p>After meeting Dr. Thomas Moore and finding they had a musical interest they shared, Terry joined with Dr. Thomas to develop a Christ Based education for all who could use it. Their first attempt was in the home-schooling arena which they quickly found was too competitive. They then took Dr. Thomas' vision and created an online Free Bible college in hopes of education people around the world. Terry continues playing music that inspires.</p>
                <hr>

                <p><img src="img/portraits/vincella.jpg" alt="" style="float: right; padding-left: 10px; width: 150px;"><strong>Vincella M. Moore, Secretary.</strong></p>
                <p>Mother of one boy, Vincent, she dedicates her life to her husband and graciously volunteers her time to God's work. She maintains the audio mix during church services and has a servant's heart. She ministers to those who are in need and gives her time to entertain children from time to time by making balloon animals at events. She has served for many years and is still vital part of the ministry. She is coming up for retirement soon and is looking for a replacement for her position.</p>
                <hr>

                <p><img src="img/portraits/lee_sawyer.jpeg" alt="" style="float: left; padding-right: 10px; width: 150px;"><strong>Lee Sawyer, D.D., Director of Education.</strong></p>
                <p>Lee is a wonderfully loving man who has a strong passion for Jesus and teaching Biblical truths. He joined the board in 2020 and has helped put together the curriculum and study materials. He lives with his wife, Jan and travels back and for between Oregon and Arizona every year. He is a fun loving and joyous person. He always has jokes to tell and encouraging words for those who need it. His attention to the feelings of people around him makes him a strong counselor who gives great advice and backs up his thoughts with the Word of God.</p>
                <hr>

                <p><img src="img/portraits/Benjamin_Elunga.jpg" alt="" style="float: right; padding-left: 10px; width: 150px;"><strong>Benjamin Elunga W'Elunga, D.D., Executive Director of IHN Bible College Africa.</strong></p>
                <p>Dr. Benjamin once lived in the Nyarugusu refugee camp in Tanzania. In 2019 Covid-19 hit the world and shutdown many ministries. Early 2020 Dr. Benjamin was looking to build a Bible college in the camp. He found IHN Bible College online and contacted the president, Dr. Thomas, to propose a partnership. After much prayer and discussion they decided to merge their efforts and expand the college ministry. Due to Dr. Benjamin's efforts many college branches have been openned in Africa and has been promoted to Executive Director of IHN Bible College Africa. Since then he has been reloacted to the U.S. where he continues his work in Africa and now in the U.S.</p>
                <hr>

            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div id="boxed" style="margin-bottom: 50px;">&nbsp;</div>
</div>
<?php
include "tmp/footer.php";
?>

