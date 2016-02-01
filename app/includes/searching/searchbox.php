<?php

    $doihavazipcode = $app->getCookie('getzipcode');

?>

<form method="post" action="/searching/" class="get-searching">

    <input data-default="searching" type="hidden" name="searching[target]" value="searching"  />
	<input data-default="<?php echo $csrf_token; ?>" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

    <div class="searching-container">
        <label for="subject">Subject</label>
        <div class="searching-box" id="search-subject">
            <input id="subject" type="text" name="searching[subject]" <?php if(isset($app->cachedSubjectQuery->subject_name)){ echo 'value="'.$app->cachedSubjectQuery->subject_name.'"';} ?> />
        </div>
    </div>

    <?php
        $location = NULL;
        $zipcode = NULL;
        if(isset($app->cachedZipcode)){
            $location = $app->cachedZipcode->city.', '.$app->cachedZipcode->state_long;
            $zipcode = $app->cachedZipcode->zipcode;
        }
    ?>

    <div class="row nomargins">
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="location">City, State / Zipcode</label>
                <div class="searching-box">
                    <input id="location" type="text" name="searching[location]" value="<?php echo $location; ?>" />
                </div>
            </div>
            <input id="zipcodeactual" type="hidden" name="searching[zipcodeactual]" class="zipcodeactual" value="<?php echo $zipcode; ?>"  />
    	</div>
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="distance">Distance</label>
                <div class="searching-box">
                    <select data-default="50" id="distance" class="browser-default" name="searching[distance]">
                        <?php foreach(array(5,20,50,100,500,1000,5000,10000) as $distance): ?>
                            <option <?php if(isset($app->queries->distance) && $app->queries->distance==$distance){echo 'selected="selected"';}elseif(empty($app->queries->distance) && $distance==50){echo 'selected="selected"';} ?> value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
    	</div>
    </div>

    <div class="searching-container">
        <label for="name">Tutor's Name</label>
        <div class="searching-box">
            <input id="name" type="text" name="searching[name]" <?php if(isset($app->queries->name)){ echo 'value="'.$app->queries->name.'"';} ?> />
        </div>
    </div>

    <div class="searching-container">
        <label for="gender">Gender</label>
        <div class="searching-box">
            <select data-default="No Preference" id="gender" class="browser-default" name="searching[gender]">
                <?php foreach(array('No Preference'=>'','Male'=>'male','Female'=>'female',) as $key=> $gender): ?>
                    <option <?php if(isset($app->queries->gender) && $app->queries->gender==$gender){echo 'selected="selected"';} ?> value="<?php echo $gender; ?>">
                        <?php echo $key; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row nomargins">
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="pricelow">Price Range Low</label>
                <div class="searching-box">
                    <select data-default="0" id="pricelow" class="browser-default" name="searching[pricelow]">
                        <?php foreach(range(0,1000,10) as $pricerange): ?>
                            <option <?php if(isset($app->queries->pricelow) && $app->queries->pricelow==$pricerange){echo 'selected="selected"';} ?> value="<?php echo $pricerange; ?>">
                                $<?php echo numbers($pricerange); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
    	</div>

    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="pricehigh">Price Range High</label>
                <div class="searching-box">
                    <select data-default="200" id="pricehigh" class="browser-default" name="searching[pricehigh]">
                        <?php foreach(range(0,1000,10) as $pricerangehigh): ?>
                            <option <?php if(isset($app->queries->pricehigh) && $app->queries->pricehigh==$pricerangehigh){echo 'selected="selected"';}elseif(empty($app->queries->pricehigh) && $pricerangehigh==200){ echo 'selected="selected"';} ?> value="<?php echo $pricerangehigh; ?>">
                                $<?php echo numbers($pricerangehigh); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
    	</div>
    </div>

    <div class="searching-container hidden">
        <label for="page">Page</label>
        <div class="searching-box">
            <input data-default="1" id="page" type="hidden" name="searching[page]" <?php if(isset($app->queries->page)){ echo 'value="'.$app->queries->page.'"';} ?> />
        </div>
    </div>

    <div class="searching-container hidden">
        <label for="sort">Sort Order</label>
        <div class="searching-box">
            <input data-default="last_active" id="sort" type="hidden" name="searching[sort]" value="<?php if(isset($app->queries->sort)){ echo $app->queries->sort; } ?>" />
        </div>
    </div>

    <input id="subjectauto" type="hidden" name="searching[subjectauto]" <?php if(isset($app->queries->subject_slug)){ echo 'value="'.$app->queries->subject_slug.'"';} ?> />

    <br>
    <div class="row">
    	<div class="col s6 m6 l6">
            <button class="btn search-button" type="submit">
                <i class="fa fa-search"></i> Search
            </button>
    	</div>
    	<div class="col s6 m6 l6">
    		<button class="btn form-reset grey" type="button">Reset Form</button>
    	</div>
    </div>

</form>
