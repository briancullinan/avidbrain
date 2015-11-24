<h1>Welcome <span><?php echo $app->newtutor->first_name.' '.$app->newtutor->last_name; ?></span></h1>


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


<style type="text/css">
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
