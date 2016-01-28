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


            var template = '<div class="imatutor" id="activeblock-'+index+'">';
                template +='<div class="row">';
                    template += '<div class="col s12 m4 l3 center-align">';
                        template += '<div class="image"> <a href="{{url}}"><img src="{{img}}" /></a> </div>';
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
            //$('#activeblock-'+index).hide().removeClass('hide').delay(index * 100).fadeIn(300);

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

	function ajaxposter(buildtheurl,thetoken,nexturl){
		$.ajax({
			type: 'POST',
			url: buildtheurl,
			data: {csrf_token:thetoken},
			success: function(response){
				$('.results-count').html('<span>'+response.numbers+'</span> Tutors Found');
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

		if(nexturl){

			setTimeout(function(){
				$.ajax({
					type: 'POST',
					url: nexturl,
					data: {csrf_token:thetoken},
					success: function(response){
						// Next Available
					}
				});
			},3000);
		}
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


		var nextpage = parseInt(page) + 1;
		nexturl = buildtheurl+nextpage;
		buildtheurl += page+'/';
		buildtheurl += sort+'/';
		nexturl += '/'+sort+'/';


		$('.submit-a-form').attr('disabled','disabled');
		setTimeout(function(){
			$('.submit-a-form').removeAttr('disabled');
		},1000);

		ajaxposter(buildtheurl,thetoken,nexturl);


	}



	$(document).ready(function() {

		$('.submit-a-form').on('click',function(){
			$('.javascript-page').val(1);
			//event.preventDefault();
  			history.pushState({}, '', '#1');
		});

		$('.javascript').on('submit',function(){

			$('.results').html('<div class="loading"><i class="fa fa-refresh fa-spin"></i></div>');
			var formtarget = '#'+$(this).attr('id');
			activate_voltron(formtarget);
			return false;

		});

		$('.javascript-subject').autocomplete({
		    serviceUrl: '/findmesome'
		});

	});