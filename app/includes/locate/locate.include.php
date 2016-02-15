<?php if(isset($_COOKIE['getzipcode'])): ?>
    <?php
        $zipcode = $_COOKIE['getzipcode'];
        $data = get_zipcode_data($app->connect,$zipcode);
        if(isset($data->lat)){
            echo '<input type="hidden" class="ziplat" value="'.$data->lat.'" />';
        }
        if(isset($data->long)){
            echo '<input type="hidden" class="ziplong" value="'.$data->long.'" />';
        }

    ?>

    <?php if(isset($data->lat)): ?>
        <div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
        <div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
    <?php endif; ?>

<?php endif; ?>

<div id="map"></div>


<div class="modify-zipcode">
    <form method="post" action="/locate" id="whatsyourzipcode">


        <div class="row">
        	<div class="col l8">
        		<div class="searching-box"><input type="text" class="javascript-location" name="whatsyourzipcode[zipcode]" placeholder="What's your zipcode?" maxlength="5" <?php if(isset($zipcode)){ echo 'value="'.$zipcode.'"';} ?> /></div>
        	</div>
        	<div class="col l4">
                <div class="form-submit">
                    <button class="btn blue" type="submit">
                        Submit
                    </button>
                </div>
        	</div>
        </div>

        <input type="hidden" name="whatsyourzipcode[target]" value="whatsyourzipcode"  />
        <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">



    </form>
</div>
