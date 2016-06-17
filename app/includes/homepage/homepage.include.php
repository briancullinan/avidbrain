<div class="homepage-banner">


    <div class="homepage-box">
        <div class="homepage-copytext">Teach Something. Learn Anything.</div>
        <div class="homepage-copytext-extra">

        <p>  MindSpree is committed to education and student success by connecting students with their perfect tutor! As the leader in on-demand tutoring all of our tutors are both
          interviewed and background checked. We have over 2,000 tutors to help you reach your learning goals!
        </p>
        <!-- <p>
          With over 2,000 tutors available we’ll have you reaching your learning goals in no time at all.
          MindSpree works hard behind the scenes so our tutors can focus on their students. Our decisions
           reflect an understanding about what is most important - student success and tutor happiness.
         </p> -->
        </div>

        <!-- <div class="homepage-search-bar">
            <form method="post" action="/searching/" id="homepagesearch">
                <input type="text" id="homepageselect" placeholder="What Do You Want To Learn?" />
            </form>
        </div> -->
    </div>
    <div class="video">
        <video loop="loop" preload="auto" autoplay="true" class="video-playing hide-on-small-only">
            <source src="/videos/main-intro.mp4" type='video/mp4'>
            <source src="/videos/main-intro.m4v" type='video/mp4'>
            <source src="/videos/main-intro.webm" type='video/webm'>
        </video>

        <div class="slider hide-on-med-and-up">

    		<ul class="slides">
    			<?php echo $app->slider; ?>
    		</ul>
        </div>
	  </div>

</div>
<div class="hide-on-small-only">
    <div class=" menu-avidbrain ">
      <UL class="home-searching-links">
          <li class="collection-item">
              <a href="/subjects">
                Available Subjects
              </a>
          </li>

          <li class="collection-item">
              <a href="/searching">
                Trusted Instructors
              </a>
          </li>

          <li class="collection-item">
              <a href="/searching">
                Flexible Schedules
              </a>
          </li>

          <li class="collection-item">
              <a href="/searching">
                Affordable Prices
              </a>
          </li>
          <li class="collection-item">
              <a href="/jobs">
                Tutoring Gigs
              </a>
          </li>

      </UL>
    </div>
</div>


    <div class="content-block testimonials">
        <div class="content-blocks-title">Affiliate Program</div>

        <div class="quote-container3">
            <div class="row">

              <div class="col s12 m4 l4 align-center">
                  <div class="user-photograph"><a href="/signup/affiliate"><img src="/images/icons/tutoring.jpg" /></a></div>
          	 </div>
              <div class="col s12 m8 l8">
                    <div class="quote-user2">
                      <!-- <span class="open-quote">&ldquo;</span> -->
                        <p>
                              Earn easy money working part-time from the comfort and convenience of your home.
                              For every Tutor or Student that signs up with you PROMO CODE and completes a session, you get $20!
                              We offer GREAT PROMOTIONS to make earning easier!
                              Every Student that signs up with your PromoCode gets $30 off their first tutoring session.
                              Every Tutor that you refer starts at the HIGHEST take home rate of 70% when they use your PromoCode.
                              Student and Tutor signup is FREE!
                        </p>
                           <a href="/signup/affiliate" > START NOW! </a>


                    </div>
              </div>
            </div>
        </div>

    <hr class="testimony_line"/>
    <hr class="testimony_line1"/>


    <?php if(isset($app->cachedTestimonial)): ?>
        <div class="content-block testimonials">
            <div class="content-blocks-title">Student Testimonials</div>

            <div class="quote-container3">
                <div class="row">
                	<div class="col s12 m8 l8">
                        <div class="quote-user2">
                          <!-- <span class="open-quote">&ldquo;</span> -->
                            <div class="actual-quote1"><?php echo $app->cachedTestimonial->quote; ?></div>
                            <div class="actual-quote-from1"><?php echo $app->cachedTestimonial->from; ?></div>
                        </div>
                	</div>
                    <div class="col s12 m4 l4 align-center">
                        <div class="user-photograph"><a href="<?php echo $app->cachedTestimonial->link; ?>"><img src="<?php echo $app->cachedTestimonial->img; ?>" /></a></div>
                        <div class="featured-name"><a href="<?php echo $app->cachedTestimonial->link; ?>"><?php echo $app->cachedTestimonial->name; ?></a></div>
                	</div>
                </div>
            </div>

    <?php endif; ?>

    <hr class="testimony_line"/>
    <hr class="testimony_line1"/>



        <div class="content-blocks-title">Recommended Tutor</div>
        <div class="featured-block">

            <div class="row">
            	<div class="col s12 m4 l4">
            		<div class="user-photograph">
                        <a href="<?php echo $app->cachedTOPTUTOR->url; ?>">
                            <img src="<?php echo $app->cachedTOPTUTOR->img; ?>" class="responsive-img" />
                        </a>
                    </div>

            	</div>
            	<div class="col s12 m8 l8">
                    <div class="featured-block-name">
                        <a href="<?php echo $app->cachedTOPTUTOR->url; ?>">
                            <?php echo $app->cachedTOPTUTOR->name; ?>
                        </a>
                    </div>
                    <div class="featured-block-location">
                        <?php echo ucwords($app->cachedTOPTUTOR->city); ?> <?php echo ucwords($app->cachedTOPTUTOR->state_long); ?>
                    </div>
                    <div class="featured-block-subjects">
                        <?php
                            $count = count($app->cachedTOPTUTOR->mysubjects);
                            foreach($app->cachedTOPTUTOR->mysubjects as $key=> $subject){
                                echo $subject->subject_name;if($count!=($key+1)){ echo ', ';}
                            }
                        ?>
                    </div>
                    <div class="featured-block-about">
                        <?php echo truncate($app->cachedTOPTUTOR->personal_statement_verified,600); ?>
                    </div>

            	</div>
            </div>

        </div>
    </div>

    <!-- <?php if(isset($app->top)): ?>
    <div class="content-block top-subject-list">
        <div class="content-blocks-title">Our Top 15 Tutored Subjects</div>
        <div class="topsubslist">
            <?php $count = count($app->top); foreach($app->top as $key=> $subject): ?>
                <a href="/searching/<?php echo $subject->subject_slug; ?>">
                    <?php echo $subject->subject_name; ?>
                <?php if($count!=($key+1)){echo '<span>, </span>';} ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?> -->


    <div class="content-block featured-on">
        <div class="content-blocks-title">Featured On</div>
        <div class="featured-logos">
            <?php echo $app->featuredlogos; ?>
        </div>
    </div>

</div>




    <!-- <div class="content-block howitworksnewhomepage">
        <div class="content-blocks-title">How It Works</div>
        <div class="xxx">
            <div class="row">
            	<div class="col s12 m4 l4">
            		<div class="howitworks-homepage-img">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x light-blue-text text-darken-4"></i>
                            <i class="fa fa-search fa-stack-1x"></i>
                        </span>
                    </div>
            		<div class="howitworks-homepage-title">
                        Discover Amazing Tutors
                    </div>
                    <div class="howitworks-homepage-text">
                        Get help in any subject you can think of. We have instructors in both academic and non- academic subjects.
                    </div>
            	</div>
            	<div class="col s12 m4 l4">
                    <div class="howitworks-homepage-img">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x light-blue-text text-darken-4"></i>
                            <i class="fa fa-check fa-stack-1x "></i>
                        </span>
                    </div>
            		<div class="howitworks-homepage-title">
                        Hire a Tutor
                    </div>
                    <div class="howitworks-homepage-text">
                        Connect with tutors, confirm tutoring sessions, and pay - all through MindSpree’s trusted services.
                    </div>
            	</div>
            	<div class="col s12 m4 l4">
                    <div class="howitworks-homepage-img">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x light-blue-text text-darken-4"></i>
                            <i class="fa fa-user fa-stack-1x "></i>
                        </span>
                    </div>
            		<div class="howitworks-homepage-title">
                        Learn
                    </div>
                    <div class="howitworks-homepage-text">
                        See the progress in any subject you choose to learn.
                    </div>
            	</div>
            </div>

            <div class="learn-more-about"><a href="/how-it-works">Learn more</a> about tutoring on MindSpree and show your students how well you can teach them.</div>

        </div>
    </div> -->
