<?php
    $sql = " SELECT subject_slug,parent_slug,subject_name,sortorder FROM avid___user_subjects WHERE email = :email AND status = 'verified' ORDER BY sortorder ASC  LIMIT 10";
    $prepare = array(':email'=>$searchResults->email);
    $verified = $app->connect->executeQuery($sql,$prepare)->fetchAll();

    $sql = " SELECT subject_slug,parent_slug,subject_name,sortorder FROM avid___user_subjects WHERE email = :email AND status != 'verified' ORDER BY sortorder ASC LIMIT 10";
    $prepare = array(':email'=>$searchResults->email);
    $notverified = $app->connect->executeQuery($sql,$prepare)->fetchAll();

?>
<div class="imatutor">
    <div class="row no-bottom">
        <div class="col s12 m4 l3 center-align">
            <div class="image">
                <a href="<?php echo $searchResults->url; ?>">
                    <img src="<?php echo userphotographs($app->user,$searchResults); ?>" />
                </a>
            </div>
            <div class="user-name">
                <a href="<?php echo $searchResults->url; ?>"><?php echo short($searchResults); ?></a>
            </div>

            <?php if(isset($searchResults->city)): ?>
            <div class="tutor-location">
                <i class="mdi-action-room"></i>
                <a href="/tutors/<?php echo $searchResults->state_slug; ?>/<?php echo $searchResults->city_slug; ?>"><?php echo $searchResults->city; ?></a>, <a href="/tutors/<?php echo $searchResults->state_slug; ?>"><?php echo ucwords($searchResults->state_long); ?></a>
            </div>
            <?php endif; ?>
            <?php if(isset($searchResults->distance)): ?>
            <div class="tutor-distance">
                <?php echo number_format(round($searchResults->distance), 0, '', ','); ?> Miles Away
            </div>
            <?php endif; ?>

            <div class="my-rate <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo 'my-rate-negotiableprice';} ?>">
                $<?php echo numbers($searchResults->hourly_rate,1); ?><span>/ Hour <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo '<i class="fa fa-asterisk"></i>';} ?></span>
            </div>

        </div>
        <div class="col s12 m8 l9">
            <div class="row no-bottom">
                <div class="col s12 m12 l8 my-info">
                    <?php if(isset($searchResults->short_description_verified)): ?>
                        <div class="im-a-tutor-short"><a href="<?php echo $searchResults->url; ?>"><?php echo $searchResults->short_description_verified; ?></a></div>
                    <?php endif; ?>
                    <?php if(isset($searchResults->personal_statement_verified)): ?>
                        <div class="im-a-tutor-long"><?php echo truncate($searchResults->personal_statement_verified,400); ?></div>
                    <?php endif; ?>


                    <div class="my-subject-container">
                        <?php if(isset($verified[0])): ?>
                            <div><strong>My Subjects</strong></div>
                            <?php
                                $count = count($verified);
                                foreach($verified as $key=> $subject){
                                    echo $subject->subject_name.', ';
                                }
                            ?>
                        <?php endif; ?>

                        <?php if(isset($notverified[0])): ?>
                            <span class="un-verified">
                                <?php
                                    $count = count($notverified);
                                    foreach($notverified as $key=> $subject){
                                        echo $subject->subject_name;
                                        if($key!=($count-1)){ echo ', ';}
                                    }
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="col s12 m12 l4">
                    <a class="btn btn-block blue" href="<?php echo $searchResults->url; ?>">View Profile</a>
                    <a class="btn btn-block" href="<?php echo $searchResults->url; ?>/send-message">Send Message</a>
                    <div class="badges">


                        <div class="ajax-badges" id="<?php echo str_replace('/','',$searchResults->url); ?>" data-url="<?php echo $searchResults->url; ?>"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
