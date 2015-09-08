<?php if(isset($app->navtitle)): ?>
<div class="sub-navigation-title">
	<a <?php if($app->request->getPath()==$app->navtitle->slug){ echo ' class="active" ';} ?> href="<?php echo $app->navtitle->slug; ?>">
		<?php if($app->request->getPath()==$app->navtitle->slug){ echo ' <i class="fa fa-chevron-right"></i> ';} ?>
		<?php echo $app->navtitle->text; ?>
	</a>
</div>
<?php endif; ?>

<div class="sidebarsearch">
	
	<form class="tutor-search-form" id="searchform" method="post" action="/jobs">
	
		<legend>
			Find A Tutoring Job
		</legend>
	
	    <div class="input-field">
	
	      <input type="text" name="searchingforjobs[search]" id="search" class="validate searchbox" value="<?php if(isset($app->searchingforjobs->search)){ echo $app->searchingforjobs->search;} ?>" />
	      <label for="search">Subject</label>
	
	    </div>
	
	    <div class="input-field">
	
	        <input type="text" name="searchingforjobs[zipcode]" maxlength="5" id="zipcode" class="validate" value="<?php if(isset($app->searchingforjobs->zipcode)){ echo $app->searchingforjobs->zipcode;} ?>" />
	        <label for="zipcode">Zip Code</label>
	
	    </div>
	
	    <div class="input-field">
		    
		    <?php
			    $distance = array(15,20,50,100,200,500,1000,5000);
			?>
	
	        <select name="searchingforjobs[distance]" id="distance" class="browser-default">
				<option value="" disabled selected>Distance</option>
				<?php foreach($distance as $key=>$value): ?>
					<option <?php if(isset($app->searchingforjobs->distance) && $app->searchingforjobs->distance==$value){ echo ' selected="selected" ';} ?> value="<?php echo $value; ?>">
						<?php echo $value; ?> Miles
					</option>
				<?php endforeach; ?>
			</select>
	
	    </div>
	    
	    
	    <div class="input-field left-align">
		    <button type="submit" class="btn btn-s waves-effect "><i class="fa fa-search"></i> Search</button>
	    </div>
	    <div class="hr"></div>
	    <div class="reset-form">
		      <input type="checkbox" class="filled-in" id="filled-in-box" />
		      <label for="filled-in-box">Reset Form</label>
	    </div>
	    
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		<input type="hidden" name="search[target]" value="search">
	
	</form>
	
</div>