<div class="row">
	<div class="col s12 m3 l3">
		Sidebar Search
	</div>
	<div class="col s12 m9 l9">
		<div class="results"></div>
	</div>
</div>







<input id="csrf" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>



<script src="/js/mustache.js"></script>
<script type="text/javascript">

    function build_results(results){
        //
        $.each( results, function( index,item ) {

            var view = {
              title: item.first_name,
              url:item.url,
              rate:item.hourly_rate,
              distance:item.distance,
              img:item.img,
			  desc:item.short_description_verified,
			  statement:item.personal_statement_verified,
			  location:item.city+', '+item.state_long
            };

            var template = '<div class="imatutor hide" id="xxx-'+index+'">';
                template +='<div class="row">';
                    template += '<div class="col s12 m4 l3 center-align">';
                        template += '<div class="image"> image </div>';
                        template += '<div class="user-name"> user-name </div>';
                        template += '<div class="tutor-location"><i class="mdi-action-room"></i> {{location}} </div>';
                        template += '<div class="tutor-distance"> {{distance}} Miles Away </div>';
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
            $('#xxx-'+index).hide().removeClass('hide').delay(index * 300).fadeIn(500);

            var badgeid = '#urlstring--'+index;
            var badgeurl = item.url;
            $.ajax({
                type: 'POST',
                url: '/badges',
                data: {url:badgeurl,csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html()},
                success: function(response){
                    console.log(response);
                    $.each( response, function( key, value,index ) {
    					$(badgeid).append('<div class="action-badge '+key+'">'+value+'</div>');
    					//$(badgeid+' .'+key).hide().fadeIn();
    				});
                }
            });



        });
    }

//     $('.button').each($).wait(1000, function(index) {
//     alert('whatever you like: ' + this.text());
// });​

	$(document).ready(function() {





        var thetoken = $('#csrf').val();

        $.ajax({
        	type: 'POST',
        	url: '/search/algebra/82401/400/---/male/0/100/1/---/',
        	data: {csrf_token:thetoken},
        	success: function(response){
        		build_results(response.results);
        	}
        });
        return false;

	});

</script>
