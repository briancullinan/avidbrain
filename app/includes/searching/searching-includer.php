<?php
	/*
	<div class="row">
		<div class="col s12 m4 l4">
			<?php include($app->dependents->APP_PATH.'includes/searching/searchbox.php'); ?>
		</div>
		<div class="col s12 m8 l8">
			<?php if(isset($app->searching)): ?>
				<div class="searching-count">
					<?php echo $app->count; ?> <?php if(isset($app->cachedSubjectQuery->subject_name)){ echo $app->cachedSubjectQuery->subject_name; } ?> Tutors Found
				</div>
				<?php echo $app->pagination; ?>
				<div class="searching-results">
					<?php foreach($app->searching as $searching): ?>
						<div class="tutoring-block">
							<?php printer($searching->url); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php echo $app->pagination; ?>
			<?php else: ?>
				potato
			<?php endif; ?>
		</div>
	</div>

	*/
?>


<div class="searching-container-box">

	<div class="searching-results-left">
		<?php if(isset($app->searching)): ?>
			<div class="searching-count">
				<?php echo numbers($app->count,1); ?> <?php if(isset($app->cachedSubjectQuery->subject_name)){ echo $app->cachedSubjectQuery->subject_name; } ?> Tutors Found
			</div>
			<?php //echo $app->pagination; ?>
			<div class="searching-results">
				<?php foreach($app->searching as $searching): ?>
					<div class="tutoring-block">

						<div class="row">
							<div class="col s12 m3 l3 center-align">
								<div>
									<a href="<?php echo $searching->url; ?>">
										<img class="responsive-img" src="<?php echo $searching->img; ?>" />
									</a>
								</div>
								<div>
									<a href="<?php echo $searching->url; ?>">
										<?php echo $searching->short; ?>
									</a>
								</div>
								<div class="searching-location">
									<?php echo $searching->location; ?>
								</div>
							</div>
							<div class="col s12 m9 l9">
								<div class="row">
									<div class="col s12 m8 l8">
										<div><?php echo $searching->short_description_verified; ?></div>
										<div><?php echo $searching->personal_statement_verified; ?></div>
										<div>$<?php echo $searching->hourly_rate; ?>/ Hour</div>
									</div>
									<div class="col s12 m4 l4">
										xxx
									</div>
								</div>
							</div>
						</div>

						<?php #printer($searching); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php echo $app->pagination; ?>
		<?php else: ?>
			potato
		<?php endif; ?>
	</div>


	<div class="searching-results-right"><?php include($app->dependents->APP_PATH.'includes/searching/searchbox.php'); ?></div>

</div>


<style type="text/css">

.tutoring-block{
	background: #fff;
	border: solid 3px #ccc;
	margin-bottom: 15px;
	padding: 10px;
}

.page--mainsearching .container{
	padding: 0px;
	margin: 0px;
	width: 100%;
	position: relative;
	z-index: 333;
}
.searching-container-box{
	min-height: 700px;
}
.searching-results-left{
	padding-right: 385px;

	padding-top: 100px;
	padding-left: 25px;
	float: left;
	width: 100%;
}
.searching-results-right{
	width: 370px;
	padding: 5px 10px;
	position: fixed;
	background: rgba(33, 33, 33, 0.85);
	right: 0px;
	top:80px;
}
.searching-location{
	text-transform: capitalize;
}

.nomargins{
    margin: 0px;
}
.hidden{
    display: none;
}
.searching-container{
    margin-bottom: 10px;
}
.searching-container label{
    font-size: 16px;
    color: #fff;
}
.searching-box{
    background: #fff;
    padding: 0px;
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
    height: 42px;

}
.searching-box div{
    line-height: 35px;
}
.searching-box input:focus, .searching-box textarea:focus{
    border: none !important;
    box-shadow: none !important;
}
.searching-results{
    float: left;
    width: 100%;
}
.form-reset{
    padding: 3px 10px;
    font-size: 12px;
}

@media only screen and (max-width: 800px){
	.container{
		background: red;
	}
}
@media only screen and (min-width: 801px){
	.container{
		background: blue;
	}
}

</style>


<script type="text/javascript">

	$(document).ready(function() {

        $('.get-searching').on('submit',function(){
            $('.search-button').attr('disabled','disabled');
            //return false;
        });

        $('.form-reset').on('click',function(){
            $('.search-button').attr('disabled','disabled');
            $('.form-reset').attr('disabled','disabled');

            $.each($('.get-searching').find('input,select'),function(index,item){
                $(this).delay(index * 50).fadeOut(function(){
                    $(this).attr('value','');
                    var datadefault = $(this).attr('data-default');
                    $(this).find('option').removeAttr('selected');
                    if(datadefault){
                        $(this).attr('value',datadefault);
                    }
                }).fadeIn('fast');
            });

            setTimeout(function(){
                $('.search-button').removeAttr('disabled');
                $('.form-reset').removeAttr('disabled');
            },1000);
        });



        $('#location').autocomplete({
            serviceUrl: '/suggestlocation',
            beforeRender: function(){
                $('.zipcodeactual').val('');
            },
		    onSelect: function (suggestion){
                $('.zipcodeactual').val(suggestion.data);
            }
        });

        $('#subject').autocomplete({
            serviceUrl: '/findmesome',
            beforeRender: function(){
                $('#subjectauto').val('');
            },
		    onSelect: function (suggestion){
                $('#subjectauto').val(suggestion.data);
            }
        });

        //$('#subject')

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
