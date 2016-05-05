<div class="homepage-banner homepagerandom-<?php echo rand(1,5); ?>">

    <div class="homepage-box">
        <div class="homepage-copytext">Teach Something. Learn Anything.</div>

        <div class="homepage-search-bar">
            <input type="text" id="homepageselect" class="xxx" placeholder="What Do You Want To Learn?" />
        </div>
    </div>

</div>
<div class="content-blocks">

    <div class="content-block about-avidbrain">
        <div class="content-blocks-title">About MindSpree</div>
        <div class="content-block-item">
            <div class="row">
            	<div class="col s12 m8 l8">
                    <div class="content-blocks-about"><span class="yellow-text">MindSpree</span> is the leader in on-demand tutoring where all of our tutors are both interviewed and background checked.</div>
                    <div class="content-blocks-about-next">
                        With over 2,000 tutors available we’ll have you learning what you want to learn in no time at all.
                    </div>
            	</div>
            	<div class="col s12 m4 l4">
                    <ul class="collection tutor-features">
                        <li class="collection-item">
                            <div class="row">
                            	<div class="col s1 m1 l2 center-align">
                            		<i class="fa fa-check green-text"></i>
                            	</div>
                            	<div class="col s10 m10 l10">
                            		Trusted Instructors
                            	</div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                            	<div class="col s2 m2 l2 center-align">
                            		<i class="fa fa-clock-o blue-text"></i>
                            	</div>
                            	<div class="col s10 m10 l10">
                            		Available When Needed
                            	</div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                            	<div class="col s2 m2 l2 center-align">
                            		<i class="fa fa-dollar green-text"></i>
                            	</div>
                            	<div class="col s10 m10 l10">
                            		Affordable Pricing
                            	</div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                            	<div class="col s2 m2 l2 center-align">
                            		<i class="fa fa-smile-o blue-text"></i>
                            	</div>
                            	<div class="col s10 m10 l10">
                            		Friendly Customer Service
                            	</div>
                            </div>
                        </li>

                        <li class="collection-item">
                            <div class="row">
                            	<div class="col s2 m2 l2 center-align">
                            		<i class="fa fa-calendar green-text"></i>
                            	</div>
                            	<div class="col s10 m10 l10">
                            		Flexible Scheduling
                            	</div>
                            </div>
                        </li>

                    </ul>
            	</div>
            </div>


        </div>
    </div>

    <div class="content-block howitworksnewhomepage">
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
                            <i class="fa fa-circle fa-stack-2x lime-text text-accent-4"></i>
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
                            <i class="fa fa-user fa-stack-1x lime-text text-accent-4"></i>
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
    </div>

    <?php if(isset($app->top)): ?>
    <div class="content-block top-subjects">
        <div class="content-blocks-title">Our Top 15 Tutored Subjects</div>
        <div class="topsubslist">
            <?php $count = count($app->top); foreach($app->top as $key=> $subject): ?>
                <a href="/searching/<?php echo $subject->subject_slug; ?>">
                    <?php echo $subject->subject_name; ?>
                </a><?php if($count!=($key+1)){echo ', ';} ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="content-block featured-tutor">
        <div class="content-blocks-title">Featured Tutor</div>
        <div class="featured-block">

            <div class="row">
            	<div class="col s12 m3 l3">
            		<div class="featured-block-img"><a href="https://www.avidbrain.com/tutors/arizona/scottsdale/323439"><img src="https://www.avidbrain.com/profiles/approved/323439.crop.jpg" class="responsive-img" /></a></div>
                    <div class="featured-block-view">
                        <a href="https://www.avidbrain.com/tutors/arizona/scottsdale/323439">View Full Profile</a>
                    </div>
            	</div>
            	<div class="col s12 m9 l9">
                    <div class="featured-block-name">
                        <a href="https://www.avidbrain.com/tutors/arizona/scottsdale/323439">Keith R.</a>
                    </div>
                    <div class="featured-block-location">
                        Scottsdale Arizona
                    </div>
                    <div class="featured-block-subjects">
                        SAT, ACT, GMAT, GRE, and MCAT, AP Exams, Algebra 1, Calculus, Test Prep
                    </div>
                    <div class="featured-block-about">
                        I have been tutoring/teaching for over 30+ years. Former High School Math &amp; Sciences Teacher. Former college professor in the Math, Chemistry and Business Department. I love to help students succeed. My favorite subjects are standardized exams: SAT, ACT, GMAT, GRE, and MCAT as well as many of the AP exams. I have many former students who have done quite well on their exams and have gone on to top schools.
                    </div>

            	</div>
            </div>

        </div>
    </div>
</div>
