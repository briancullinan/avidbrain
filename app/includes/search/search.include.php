<div class="row">
	<div class="col s12 m3 l3">

		<form method="post" action="#" class="javascript" id="itsposttime">

			<input type="text" name="subject" class="javascript-subject" placeholder="Subject" />
			<input type="text" name="subject" class="javascript-location" placeholder="Location" />

			<select id="javascript-distance">
				<?php foreach(array(5,20,100,500,1000,5000,10000) as $distance): ?>
					<option value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
				<?php endforeach; ?>
			</select>
			<input type="text" name="subject" class="javascript-name" placeholder="Name" />
			<input type="text" name="subject" class="javascript-gender" placeholder="Gender" />
			<input type="text" name="subject" class="javascript-pricelow" placeholder="Price Low" />
			<input type="text" name="subject" class="javascript-pricehigh" placeholder="Price High" />

			<input type="text" name="subject" class="javascript-page" placeholder="Page" value="1" />
			<input type="text" name="subject" class="javascript-sort" placeholder="Page" value="lastactive" />

			<button type="submit" class="submit-a-form btn" data-form = "#itsposttime" >Submit</button>

		</form>


	</div>
	<div class="col s12 m9 l9">
		<div class="results-count"></div>
		<div class="results"></div>
		<div class="the-pages"></div>
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

		$.get( "http://maps.googleapis.com/maps/api/geocode/json?latlng=33.495904599999996,-111.9243226&sensor=true", function( data ) {
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

    function build_results(results){
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
            $('#activeblock-'+index).hide().removeClass('hide').delay(index * 300).fadeIn(100);

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
		var gender = $('.javascript-gender').val();
		var pricelow = $('.javascript-pricelow').val();
		var pricehigh = $('.javascript-pricehigh').val();

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

		console.log(buildtheurl);

		$.ajax({
			type: 'POST',
			url: buildtheurl,
			data: {csrf_token:thetoken},
			success: function(response){
				$('.results-count').html(response.count+' Tutors Found');
				$('.loading').fadeOut(function(){$(this).remove()});
				build_results(response.results);
				build_pagination(response.count);

				$('.the-pages a').on('click',function(){
					var hashvalue = $(this).attr('data-value');
					$('.javascript-page').val(hashvalue);
					$('.javascript').submit();
				});
			}
		});


	}

	function build_pagination(count){
		$('.the-pages').html('<a data-value="1" href="#1">1</a><a data-value="2" href="#2">2</a><a data-value="3" href="#3">3</a>');
	}

	$(document).ready(function() {

		$('.javascript').on('submit',function(){

			$('.results').html('<div class="loading"><img src="/images/spin.svg"></div>');
			var formtarget = '#'+$(this).attr('id');
			activate_voltron(formtarget);
			return false;

		});

	});

</script>
<style type="text/css">
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
