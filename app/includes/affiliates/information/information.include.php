<h3>
    Your Information
</h3>
<div class="block">
    <form method="post" action="/affiliates/information" class="automatic post-form" id="myinfo">
        <div class="row">
        	<div class="col s12 m6 l6">
                <div class="input">
                    <label for="first_name">First Name</label>
                    <input id="first_name" type="text" name="affiliateinfo[first_name]" value="<?php echo $app->affiliate->first_name; ?>" />
                </div>
        	</div>
        	<div class="col s12 m6 l6">
                <div class="input">
                    <label for="last_name">Last Name</label>
                    <input id="last_name" type="text" name="affiliateinfo[last_name]" value="<?php echo $app->affiliate->last_name; ?>" />
                </div>
        	</div>
        </div>


        <input type="hidden" name="affiliateinfo[target]" value="affiliate"  />
    	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
    </form>

</div>

<h3>
    Affiliate Code
</h3>
<div class="block">
    <div class="row">
    	<div class="col s12 m4 l4">
            <div class="input">
                <label for="mycode">Affiliate Code</label>
                <input id="mycode" type="text" readonly="readonly" value="<?php echo $app->affiliate->mycode; ?>" />
            </div>
    	</div>
    	<div class="col s12 m4 l4">
            <div class="input">
                <label for="studentsignup">Student Signup</label>
                <input onclick="select();" id="studentsignup" type="text" value="<?php echo $app->dependents->DOMAIN; ?>/signup/student/<?php echo $app->affiliate->mycode; ?>" />
            </div>
    	</div>
        <div class="col s12 m4 l4">
            <div class="input">
                <label for="tutorsignup">Tutor Signup</label>
                <input onclick="select();" type="text" id="tutorsignup" value="<?php echo $app->dependents->DOMAIN; ?>/signup/tutor/<?php echo $app->affiliate->mycode; ?>" />
            </div>
    	</div>
    </div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$('.automatic input, .automatic textarea').on('change',function(){
			var closestform = '#'+$(this).closest('form').attr('id');
            $(closestform).submit();
		});
	});

</script>
