
<?php

    $doihavazipcode = $app->getCookie('getzipcode');
?>

What are you looking for?

<div class="get-searching">
    <div class="searching-container">
        <label for="subject">Subject</label>
        <div class="searching-box">
            <input id="subject" type="text" name="searching[subject]" />
        </div>
    </div>

    <div class="searching-container">
        <label for="zipcode">Zipcode</label>
        <div class="searching-box">
            <input id="zipcode" type="text" name="searching[zipcode]" <?php if(!empty($doihavazipcode)){ echo 'value="'.$doihavazipcode.'"';} ?> />
        </div>
    </div>

    <div class="searching-container">
        <label for="distance">Distance</label>
        <div class="searching-box">
            <select id="distance" class="browser-default" name="searching[distance]">
                <?php foreach(array(5,20,50,100,500,1000,5000,10000) as $distance): ?>
                    <option <?php if($distance==50){ echo 'selected="selected"';} ?> value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="searching-container">
        <label for="name">Name</label>
        <div class="searching-box">
            <input id="name" type="text" name="searching[name]" />
        </div>
    </div>

    <div class="searching-container">
        <label for="gender">Gender</label>
        <div class="searching-box">
            <select id="gender" class="browser-default" name="searching[gender]">
                <?php foreach(array('No Preference'=>'','Male'=>'male','Female'=>'female',) as $key=> $gender): ?>
                    <option value="<?php echo $gender; ?>">
                        <?php echo $key; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row">
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="pricelow">Price Range Low</label>
                <div class="searching-box">
                    <select id="pricelow" class="browser-default" name="searching[pricelow]">
                        <?php foreach(range(0,1000,10) as $pricerange): ?>
                            <option value="<?php echo $pricerange; ?>">
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
                    <select id="pricehigh" class="browser-default" name="searching[pricehigh]">
                        <?php foreach(range(0,1000,10) as $pricerange): ?>
                            <option <?php if($pricerange==200){ echo 'selected="selected"';} ?> value="<?php echo $pricerange; ?>">
                                $<?php echo numbers($pricerange); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
    	</div>
    </div>

    <div class="searching-container">
        <label for="page">Page</label>
        <div class="searching-box">
            <input id="page" type="text" name="searching[page]" value="1" />
        </div>
    </div>

    <div class="searching-container">
        <label for="sort">Sort Order</label>
        <div class="searching-box">
            <input id="sort" type="text" name="searching[sort]" value="last_active" />
        </div>
    </div>

</div>


<style type="text/css">
.searching-container label{
    font-size: 16px;
}
.searching-box{
    background: #fff;
    padding: 5px;
    border: solid 1px #ccc;
}
.searching-box input, .searching-box textarea{
    background: transparent;
    padding: 0px;
    margin: 0px;
    line-height: normal;
    border: none;
    background: #f5f5f5;
    padding: 2px 10px;
    box-sizing: border-box;

}
.searching-box input:focus, .searching-box textarea:focus{
    border: none !important;
    box-shadow: none !important;
}
</style>


<script type="text/javascript">

	$(document).ready(function() {
        $('#subject').autocomplete({
		    serviceUrl: '/findmesome'
		});
	});

</script>
