<h1>Welcome Back <span><?php echo $app->newtutor->first_name.' '.$app->newtutor->last_name; ?></span></h1>
<p>Thank you for signing up to become a tutor with AvidBrain. We have recently updated the signup process to be easier and words go here.</p>

<p>Now that we've got the easy stuff out of the way, lets proceed on to the next couple steps.</p>

<?php
    function isitset($var=NULL){
        if(isset($var) && !empty($var)){
            return $var;
        }
    }
    //$app->newtutor
?>

<div class="row">
	<div class="col s12 m4 l4">

        <div class="block">
            <div class="title">
                About Yourself
            </div>

            <form method="post" class="form-post auto-magic" action="/signup/tutor" id="aboutme">
                <div class="new-inputs">
                    <div class="input-wrapper" id="aboutme_zipcode"><input type="text" name="aboutme[zipcode]" placeholder="Your Zip Code" maxlength="5" <?php echo 'value="'.isitset($app->newtutor->zipcode).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="aboutme_short_description"><input type="text" name="aboutme[short_description]" placeholder="Write a short description about yourself" <?php echo 'value="'.isitset($app->newtutor->short_description).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="aboutme_personal_statement"><textarea class="materialize-textarea" name="aboutme[personal_statement]" placeholder="Write an in-depth description about yourself and why / what you tutor"><?php echo isitset($app->newtutor->personal_statement); ?></textarea></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="aboutme_hourly_rate"><input type="text" name="aboutme[hourly_rate]" placeholder="What is your hourly rate?" <?php echo 'value="'.isitset($app->newtutor->hourly_rate).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>What is your gender?</label>
                    <div class="input-wrapper-select" id="aboutme_gender">
                        <select name="aboutme[gender]" class="browser-default">
                            <?php
                                $gender = isitset($app->newtutor->gender);

                                foreach(array(NULL=>"Don't Show My Gender",'male'=>'Male','female'=>'Female') as $key => $value){
                                    $activate = NULL;
                                    if(isset($gender) && $gender==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';//isitset($app->newtutor->hourly_rate)
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="aboutme[target]" value="aboutme"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>
	</div>

    <div class="col s12 m4 l4">

        <div class="block">
            <div class="title">
                Tutoring Information
            </div>

            <form method="post" class="form-post auto-magic" action="/signup/tutor" id="xxx">
                <div class="new-inputs">
                    <label>How far are you willing to travel?</label>
                    <div class="input-wrapper-select" id="tutoringinfo_travel_distance">
                        <select name="tutoringinfo[travel_distance]" class="browser-default">
                            <?php
                                $travel_distance = isitset($app->newtutor->travel_distance);
                                foreach(array(0,5,10,20,25,50,100) as $key => $value){
                                    $activate = NULL;
                                    if(isset($travel_distance) && $travel_distance==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.' Miles</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="tutoringinfo_xxx"><input type="text" name="tutoringinfo[xxx]" placeholder="xxx" /></div>
                </div>

                <input type="hidden" name="tutoringinfo[target]" value="tutoringinfo"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>
	</div>

    <div class="col s12 m4 l4">

        <div class="block">
            <div class="title">
                About Yourself
            </div>

            <form method="post" class="form-post" action="/signup/tutor" id="xxx">
                <div class="new-inputs">
                    <div class="input-wrapper" id="li_email"><input type="text" name="xxx[xxx]" placeholder="xxx" /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="li_email"><input type="text" name="xxx[xxx]" placeholder="xxx" /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="li_email"><input type="text" name="xxx[xxx]" placeholder="xxx" /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="li_email"><input type="text" name="xxx[xxx]" placeholder="xxx" /></div>
                </div>

                <div class="new-inputs">
                    <div class="input-wrapper" id="li_email"><input type="text" name="xxx[xxx]" placeholder="xxx" /></div>
                </div>

                <input type="hidden" name="xxx[target]" value="xxx"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>

        </div>
	</div>

</div>


<style type="text/css">
.newsignup main .container{
    background: rgba(255, 255, 255, 0.9);
    padding-top: 0px;
    margin-top: 100px;
    padding: 20px;
}
.newsignup main .container h1{
    color: #000;
    text-shadow: none;
}
.newsignup .header-nav li{
    display: none;
}
.newsignup .header-nav li.show{
    display: block;
}
.newsignup .header-nav li.show a{

    color: #96FF00;
}
</style>


<script type="text/javascript">

	$(document).ready(function() {
		$('.right-info').html('<ul class="header-nav"><li class="show"><a href="/logout">Log Out</a></li></ul>');

        $('.auto-magic input, .auto-magic textarea, .auto-magic select').on('change',function(){
			var myformid = '#'+$(this).closest('form').attr('id');
			$(myformid).submit();
		});
	});

</script>
