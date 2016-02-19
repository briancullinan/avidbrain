<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="administerform">

    <div class="my-background-check-status">
        <?php if(!empty($app->actualuser->emptybgcheck)): ?>
            <div class="red white-text">I have NOT been background checked</div>
        <?php else: ?>
            <div class="green white-text">I have been background checked <i class="fa fa-check"></i></div>
        <?php endif; ?>
    </div>

    <?php
        $statusArray = array(
            'needs-review'=>'Needs Review',
            'delete-account'=>'Delete Account',
            'refund'=>'Refund',
            'fraud'=>'Fraud',
            'lock'=>'Locked',
            'free-and-clear'=>'Free And Clear'
        );
    ?>

    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Profile Status :</strong>
    	</div>
    	<div class="col s12 m6 l6">
            <select name="administer[status]" class="browser-default">
                <option value="">Select Status</option>
                <?php foreach($statusArray as $key => $value): ?>
                    <option <?php if(isset($app->actualuser->status) && $app->actualuser->status==$key){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>">
                        <?php echo $value; ?>
                    </option>
                <?php endforeach; ?>
            </select>
    	</div>
    </div>




    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Locked Status :</strong>
    	</div>
    	<div class="col s12 m6 l6">
            <select name="administer[lock]" class="browser-default">
                <option value="">Select Lock Status</option>
                <?php foreach(array(NULL=>'Not Locked','lock'=>'Locked') as $key => $value): ?>
                    <option <?php if(isset($app->actualuser->lock) && $key=='lock'){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>">
                        <?php echo $value; ?>
                    </option>
                <?php endforeach; ?>
            </select>
    	</div>
    </div>


    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Email :</strong>
    	</div>
    	<div class="col s12 m6 l6">
    		<?php echo $app->actualuser->email; ?>
    	</div>
    </div>

    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Phone :</strong>
    	</div>
    	<div class="col s12 m6 l6">
    		<?php echo $app->actualuser->phone; ?>
    	</div>
    </div>

    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Is this a tutor from another agency?</strong>
    	</div>
    	<div class="col s12 m6 l6">
            <span>
                <input <?php if(!empty($app->actualuser->anotheragency)){ echo 'checked="checked"';} ?> name="administer[anotheragency]" type="radio" id="anotheragency1" value="yes" />
                <label for="anotheragency1">Yes</label>
            </span>
            <span>
                <input <?php if(empty($app->actualuser->anotheragency)){ echo 'checked="checked"';} ?>name="administer[anotheragency]" type="radio" id="anotheragency2" value="no" />
                <label for="anotheragency2">No</label>
            </span>
    	</div>
    </div>

    <div class="row">
    	<div class="col s12 m6 l6">
    		<strong>Manually Set Rate</strong>
    	</div>
    	<div class="col s12 m6 l6">

            <select name="administer[anotheragency_rate]" class="browser-default">
                <option value="">Select Agency Rate</option>
                <?php foreach(array(10,70,75,80,85,90) as $key => $value): ?>
                    <option <?php if(isset($app->actualuser->anotheragency_rate) && $app->actualuser->anotheragency_rate==$key){ echo 'selected="selected"';} ?> value="<?php echo $key; ?>">
                        <?php echo $value; ?>%
                    </option>
                <?php endforeach; ?>
            </select>
    	</div>
    </div>

	<input type="hidden" name="administer[target]" value="administer"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

</form>

<style type="text/css">
#administerform{
	float: none;
}
</style>

<script type="text/javascript">

	$(document).ready(function() {
		$('#administerform').find('input,radio,button,select').on('change',function(){
			$('#administerform').submit();
		});
	});

</script>
