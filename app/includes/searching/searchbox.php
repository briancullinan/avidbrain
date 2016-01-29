<?php

    $doihavazipcode = $app->getCookie('getzipcode');

?>

What are you looking for?

<form method="post" action="/searching/" class="get-searching form-post">

    <input type="hidden" name="searching[target]" value="searching"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

    <div class="searching-container">
        <label for="subject">Subject</label>
        <div class="searching-box" id="search-subject">
            <input id="subject" type="text" name="searching[subject]" <?php if(isset($app->queries->subject)){ echo 'value="'.$app->queries->subject.'"';} ?> />
        </div>
    </div>

    <div class="row nomargins">
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="zipcode">Zipcode</label>
                <div class="searching-box">
                    <input id="zipcode" type="text" name="searching[zipcode]" <?php if(isset($app->queries->zipcode)){ echo 'value="'.$app->queries->zipcode.'"';}elseif(!empty($doihavazipcode)){ echo 'value="'.$doihavazipcode.'"';} ?> />
                </div>
            </div>
    	</div>
    	<div class="col s12 m6 l6">
            <div class="searching-container">
                <label for="distance">Distance</label>
                <div class="searching-box">
                    <select id="distance" class="browser-default" name="searching[distance]">
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
            <select id="gender" class="browser-default" name="searching[gender]">
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
                    <select id="pricelow" class="browser-default" name="searching[pricelow]">
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
                    <select id="pricehigh" class="browser-default" name="searching[pricehigh]">
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
            <input id="page" type="text" name="searching[page]" value="1" />
        </div>
    </div>

    <div class="searching-container hidden">
        <label for="sort">Sort Order</label>
        <div class="searching-box">
            <input id="sort" type="text" name="searching[sort]" value="last_active" />
        </div>
    </div>

    <input id="subjectauto" type="text" name="searching[subjectauto]" <?php if(isset($app->queries->subject_slug)){ echo 'value="'.$app->queries->subject_slug.'"';} ?> />

    <br>
    <button class="btn" type="submit">
        BUTTON
    </button>

</form>


<style type="text/css">
.nomargins{
    margin: 0px;
}
.hidden{
    display: none;
}
.searching-container label{
    font-size: 16px;
}
.searching-box{
    background: #fff;
    padding: 5px;
    border: solid 1px #ccc;
}
.searching-box input, .searching-box textarea, .searching-box div{
    background: transparent;
    padding: 0px;
    margin: 0px;
    line-height: normal;
    border: none;
    background: #f5f5f5;
    padding: 2px 10px;
    box-sizing: border-box;
    height: 45px;

}
.searching-box div{
    background: red;
    line-height: 35px;
}
.searching-box input:focus, .searching-box textarea:focus{
    border: none !important;
    box-shadow: none !important;
}
</style>


<script type="text/javascript">

	$(document).ready(function() {

        $('#subject').autocomplete({
            serviceUrl: '/findmesome',
		    onSelect: function (suggestion){
                $('#subjectauto').val(suggestion.data);
            }
        });

        // $('#subject').autocomplete({
        //     serviceUrl: '/findmesome',
		//     onSelect: function (suggestion){
        //         $('#subjectauto').val(suggestion.data);
        //     }
        // });
        //
        // $('.get-searching').on('submit',function(){
        //
        //     var serialized_data = $(this).find("input, select, textarea");
        //     var urljump = '/searching';
        //     var newurl = {};
        //     $.each(serialized_data,function(){
        //         var value = $(this).val();
        //         var name = $(this).attr('name');
        //         if(!value){
        //             value = '---';
        //         }
        //         if(name=='page'){
        //             value = '['+value+']';
        //         }
        //         if(name=='sort'){
        //             value = '('+value+')';
        //         }
        //
        //         newurl[name] = value;
        //     });
        //
        //     if(newurl.subjectauto!='---'){
        //         var subject = newurl.subjectauto;
        //     }
        //     else{
        //         var subject = newurl.subject;
        //     }
        //
        //     urljump+= '/'+subject+'/'+newurl.zipcode+'/'+newurl.distance+'/'+newurl.name+'/'+newurl.gender+'/'+newurl.pricelow+'/'+newurl.pricehigh+'/'+newurl.page+'/'+newurl.sort;
        //
        //     window.location = urljump;
        //     return false;
        //
        // });



	});

    // if(name=='page'){
    //     if(value){
    //         value = '['+value+']';
    //     }
    //     else{
    //         value = '[---]';
    //     }
    // }
    // if(name=='sort'){
    //     if(value){
    //         value = '('+value+')';
    //     }
    //     else{
    //         value = '(---)';
    //     }
    // }
    // if(value && name){
    //     urljump+= '/'+value;
    // }
    // else{
    //     urljump+= '/---';
    // }


    //newurl.push({name:value});
    //newurl.name = value;

</script>
