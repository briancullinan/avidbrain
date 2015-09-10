<form class="tutor-search-form" id="searchform" method="post" action="/tutors">
	
	<legend>
		Find A Tutor
	</legend>

    <?php if(isset($app->searching->category)): ?>
    <div class="input-field">

      <input type="text" name="search[category]" id="search" class="validate searchbox" value="<?php if(isset($app->searching->category)){ echo $app->searching->category;} ?>" />
      <label for="search">Category</label>

    </div>
    <?php else: ?>
    <div class="input-field">

      <input type="text" name="search[search]" id="search" class="validate searchbox" value="<?php if(isset($app->searching->search)){ echo $app->searching->search;} ?>" />
      <label for="search">Subject</label>

    </div>
    <?php endif; ?>

    <div class="input-field">

        <input type="text" name="search[zipcode]" maxlength="5" id="zipcode" class="validate" value="<?php if(isset($app->searching->zipcode)){ echo $app->searching->zipcode;} ?>" />
        <label for="zipcode">Zip Code</label>

    </div>

    <div class="input-field">
	    
	    <?php
		    $distance = array(15,20,50,100,200,500,1000,5000);
		    //$searchDistance = 15;
		?>

        <select name="search[distance]" id="distance" class="browser-default">
			<option value="" disabled selected>Distance</option>
			<?php foreach($distance as $key=>$value): ?>
				<option <?php if(isset($app->searching->distance) && $app->searching->distance==$value){ echo ' selected="selected" ';} ?> value="<?php echo $value; ?>">
					<?php echo $value; ?> Miles
				</option>
			<?php endforeach; ?>
		</select>

    </div>
    
    

    <div class="input-field advanced-blocks <?php if(isset($app->advancedsearch) && $app->advancedsearch=="true"){}else{ echo 'advanced-items'; } ?>">

      <input type="text" name="search[name]" id="name" class="validate" value="<?php if(isset($app->searching->name)){ echo $app->searching->name;} ?>" />
      <label for="name">Name</label>

    </div>

    <div class="input-field advanced-blocks <?php if(isset($app->advancedsearch) && $app->advancedsearch=="true"){}else{ echo 'advanced-items'; } ?>">
        
	    <?php $distance = array('Male','Female'); ?>

        <select name="search[gender]" id="gender" class="browser-default">
			<option value="" >No Preference</option>
			<?php foreach($distance as $key=>$value): ?>
				<option <?php if(isset($app->searching->gender) && $app->searching->gender==$value){ echo ' selected="selected" ';} ?> value="<?php echo $value; ?>"><?php echo $value; ?> </option>
			<?php endforeach; ?>
		</select>

    </div>

    <div class="input-field input-range advanced-blocks <?php if(isset($app->advancedsearch) && $app->advancedsearch=="true"){}else{ echo 'advanced-items'; } ?>">

        <div class="input-label">Price Range</div>

        <div class="pricerange slidebox"></div>
        <div class="slidebox-inputs">
            <input type="text" name="search[pricerangeLower]" id="pricerangeLower" data-value="<?php if(isset($app->searching->pricerangeLower)){ echo $app->searching->pricerangeLower; }else{ echo '15';} ?>" />
            <input type="text" name="search[pricerangeUpper]" id="pricerangeUpper" data-value="<?php if(isset($app->searching->pricerangeUpper)){ echo $app->searching->pricerangeUpper; }else{ echo '65';} ?>" />
        </div>


    </div>
    
	<div class="switch advanced-switch">
		<div class="advanced-switch-text">
		<span><?php if(isset($app->advancedsearch) && $app->advancedsearch=="true"){ echo 'Advanced'; }else{ echo 'Basic';} ?></span> Search
		</div>
		<label>
			<input name="search[advanced]" type="checkbox" <?php if(isset($app->advancedsearch) && $app->advancedsearch=="true"){ echo ' checked="checked" '; } ?>>
			<span class="lever"></span>
		</label>
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