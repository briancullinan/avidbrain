<div class="new-hero">
    <div class="new-hero-left">
        <img src="<?php echo userphotographs($app->user,$app->actualuser); ?>" />
    </div>
    <div class="new-hero-right">

        <div class="my-tagline"><span><?php echo $app->actualuser->short_description_verified; ?></span></div>

        <div class="user-hero-items">


            <?php
                if(empty($pagename)){
                    $pagename = 'about-me';
                }
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

        </div>

    </div>
</div>


<div class="row fixed-rows">
    <div class="col s12 m4 l3">
        <div class="user-info">

            <?php
                $staticBadges = [];
                $staticBadges[] = (object)array('class'=>'my-name','icon'=>'fa fa-rocket','results'=>short($app->actualuser));
                if(!empty($app->actualuser->hourly_rate)){
                    $staticBadges[] = (object)array('class'=>'hourlyrate','icon'=>'fa fa-dollar','results'=>'$'.numbers($app->actualuser->hourly_rate).'/<span>Hour</span>');
                }
                $staticBadges[] = (object)array('class'=>'location','icon'=>'fa fa-map-marker','results'=>'<a href="/searching/---/'.$app->actualuser->zipcode.'">'.$app->actualuser->city.', '.ucwords($app->actualuser->state_long).'</a>');
                $staticBadges[] = (object)array('class'=>'signup-date','icon'=>'fa fa-calendar','results'=>'Joined '.formatdate($app->actualuser->signup_date));
                if(!empty($app->actualuser->gender) && $app->actualuser->gender!='_empty_'){
                    $staticBadges[] = (object)array('class'=>'gender','icon'=>'fa fa-'.$app->actualuser->gender,'results'=>"I'm ".ucwords($app->actualuser->gender));
                }
                if(!empty($app->actualuser->travel_distance)){
                    $staticBadges[] = (object)array('class'=>'travel-distance','icon'=>'fa fa-car','results'=>'I Will Travel '.$app->actualuser->travel_distance.' Miles');
                }
                if(!empty($app->actualuser->cancellation_policy)){
                    $staticBadges[] = (object)array('class'=>'cancellation-policy','icon'=>'fa fa-clock-o','results'=>$app->actualuser->cancellation_policy.' Hour Cancelation Policy');
                }
                if(!empty($app->actualuser->cancellation_rate)){
                    $staticBadges[] = (object)array('class'=>'cancellation-rate','icon'=>'fa fa-times-circle-o ','results'=>'$'.numbers($app->actualuser->cancellation_rate).' Cancelation Rate');
                }

            ?>
            <?php foreach($staticBadges as $ajaxBadge): ?>
                    <div class="newest-badge <?php echo $ajaxBadge->class; ?>">
                        <span class="newest-badge-icon"><i class="<?php echo $ajaxBadge->icon; ?>"></i></span> <?php echo $ajaxBadge->results; ?>
                    </div>
            <?php endforeach; ?>

            <div class="ajax-badges" id="<?php echo str_replace('/','',$app->actualuser->url); ?>" data-url="<?php echo $app->actualuser->url; ?>"></div>


        </div>
        <div class="right-nav hide-on-large-only" id="copyme">
            <div class="new-user-prompt">

                <div class="new-user-prompt-title">New to AvidBrain?</div>
                <div class="new-user-prompt-copy">Sign up now and start learning in no time!</div>
                <div>
                    <a href="/signup" class="btn blue btn-block">Signup Now</a>
                </div>

            </div>

            <div class="recommendations-title">Recommendations</div>
            <div class="recommendations">
                recommendations
            </div>
            <div class="recommendations">
                recommendations
            </div>
        </div>
    </div>
    <div class="col s12 m8 l7">
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
.my-name{
    font-size: 16px;
    font-weight: bold;
}
.my-tagline{
    text-align: center;
    font-family: 'Quicksand';
    font-weight: 800;
    font-size: 30px;
    left:0;
    right: 0;
    padding-left: 25%;
    position: absolute;
    top: 40%;
    color: #fff;
    transform: translateY(-40%);
}
.my-tagline span:before{
    position: absolute;
    width: 100%;
    height: 100%;
    top:0px;
    background: rgba(0, 0, 0, 0.79);
    content: "";
    z-index: -1;

    -webkit-filter: blur(10px);
    -moz-filter: blur(10px);
    -ms-filter: blur(10px);
    -o-filter: blur(10px);
    filter: blur(10px);
}
.my-tagline span{
    position: relative;
}
.new-hero{
    background: #fff;
    margin-bottom: 15px;
    position: relative;

    background:  url('/images/heros/001.jpg');
    background-size: cover;
    background-position:  right top;
    width: 100%;
    float: left;
    box-sizing: border-box;
    border-bottom: solid 5px #fff;
}
.new-hero-left{
    width: 25%;
    float: left;
    margin-bottom: -6px;
    background: #fff;
    text-align: center;
}
.new-hero-left img{
    max-width: 100%;
    border: solid 5px #fff;
    min-height: 200px;
}
.new-hero-right{
    float: left;
    width: 75%;
}
.theimage-parent{
    position: relative;
    height: 300px;
    background: #fff;
    text-align: center;
    width: 100%;
    overflow: hidden;
    border: solid 5px #fff;
}
.theimage{
    left: 0;  right: 0;
    text-align: center;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    box-sizing: border-box;
}
.theimage img{
    box-sizing: border-box;
    max-width: 100%;
}
.new-user-prompt{
    background: #e1e8ed;
    color: #fff;
    background: #333;
    padding: 10px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    margin-bottom: 15px;
}
.new-user-prompt-title{
    font-weight: bold;
    font-size: 18px;

    color: #d3ed00;
}
.new-user-prompt-copy{
    margin-bottom: 15px;
}
.recommendations-title{
    font-size: 16px;
    font-weight: bold;
}
.recommendations{
    background: #fff;
    padding: 10px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    margin-bottom: 5px;
}

.viewuserviewuser .itstheheader{
    position: relative;
}
.viewuserviewuser h1{
    padding: 10px 15px;
    margin: 0px;
    background: rgba(33, 33, 33, 0.65);
    font-size: 33px;
    color: #fff;
    margin-top: -29px;
}
main .view-user----view-user{
    padding: 0px;
    padding-top: 1px;
    width: 100% !important;
}
.user-hero{
    width: 100%;
    padding: 15px;
    float: left;
}
.row.fixed-rows{
    margin: 0px;
    margin-bottom: 25px;
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
    color: #839e00;
}
.badge-new-user i{
    color: orange;
}
.cancellation-rate i{
    color: #cc0000;
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
    height: 300px;
    overflow: hidden;
    border: solid 5px #fff;
}
.user-hero-items{
    display: flex;
    width: 100%;
    position: absolute;
    bottom: 0px;
    left:0px;
    padding-left: 25%;
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
    font-size: 15px;
    font-weight: bold;
}
.actual-hero{
    background-image:url('http://i.imgur.com/BdPMeg8.jpg');
    background-image: url('/images/heros/001.jpg');
    background-size: cover;
    background-position:  center center;
    width: 100%;
    min-height: 250px;
}
.my-tabs{
    width: 100%;
    margin-bottom: -6px;
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
    background: #efefef;
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

.my-content-block{
    padding: 10px;
    margin-bottom: 15px;
    background: #efefef;
    background: linear-gradient(0deg,#efefef,#fff);
    border: solid 1px #efefef;
}
.my-content-block-title{
    font-size: 22px;
    margin-bottom: 10px;
}
.my-content-block-title a{
    color: #333;
    padding: 0px 5px;
}
.my-content-block-title a:hover{
    background: #ccc;
}
.my-content-block-copy{
    padding: 5px;
    font-size: 14px;
    color: #555;
}
.my-content-block-date{
    text-align: right;
    font-size: 12px;
    color: #999;
}
.myStars{
    padding: 0px 5px;
    float: right;
    display: inline-block;
}
.myStars .fa-star-o{
    color: #ccc;
}
.myStars .fa-star, .starbox .fa-star{
    color: #ee7a00;
}
.starbox{
    padding: 10px;
    margin-bottom: 15px;
}
.starbox .row{
    margin-bottom: 0px;
}


@media only screen and (max-width: 600px){
    .new-hero-left{
        width: 100%;
        background: #fff;
        text-align: center;
    }
    .new-hero-right{
        width: 100%;
    }
    .my-tagline, .user-hero-items{
        position: relative;
    }
    .my-tagline{
        padding: 0px;
        top:auto;
        transform: none;
        padding: 10px;
        font-size: 26px;
    }
    .my-tagline span:before{
        display: none;
    }
    .user-hero-items{
        padding: 0px;
    }
    h1{
        text-align: center;
        font-size: 22px;
    }
    .user-hero-block-title{
        font-size: 12px;
    }
    .theimage-parent{
        height: 360px;
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
