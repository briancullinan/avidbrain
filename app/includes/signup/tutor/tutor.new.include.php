<h1>Welcome <span><?php echo $app->newtutor->first_name.' '.$app->newtutor->last_name; ?></span></h1>


<div class="row">
	<div class="col s12 m4 l2 signupsidebar">
        <div class="signup-title-text">Steps</div>
		<div class="box signuporder">
            <div class="complete">Step 1 <span> Signup <i class="fa fa-check green-text"></i></span></div>
            <?php if(isset($app->newtutor->aboutme)): ?>
            <div class="complete"><a href="#aboutyourself">Step 2 <span> About Yourself <i class="fa fa-check green-text"></i></span></a></div>
            <?php else: ?>
            <div><a href="#aboutyourself">Step 2 <span> About Yourself </a></div>
            <?php endif; ?>

            <?php if(isset($app->newtutor->my_resume)): ?>
            <div class="complete"><a href="#uploadresume">Step 3 <span> Upload Resume <i class="fa fa-check green-text"></i></span></a></div>
            <?php else: ?>
            <div><a href="#uploadresume">Step 3 <span> Upload Resume</a> </div>
            <?php endif; ?>

            <?php if(isset($app->newtutor->tutorinfo)): ?>
            <div class="complete"><a href="#tutoringinformation">Step 4 <span> Tutoring Info <i class="fa fa-check green-text"></i></span></a></div>
            <?php else: ?>
            <div><a href="#tutoringinformation">Step 4 <span> Tutoring Info </a></div>
            <?php endif; ?>

            <?php if(isset($app->newtutor->upload)): ?>
            <div class="complete"><a href="#uploadaphoto">Step 5 <span> Upload Photo <i class="fa fa-check green-text"></i></span></a></div>
            <?php else: ?>
            <div><a href="#uploadaphoto">Step 5 <span> Upload Photo </a></div>
            <?php endif; ?>

            <?php if(isset($app->newtutor->mysubs_art) ||
					isset($app->newtutor->mysubs_business) ||
					isset($app->newtutor->mysubs_collegeprep) ||
					isset($app->newtutor->mysubs_computer) ||
					isset($app->newtutor->mysubs_elementaryeducation) ||
					isset($app->newtutor->mysubs_english) ||
					isset($app->newtutor->mysubs_games) ||
					isset($app->newtutor->mysubs_history) ||
					isset($app->newtutor->mysubs_language) ||
					isset($app->newtutor->mysubs_math) ||
					isset($app->newtutor->mysubs_music) ||
					isset($app->newtutor->mysubs_science) ||
					isset($app->newtutor->mysubs_specialneeds) ||
					isset($app->newtutor->mysubs_sportsandrecreation) ||
					isset($app->newtutor->mysubs_testpreparation)): ?>
            <div class="complete"><a href="#addsubjectstutorteach">Step 6 <span> Add Subjects <i class="fa fa-check green-text"></i></span></a></div>
            <div class="complete"><a href="#submitapplication">Step 7 <span> Submit Application  </span></a></div>
            <?php else: ?>
            <div><a href="#addsubjectstutorteach">Step 6 <span> Add Subjects</a> </div>
            <?php endif; ?>
        </div>
	</div>
	<div class="col s12 m8 l10 signupcontent">
        <div class="signup-steps">
            <?php
                //printer($app->newtutor);
                include('signup-steps-step1.php');

                if(isset($app->newtutor->aboutme)){
                    include('signup-steps-step2.php');

                        if(!empty($app->newtutor->my_resume)){
                            include('signup-steps-step3.php');

                            if(isset($app->newtutor->tutorinfo)){
                                include('signup-steps-step4.php');

                                if(isset($app->newtutor->upload)){
                                    include('signup-steps-step5.php');

                                    if(
                                        isset($app->newtutor->mysubs_art) ||
                						isset($app->newtutor->mysubs_business) ||
                						isset($app->newtutor->mysubs_collegeprep) ||
                						isset($app->newtutor->mysubs_computer) ||
                						isset($app->newtutor->mysubs_elementaryeducation) ||
                						isset($app->newtutor->mysubs_english) ||
                						isset($app->newtutor->mysubs_games) ||
                						isset($app->newtutor->mysubs_history) ||
                						isset($app->newtutor->mysubs_language) ||
                						isset($app->newtutor->mysubs_math) ||
                						isset($app->newtutor->mysubs_music) ||
                						isset($app->newtutor->mysubs_science) ||
                						isset($app->newtutor->mysubs_specialneeds) ||
                						isset($app->newtutor->mysubs_sportsandrecreation) ||
                						isset($app->newtutor->mysubs_testpreparation)
                					){

                                        include('signup-steps-step6.php');
                                    }

                                }

                            }

                        }
                }
            ?>
        </div>
	</div>
</div>


<style type="text/css">

.signuporder{
	color: #ccc;
}
.signuporder .complete{
	color: #111;
}
.signuporder span{
    color: #999;
    padding: 2px;
    text-align: right;
    display: inline-block;

    font-size: 12px;
}
.signup-title-text{
    font-size: 22px;
}
.signup-title-text span{
    color: #008cff;
}
.signup-required{
    color: red;
}
.require-check{
    padding: 10px;
}
.pageids{
	margin: 0px;
	padding: 0px;
	width: 100%;
	height: 20px;
	float: left;
	background: transparent;
}
</style>

<script type="text/javascript">
    function showmehideme(data,show,hide){
        var datastatus = $(data).attr('data-status');
        if(datastatus=='closed'){
            $(data).attr('data-status','open');
            eval(show);
        }
        else if(datastatus=='open'){
            $(data).attr('data-status','closed');
            eval(hide);
        }
    }
	$(document).ready(function() {


		// var options = [
		// 	{selector: '.signuporder', offset: 200, callback: 'alesdf' },
		// 	{selector: '.signuporder-more', offset: 200, callback: 'alert("middle")' },
		// ];
		// Materialize.scrollFire(options);


		$('.start-background-check').on('click',function(){
            var target = '.the-background-check-steps';
			showmehideme(this,"$('"+target+"').slideDown();","$('"+target+"').slideUp();");
		});
        $('.activate-subject label').on('click',function(){
            var status = $(this).attr('data-status');
            var thisfor = $(this).attr('for');
            if(status=='closed'){
                $(this).attr('data-status','open');
                $(this).parent().find('.input-wrapper').removeClass('hide');
                $(this).parent().find('.input-wrapper textarea').focus();
                $(this).parent().find('.remove').remove();
            }
            else if(status=='open'){
                $(this).attr('data-status','closed');
                $(this).parent().find('.input-wrapper').addClass('hide');
                $(this).parent().append('<div class="remove"><input type="hidden" name="mysubjects['+thisfor+'][remove]" value="remove" /></div>');
            }
        });
	});

</script>
