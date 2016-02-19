function geolocationaquizition(){
	var getzipcode = Cookies.get('getzipcode');
	var locide = $('#location').attr('id');
	var javaloc = $('.javascript-location').attr('class');

	if(getzipcode){

	}
	else if(locide || javaloc){

		if(locide){
			$('#'+locide).parent().parent().append('<div class="locating-zipcode"><i class="fa fa-spinner fa-spin"></i></div>');
		}
		else if(javaloc){
			$('.'+javaloc).parent().append('<div class="locating-zipcode"><i class="fa fa-spinner fa-spin"></i></div>');
		}

		window.navigator.geolocation.getCurrentPosition(function(pos){
			$.get( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+pos.coords.latitude+","+pos.coords.longitude+"&sensor=true", function( data ) {
				var zipcode = data.results[0].address_components[7].long_name;
				$('.locating-zipcode').remove();
				Cookies.set('getzipcode', zipcode, { expires: 7 });
				if(locide){
					$('#'+locide).val(zipcode);
				}
				else if(javaloc){
					$('#whatsyourzipcode').submit();
				}
			});
		});
	}

}

geolocationaquizition();

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

	function somethingFresh(results){
		var template = $('.template').html();
		$.each(results.results,function(index,value){
			var html = Mustache.to_html(template, value);
			$('.page-results').append(html);
		});
		$('.count').html(results.count);
		$('.numbers').html(results.numbers);
		$('.pagination').html(results.pagination);
	}

	function thisisatemplate(data,text) {
		//console.log(data);
		//console.log(text);
		//$('.template').html(data);
		//$.getJSON('http://avidbrain.dev/search/algebra/85257/200/---/male/0/100/---/---/',somethingFresh);
	}

	function maketemplate(data){
		$('.template').html(data);
		$('.submit-a-form').removeAttr('disabled');
	}
	function activego(one,two,three){
		var template = $('.template').html();
		// console.log(one);
		// console.log(two);
		// console.log(three);
		// console.log(template);
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

	function ajaxBadger(id,url){

		$('#urlstring--'+id).html('');

		$.ajax({
			type: 'POST',
			url: '/badges',
			data: {url:url,csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html()},
			success: function(response){
				$.each( response, function( key, value,index ) {
					$('#urlstring--'+id).append('<div class="action-badge '+key+'">'+value+'</div>');
				});
			}
		});
	}

	function ajaxposter(buildtheurl,thetoken,nexturl){

		var template = $('.template').html();
		$.ajax({
			type: 'POST',
			url: buildtheurl,
			data: {csrf_token:thetoken},
			success: function(results){
				$('.page-results').html('');
				$.each(results.results,function(index,value){
					var html = Mustache.to_html(template, value);
					$('.page-results').append('<div id="xxx-'+index+'">'+html+'<div>');
					$('#xxx-'+index).hide().delay(index * 100).fadeIn();
					ajaxBadger(value.urlid,value.url);
				});
				$('.count').html(results.count);
				$('.numbers').html(results.numbers);
				$('.pagination').html(results.pagination);
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

		$('.buildurl').val(buildtheurl);
		$('.nexturl').val(nexturl);


		$('.submit-a-form').attr('disabled','disabled');
		setTimeout(function(){
			$('.submit-a-form').removeAttr('disabled');
		},1000);

		ajaxposter(buildtheurl,thetoken,nexturl);

	}

	$(document).ready(function() {

		var makeclicks = {
            '.aboutme':'aboutme',
            '.my-tagline':'mytagline',
            '.newest-badge.my-name':'changemyname',
            '.newest-badge.hourlyrate':'changerate',
            '.newest-badge.location':'changelocation',
            '.newest-badge.gender':'changemygender',
            '.newest-badge.travel-distance':'changetraveldistance',
            '.newest-badge.cancellation-policy':'changecancellationpolicy',
            '.newest-badge.cancellation-rate':'changecancellationrate',
            '.newest-badge.tutortype-rate':'changetutortype'
        };
        $.each(makeclicks,function(index,value){
            $(index).append('<div data-target="'+value+'" class="make-changes"><i class="fa fa-pencil"></i></div>');
        });


        var makechanges = $('#makechanges').detach();
        $('footer').parent().append(makechanges);

        $('.make-changes').on('click',function(){
            var target = $(this).attr('data-target');
            $('.makechangescontainer').addClass('hide');
            $('#makechanges').openModal({
                ready:function(){
                    $('.'+target+'-container').removeClass('hide').hide().fadeIn();
                }
            });

            $('.savecahnges').on('click',function(){
                var savetarget = $(this).attr('data-target');
                var savevalue = $('#'+savetarget);
                $('#makethechanges').append(savevalue).submit();;
            });
        });


		var ziplat = $('.ziplat').val();
		var ziplong = $('.ziplong').val();
		var mainHeight = $('main').outerHeight() - 80;
		$('#map').css({'height':mainHeight});

		if(ziplat && ziplong){


	        var map;

	        map = new GMaps({
	            div: '#map',
				lat: ziplat,
				lng: ziplong
	        });


	        $.ajax({
	        	type: 'POST',
	        	url: '/locate',
	        	data: {csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html(),'getdata':{'ziplat':$('.ziplat').val(),'ziplong':$('.ziplong').val(),'distance':50}},
	        	success: function(response){
					if(response.message){
						map.drawOverlay({
						  lat: response.zipdata.ziplat,
						  lng: response.zipdata.ziplong,
						  content: '<div class="no-users-found">'+response.message+'</div>'
						});
					}
					else if(response){
						$.each(response,function(index,value){

							map.addMarker({
		                        lat: value.lat,
		                        lng: value.long,
								title:value.short,
		                        details: {
		                            author: 'Avidbrain'
		                        },
		                        infoWindow: {
		                            content: value.content
		                        }
		                    });
		                });
						map.fitZoom();
					}

	        	}
	        });
		}


		$('.submit-a-form').attr('disabled','disabled');

		//$.get('/templates/mustache.template.html', maketemplate);


		$('.submit-a-form').on('click',function(){
			$('.javascript-page').val(1);
  			history.pushState({}, '', '#1');
			$('.page-results').html('searching <i class="fa fa-spin fa-spinner"></i>');
		});

		$('.javascript').on('submit',function(){

			//$('.results').html('<div class="loading"><i class="fa fa-refresh fa-spin"></i></div>');
			var formtarget = '#'+$(this).attr('id');
			activate_voltron(formtarget);
			return false;

		});

		$('.javascript-subject').autocomplete({
		    serviceUrl: '/findmesome'
		});


		$('.sorting-feature').on('change',function(){
			$('#sort').val($(this).val());
			$('.search-button').click();
		});

		$('.pull-tab').on('click',function(){
			var pulltab = $(this).attr('data-status');
			if(pulltab=='closed'){
				$(this).attr('data-status','open').addClass('open').removeClass('closed').parent().addClass('open').removeClass('closed');
				$(this).find('.fa-arrow-up').removeClass('fa-arrow-up').addClass('fa-arrow-down');
			}
			else if(pulltab=='open'){
				$(this).attr('data-status','closed').addClass('closed').removeClass('open').parent().removeClass('open').addClass('closed');
				$(this).find('.fa-arrow-down').removeClass('fa-arrow-down').addClass('fa-arrow-up');
			}
		});

		$('.get-searching').on('submit',function(){
			$('.search-button').attr('disabled','disabled');
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

		$('#userlocationinfo').autocomplete({
			serviceUrl: '/suggestlocation',
			beforeRender: function(){
				//$('.zipcodeactual').val('');
			},
			onSelect: function (suggestion){
				$('#userlocationinfo-zipcode').val(suggestion.data);
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

		$('#homepagesearch').on('submit',function(){
			var searchterm = $('#homepageselect').val();
			$('.spinning').remove();
			$('#homepageselect').parent().append('<div class="spinning"> <span>Searching</span> <i class="fa fa-spinner fa-spin"></i></div>');
			$('.spinning').hide().fadeIn('fast');
			searchterm = searchterm.replace("/", "-");
			window.location = '/searching/'+searchterm;
			return false;
		});

		$('#homepageselect').autocomplete({
			serviceUrl: '/findmesome',
			beforeRender: function(){
				$('.spinning').remove();
			},
			onSelect: function (suggestion){
				$('#homepageselect').parent().append('<div class="spinning"> <span>Searching</span> <i class="fa fa-spinner fa-spin"></i></div>');
				$('.spinning').hide().fadeIn('fast');
				window.location = '/searching/'+suggestion.data;
			}
		});




	});


	function resize_drops(){
		var visibility = $('.searching-results-search').is(':visible');
		var windowWidth = $( window ).width();

		if(windowWidth > 600){
			if(visibility==false){
				$('.pull-tab').click();
			}
		}
		else{
			//console.log('more');
		}
	}

	$(document).ready(function() {
		resize_drops();
	});

	$(window).resize(function() {
		resize_drops();
	});
