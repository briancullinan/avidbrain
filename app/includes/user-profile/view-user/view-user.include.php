<h1>
    <?php echo $app->actualuser->short_description_verified; ?>
</h1>
<div class="user-hero">
    <div class="user-hero-left">
        <div class="user-hero-image"><img src="<?php echo userphotographs($app->user,$app->actualuser); ?>" /></div>
    </div>
    <div class="user-hero-right">

        <div class="user-hero-items">

            <div class="user-hero-block">
                <div class="user-hero-block-title">
                    Students
                </div>
                <div class="user-hero-block-content">
                    13
                </div>
            </div>

            <div class="user-hero-block">
                <div class="user-hero-block-title">
                    Tutors
                </div>
                <div class="user-hero-block-content">
                    452
                </div>
            </div>

            <div class="user-hero-block">
                <div class="user-hero-block-title">
                    Q&A Posts
                </div>
                <div class="user-hero-block-content">
                    1,234
                </div>
            </div>

            <div class="user-hero-block">
                <div class="user-hero-block-title">
                    Profile Views
                </div>
                <div class="user-hero-block-content">
                    666
                </div>
            </div>

        </div>

        <div class="actual-hero">
            <!-- myhero -->
        </div>

    </div>
</div>


<div class="row fixed-rows">
    <div class="col s12 m4 l3">
        <div class="user-info">


            <?php
                $staticBadges = [];
                $staticBadges[] = (object)array('class'=>'my-name','icon'=>'fa fa-bolt','results'=>short($app->actualuser));
                $staticBadges[] = (object)array('class'=>'location','icon'=>'fa fa-map-marker','results'=>'<a href="/searching/---/'.$app->actualuser->zipcode.'">'.$app->actualuser->city.', '.ucwords($app->actualuser->state_long).'</a>');
                $staticBadges[] = (object)array('class'=>'signup-date','icon'=>'fa fa-calendar','results'=>'Joined '.formatdate($app->actualuser->signup_date));
                $staticBadges[] = (object)array('class'=>'hourlyrate','icon'=>'fa fa-dollar','results'=>'$'.numbers($app->actualuser->hourly_rate).'/<span>Hour</span>');

            ?>
            <?php foreach($staticBadges as $ajaxBadge): ?>
                <div class="newest-badge <?php echo $ajaxBadge->class; ?>">
                    <span class="newest-badge-icon"><i class="<?php echo $ajaxBadge->icon; ?>"></i></span> <?php echo $ajaxBadge->results; ?>
                </div>
            <?php endforeach; ?>

            <div class="ajax-badges" id="<?php echo str_replace('/','',$app->actualuser->url); ?>" data-url="<?php echo $app->actualuser->url; ?>"></div>


        </div>
        <div class="right-nav hide-on-large-only" id="copyme">
            <div class="signup-now">
                <a href="">Signup Now</a>
            </div>
            <ul class="insides">
                <li>
                    <a href="">
                        potato
                    </a>
                </li>
                <li>
                    <a href="">
                        ninja
                    </a>
                </li>
                <li>
                    <a href="">
                        baloon
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col s12 m8 l7">
        <?php
            $mypages = [
                'about-me'=>'About Me',
                'my-subjects'=>'My Subjects',
                'qa-posts'=>'Q&amp;A Posts',
                'my-reviews'=>'My Reviews',
                'send-message'=>'Send Message'
            ];
        ?>
        <div class="my-tabs">
            <ul>
                <?php foreach($mypages as $key => $page): ?>
                    <li <?php if(isset($pagename) && $pagename==$key){ echo 'class="active"';} ?>>
                        <a href="<?php echo $app->actualuser->url; ?>/<?php echo $key; ?>">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php
                include('view-user--'.$pagename.'.php');
            ?>
        </div>
    </div>
    <div class="col s12 m3 l2 hide-on-med-and-down">
        <div class="copy-that"></div>
    </div>
</div>

<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>

<style type="text/css">
.viewuserviewuser h1{
    padding: 0px 15px;
    margin: 0px;
    margin-top: -25px;
    margin-bottom: -20px;
}
main .view-user----view-user{
    width: 100% !important;
}
.user-hero{
    width: 100%;
    padding: 15px;
    float: left;
}
.row.fixed-rows{
    margin: 0px;
}
.user-info{
    padding-bottom: 20px;
}
.user-hero-image img{
    border: solid 8px #fff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    max-width: 100%;
}
.user-info-name{
    background: rgba(255, 255, 255, 0.82);
    padding: 10px;
    font-size: 18px;
    margin-top: -52px;
    position: relative;
    z-index: 12;
}
.newest-badge{
    background: #fff;
    padding: 5px;
    margin-bottom: 1px;
}
.newest-badge .newest-badge-icon{
    display: inline-block;
    width: 35px;
    margin-right: 10px;
    text-align: center;
    font-size: 22px;
}
.signup-date i{
    color: #666;
}
.location i{
    color: #0077d7;
}
.hourlyrate i{
    color: #319c10;
}
.tutor-rank i{
    color: red;
}
.backgroundcheck i{
    color: #b0d400;
}
.badge-new-user i{
    color: orange;
}
.user-hero-left{
    text-align: center;
    float: left;
    width: 25%;
    box-sizing: border-box;
}
.user-hero-right{
    float: left;
    width: 75%;
    box-sizing: border-box;
}
.user-hero-items{
    display: flex;
    width: 100%;
}
.user-hero-block-content{
    color: #007dff;
}
.user-hero-block{
    flex-grow:1;
    text-align: center;
    background: #fff;
    padding: 5px;
}
.user-hero-block-title{
    text-transform: uppercase;
    font-size: 12px;
    font-weight: bold;
}
.actual-hero{
    background-image:url('http://i.imgur.com/BdPMeg8.jpg');
    background-size: cover;
    background-position:  center center;
    width: 100%;
    min-height: 250px;
    border: solid 5px #fff;
}
.my-tabs{

}
.my-tabs ul{
    display: flex;
    width: 100%;
    background: #fff;

        margin: 0px;
        padding: 0px;
}
.my-tabs ul li{
    flex-grow:1;
    text-align: center;
}
.my-tabs ul li a{
    display: block;
    padding:10px 5px;
    border-bottom: solid 2px #fff;
    color: #666;
}
.my-tabs ul li a:hover{
    color: #222;
    border-bottom: solid 2px #ccc;
}
.my-tabs ul li.active a{

    color: #0099ff;
    border-bottom: solid 2px #0099ff;
}
.tab-content{
    background: #fff;
    width: 100%;
    padding: 15px;
    margin-top: 1px;
}


@media only screen and (max-width: 600px){
    .user-hero-left{
        width: 100%;
    }
    .user-hero-right{
        width: 100%;
    }
}
@media only screen and (min-width: 601px) and (max-width: 993px){
    .user-hero-left{
        width: 33.33333%;
    }
    .user-hero-right{
        width: 66.33333%;
    }
}
@media only screen and (min-width: 993px){

}

</style>


<script type="text/javascript">

	$(document).ready(function() {
		var sidenav = $('#copyme').html();
        $('.copy-that').html(sidenav);
	});

</script>
