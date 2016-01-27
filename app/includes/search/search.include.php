<div class="row">
	<div class="col s12 m3 l3">

		<div class="block">
			<form method="post" action="#" class="javascript" id="itsposttime">

				<div class="fixed-input">
					<label>Subject</label>
					<input type="text" name="subject" class="javascript-subject" />
				</div>
				<input type="text" name="subject" class="javascript-location" placeholder="Location" />

				<div>
					<label>Distance</label>
					<select id="javascript-distance" class="browser-default">
						<?php foreach(array(5,20,100,500,1000,5000,10000) as $distance): ?>
							<option <?php if($distance==20){ echo 'selected="selected"';} ?> value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
						<?php endforeach; ?>
					</select>
				</div>



				<div class="xxx">
					<label>Gender</label>
					<select id="javascript-gender" class="browser-default">
						<?php foreach(array('No Preference'=>'','Male'=>'male','Female'=>'female',) as $key=> $gender): ?>
							<option value="<?php echo $gender; ?>">
								<?php echo $key; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="xxx">
					<label>Gender</label>
					<select id="javascript-gender" class="browser-default">
						<?php foreach(array('No Preference'=>'','Male'=>'male','Female'=>'female',) as $key=> $gender): ?>
							<option value="<?php echo $gender; ?>">
								<?php echo $key; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="xxx">
					<label>Price Range</label>
					<select id="javascript-pricerange" class="browser-default">
						<?php
							$priceArray = array(
								'0-25'=>'$0 - $20',
								'0-50'=>'$0 - $50',
								'0-100'=>'$0 - $100',
								'0-125'=>'$0 - $125',
								'0-200'=>'$0 - $200',
								'0-500'=>'$0 - $500',
								'0-1000'=>'$0 - $1,000',
							);
						?>
						<?php foreach($priceArray as $key=> $pricerange): ?>
							<option <?php if($key=='0-100'){ echo 'selected="selected"';} ?>  value="<?php echo $key; ?>">
								<?php echo $pricerange; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<?php
					//<input type="text" name="subject" class="javascript-pricelow" placeholder="Price Low" />
					//<input type="text" name="subject" class="javascript-pricehigh" placeholder="Price High" />
				?>
				<input type="hidden" name="subject" class="javascript-name" placeholder="Name" />


				<input type="hidden" name="subject" class="javascript-page" placeholder="Page" value="1" />
				<input type="hidden" name="subject" class="javascript-sort" placeholder="Page" value="lastactive" />

				<br/>
				<button type="submit" class="submit-a-form btn" data-form = "#itsposttime" > <i class="fa fa-search"></i> Search</button>

			</form>
		</div>


	</div>
	<div class="col s12 m9 l9">
		<div class="results-count"></div>
		<div class="results"></div>
		<div class="pagination-container"></div>
	</div>
</div>







<input id="csrf" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
<script src="/js/js.cookie.js"></script>


<script src="/js/mustache.js"></script>
<script type="text/javascript">

// window.navigator.geolocation.getCurrentPosition(function(pos){
//     console.log(pos);
// });

var getzipcode = Cookies.get('getzipcode');

if(getzipcode){
	$('.javascript-location').val(getzipcode);
}
else{
	window.navigator.geolocation.getCurrentPosition(function(pos){

		$.get( "https://maps.googleapis.com/maps/api/geocode/json?latlng=33.495904599999996,-111.9243226&sensor=true", function( data ) {
			var zipcode = data.results[0].address_components[7].long_name;
			if(zipcode){
				Cookies.set('getzipcode', zipcode, { expires: 7 });
				$('.javascript-location').val(zipcode);
			}
		});

	});
}

var decodeHtmlEntity = function(str) {
	return str.replace(/&#(\d+);/g, function(match, dec) {
		return String.fromCharCode(dec);
	});
};

var encodeHtmlEntity = function(str) {
	var buf = [];
	for (var i=str.length-1;i>=0;i--) {
		buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
	}
	return buf.join('');
};

    function build_results(results,count){
        //
        $.each( results, function( index,item ) {

            var view = {
              title: item.first_name,
              url:item.url,
              rate:item.hourly_rate,
              distance:item.distance,
              img:item.img,
			  location:item.city+', '+item.state_long
            };


			if(item.short_description_verified){
				view["desc"] = decodeHtmlEntity(item.short_description_verified);
			}
			if(item.personal_statement_verified){
				view["statement"] = decodeHtmlEntity(item.personal_statement_verified);
			}


			//console.log(view);

            var template = '<div class="imatutor" id="activeblock-'+index+'">';
                template +='<div class="row">';
                    template += '<div class="col s12 m4 l3 center-align">';
                        template += '<div class="image"> <img src="{{img}}" /> </div>';
                        template += '<div class="user-name"> <a href="{{url}}">{{title}}</a> </div>';
                        template += '<div class="tutor-location"><i class="mdi-action-room"></i> {{location}} </div>';
                        if(item.distance){
							template += '<div class="tutor-distance"> {{distance}} Miles Away </div>';
						}
                        template += '<div class="my-rate"> ${{rate}}<span>/ Hour</span> </div>';
                    template += '</div>';

                    template += '<div class="col s12 m8 l9">';
                        template += '<div class="row no-bottom">';
                            template += '<div class="col s12 m12 l8 my-info">';
                                template += '<div class="im-a-tutor-short"><a href="{{url}}">{{desc}}</a></div>';
                                template += '<div class="im-a-tutor-long">{{statement}}</div>';
                            template += '</div>';
                            template += '<div class="col s12 m12 l4">';
                                template += '<a class="btn btn-block blue" href="{{url}}">View Profile</a>';
                                template += '<a class="btn btn-block" href="{{url}}/send-message">Send Message</a>';

                                template += '<div class="badges"><div class="ajax-badges" id="urlstring--'+index+'" data-url="{{url}}"></div></div>';


                            template += '</div>';
                        template += '</div>';
                    template += '</div>';
                template += '</div>';

            template += '</div>';

            var output = Mustache.render(template, view);


            $('.results').append(output);
            //$('#activeblock-'+index).hide().removeClass('hide').delay(index * 300).fadeIn(100);

            var badgeid = '#urlstring--'+index;
            var badgeurl = item.url;
            $.ajax({
                type: 'POST',
                url: '/badges',
                data: {url:badgeurl,csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html()},
                success: function(response){
                    $.each( response, function( key, value,index ) {
    					$(badgeid).append('<div class="action-badge '+key+'">'+value+'</div>');
    				});
                }
            });

        });


    }

	function makesurefocus(array){
		$.each(array, function( index, value ) {
			var itemvalue = $('.javascript-'+value).val();
			if(!itemvalue){
				$('.javascript-'+value).focus();
				return false;
			}
		});
	}

	function activate_voltron(formtarget){

		var thetoken = $('#csrf').val();
		var subject = $('.javascript-subject').val();
		var location = $('.javascript-location').val();

		var distance = document.getElementById("javascript-distance");
		var distance = distance.options[distance.selectedIndex].value;

		var name = $('.javascript-name').val();
		var gender = $('#javascript-gender').val();
		var pricerange = $('#javascript-pricerange').val().split("-");
		var pricelow = pricerange[0];
		var pricehigh = pricerange[1];


		//var pricelow = $('.javascript-pricelow').val();
		//var pricehigh = $('.javascript-pricehigh').val();

		var page = $('.javascript-page').val();
		var sort = $('.javascript-sort').val();

		var buildtheurl = '/search/';
		if(subject){
			buildtheurl += subject+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(location){
			buildtheurl += location+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(distance){
			buildtheurl += distance+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(name){
			buildtheurl += name+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(gender){
			buildtheurl += gender+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(pricelow){
			buildtheurl += pricelow+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(pricehigh){
			buildtheurl += pricehigh+'/';
		}
		else{
			buildtheurl += '---/';
		}

		buildtheurl += page+'/';
		buildtheurl += sort+'/';

		$('.submit-a-form').attr('disabled','disabled');
		setTimeout(function(){
			$('.submit-a-form').removeAttr('disabled');
		},1000);

		makesurefocus(['subject','location','distance','gender','pricelow','pricehigh']);

		//console.log(buildtheurl);

		$.ajax({
			type: 'POST',
			url: buildtheurl,
			data: {csrf_token:thetoken},
			success: function(response){
				$('.results-count').html('<span>'+response.count+'</span> Tutors Found');
				$('.loading').fadeOut(function(){$(this).remove()});
				build_results(response.results,response.count);
				$('.results-count').append('<input type="hidden" class="totalcount" value="'+response.count+'" />');

				if(response.pagination){
					$('.pagination-container').html(response.pagination);

					$('.pagination-container a').on('click',function(){
						var datavalue = $(this).attr('data-value');
						$('.javascript-page').val(datavalue);
						$('#itsposttime').submit();
						$('html, body').animate({ scrollTop: 0 }, 'slow', function () { /**/ });
					});
				}

			}
		});


	}



	$(document).ready(function() {

		var totalcount = $('.totalcount').val();
		if(!totalcount){
			//$('#itsposttime').submit();
			console.log('toobers');
			setTimeout(function(){
				$('.submit-a-form').click();
			},2000);
		}

		$('.javascript').on('submit',function(){

			$('.results').html('<div class="loading"><img src="/images/spin.svg"></div>');
			var formtarget = '#'+$(this).attr('id');
			activate_voltron(formtarget);
			return false;

		});

		$('.javascript-subject').autocomplete({
		    serviceUrl: '/findmesome'
		});

	});

</script>
<style type="text/css">
.results-count{
	font-family: 'Quicksand';
    font-weight: 600;
	color: #444;
	font-size: 55px;
	line-height: normal;
	margin-top: -12px;
}
.results-count span{
	color: #2196F3;
}
.loading{
background: #222;
left:0px;
top:0px;
z-index: 4444;
text-align: center;
display: block;
padding-top: 100px;
height: 60px;
opacity: .5;
position: fixed;
width: 100%;
height: 100%;
}
.loading img{
	max-height: 100%;
}
</style>
