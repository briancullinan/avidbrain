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
	
	        <input type="text" name="searchingforjobs[zipcode]" maxlength="5" id="zipcode" class="validate" value="<?php if(isset($app->searching->zipcode)){ echo $app->searching->zipcode;}elseif(empty($app->searching->zipcode) && isset($app->mylocation->zipcode)){ echo $app->mylocation->zipcode; } ?>" />
	        <label for="zipcode">Zip Code</label>
	
	    </div>
	    
	    <div class="input-field input-range">
	
	        <div class="input-label">Price Range</div>
	
	        <div class="pricerange slidebox"></div>
	        <div class="slidebox-inputs">
	            <input type="text" name="searchingforjobs[pricerangeLower]" id="pricerangeLower" data-value="<?php if(isset($app->searchingforjobs->pricerangeLower)){ echo $app->searchingforjobs->pricerangeLower; }else{ echo '15';} ?>" />
	            <input type="text" name="searchingforjobs[pricerangeUpper]" id="pricerangeUpper" data-value="<?php if(isset($app->searchingforjobs->pricerangeUpper)){ echo $app->searchingforjobs->pricerangeUpper; }else{ echo '65';} ?>" />
	        </div>	
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