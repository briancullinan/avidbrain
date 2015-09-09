$(document).ready(function() {
	
	$(".logo").lettering();
	
	$('.activate-mobile').on('click',function(){
		var activestatus = $(this).attr('data-status');
		if(activestatus=='closed'){
			$(this).attr('data-status','open');
			$('html,body').addClass('activeaction').removeClass('inaction');
		}
		else if(activestatus=='open'){
			$(this).attr('data-status','closed');
			$('html,body').removeClass('activeaction').addClass('inaction');
		}
	});
	
	$('.form-post, .post-form').on('submit',function(){
		
		$('.form-post .form-submit button').attr('disabled','disabled').addClass('disabled');
		
		var serialized_data = $(this).find("input, select, button, textarea").serialize();
		var target = document.URL;
		var formid = '#'+$(this).attr('id');
		if($(this).attr('action')){
			var target = $(this).attr('action');
		}		
		
		var xhr = $.ajax({
			type: 'POST',
			url: target,
			data: serialized_data,
			success: function(response){handlepost(response)}
		});
		return false;	
		
		
	});
	
	$('.time-picker').timepicker();
	
	$('.sidebar-activate').sideNav({
		menuWidth: 200,
		edge: 'left',
		closeOnClick: true
	});
	
	
	$('.godaddy').on('click',function(){
		var url = 'https:\/\/seal.godaddy.com\/verifySeal?sealID=Ife37TCcnamjWQG7v5u7LIF4gSu3BuWLtZZL25RGWmBEryK5DvgesB9s7lTv';
		window.open(url,'SealVerfication','menubar=no,toolbar=no,personalbar=no,location=yes,status=no,resizable=yes,fullscreen=no,scrollbars=no,width=' + 593 + ',height=' + 779);
	});
	
	$('.modal-trigger').leanModal();
	$('select').material_select();
	$('.slider').slider({
		height:300
	});
	$('.datepicker').pickadate({
		selectMonths: true,
		selectYears: 2
	});
	
	$('.scroller').pushpin({
		offset: 39
	});
	
	if($(window).width() < 600 && $('.shadow-nav').attr('class')){
		$('html, body').animate({scrollTop: $(".shadow-nav").offset().top - 50}, 1000);
		if($('#fp-signup').attr('id')){$('#fp-signup input').first().focus();}
	}
	
	$('.compose-item').on('click',function(){
		window.location = $(this).attr('id');
	});
	
	if($('.compose-item.active').attr('class')){
		$(".compose-list").animate({ scrollTop: $('.compose-item.active').offset().top -120 }, 1000);
	}
	
	
	$('.modal-login').on('click',function(){
		$('#login_email').focus();
	});

	$('.switch-post input').on('change',function(){
		var myformid = '#'+$(this).closest('form').attr('id');
		$(myformid).submit();
	});
	$('.checkbox-post label').on('click',function(){
		var myformid = '#'+$(this).closest('form').attr('id');
		$(myformid).submit();
	});
	
	$('#upload-select').on('click',function(){
		$('#upload-clicker').click();
		$('#upload-clicker').on('change',function(){
			$('input[type="hidden"][name="becomeatutor[myresume]"]').val('uploadmyresume');
			$('#upload-select').removeClass('btn-gray').addClass('active');
			$('#upload-select').html('<i class="fa fa-upload"></i> File Selected');
			var uploadform = '#'+$('#upload-select').closest('form').attr('id');
			$(uploadform).removeClass('form-post').addClass('manual');
			
		});
	});
	
	$('.how-it-works').on('click',function(){
		
		var datastatus = $(this).attr('data-status');
		if(datastatus=='closed'){
			$('.how-it-works').attr('data-status','open').addClass('active');
			$('.how-it-works-slide').addClass('slideDown').removeClass('slideUp');
			window.scroll(0, 0);
		}
		else if(datastatus=='open'){
			$('.how-it-works').attr('data-status','closed').removeClass('active');
			$('.how-it-works-slide').removeClass('slideDown').addClass('slideUp');
		}
		
		$('.close-it-works').on('click',function(){
			$('.how-it-works').attr('data-status','closed');
			$('.how-it-works-slide').removeClass('slideDown').addClass('slideUp');
		});
		
	});
	
	$('.switch input').on('change',function(){
		if($(this).is(':checked')){
			$(this).val('true');
			$(this).prop('checked', true);
			$(this).attr('checked','checked');
		}
		else{
			$(this).val('false');
			$(this).removeAttr('checked');
		}
	});
	
	$('.advanced-switch input').on('change',function(){
		if($(this).is(':checked')){
			$('.advanced-blocks').slideDown();
			$('.advanced-switch-text span').html('Advanced');
			Cookies.set('advancedsearch', true, { expires: 7 });
		}
		else{
			$('.advanced-blocks').slideUp();
			$('.advanced-switch-text span').html('Basic');
			Cookies.set('advancedsearch', false, { expires: 7 });
		}
	});
	
	$('.reset-form label').on('click',function(){
		$('#search, #zipcode, #distance, #gender, #name').val('');
		$('#agerangeLower').val('18');
		$('#agerangeUpper').val('65');
		$('#pricerangeLower').val('15');
		$('#pricerangeUpper').val('65');
		if($('.advanced-switch input').is(':checked')){
			$('.advanced-switch label').click();
		}
		$('#searchform button').click();
	});
	
	$('.hideSearch').on('click',function(){
		var hidestatus = $(this).attr('data-status');
		if(hidestatus=='open' || !hidestatus){
			$(this).attr('data-status','closed');
			$('.secondary-container, main').addClass('closed').removeClass('open');
			Cookies.set('hideSearch', true, { expires: 7 });
		}
		else if(hidestatus=='closed'){
			$(this).attr('data-status','open');
			$('.secondary-container, main').addClass('open').removeClass('closed');
			Cookies.set('hideSearch', false, { expires: 7 });
		}
	});	

	$('#signup_howdidyouhear').on('change',function(){
		if($(this).val()=='Other'){
			$('#field_signup_howdidyouhear_other').removeClass('hide').hide().slideDown().find('input').focus();
		}
	});
	
	var agerangeLower = $('#agerangeLower').attr('data-value');
	var agerangeUpper = $('#agerangeUpper').attr('data-value');
	var pricerangeLower = $('#pricerangeLower').attr('data-value');
	var pricerangeUpper = $('#pricerangeUpper').attr('data-value');
	
    $(".agerange").noUiSlider({
	    
    	start: [agerangeLower, agerangeUpper],
    	connect: true,
        step: 1,
        connect: true,
    	range: {
    		'min': 18,
    		'max': 120
    	},
        format: wNumb({
            decimals: 3,
            thousand: '.',
        })
    }).Link('lower').to($('#agerangeLower')).Link('upper').to($('#agerangeUpper'));

    $(".pricerange").noUiSlider({
    	start: [pricerangeLower, pricerangeUpper],
    	connect: true,
        step: 1,
        connect: true,
    	range: {
    		'min': 10,
    		'max': 500
    	},
        format: wNumb({
            decimals: 3,
            thousand: '.',
        })
    }).Link('lower').to($('#pricerangeLower')).Link('upper').to($('#pricerangeUpper'));
    
    $('.month-change select, .year-change select').change(function(){
		var selectedMonth = $('option:selected', this).attr('data-value');
		var selectedYear = $('.year-change select').val();
		if(selectedMonth){
			$('.day-change option').remove();
			var monthRange = getNumberOfDays(selectedYear,selectedMonth);
			var theDays = monthRange[selectedMonth] + 1;
			for(i=1;i<theDays;i++){
				$('.day-change select').append('<option value="'+i+'">'+i+'</option>');
			}				
		}
	});
	
	// 	Images
	$('#myavatar input').on('click',function(){
		$('#myavatar').submit();
	});
	$('#select-photo').on('click',function(){
		$('#upload-trigger').click();
		$('#upload-trigger').on('change',function(){
			$('#select-photo').removeClass('grey').html('<i class="fa fa-refresh fa-spin"></i> Uploading Photo');
			setTimeout(function(){
				$('#upload-photo-form').submit();
			}, 1000);
		});
	});
	$('#pagewidth').val(($('.tutor-profile').outerWidth()-40));
	
	var image = new Image();
	image.onload = function () {
	   $('#cropbox').Jcrop({
			aspectRatio: 1/1,
			onSelect: updateCoords,
			allowSelect:false,
			bgColor:'black',
			bgOpacity: .5,
		    setSelect: [ 172, 71, 322, 271 ],
	        minSize: [210]
		});
		function updateCoords(c){
			$('#x').val(c.x);
			$('#y').val(c.y);
			$('#w').val(c.w);
			$('#h').val(c.h);
		};
	}
	var setcropbox = $('#cropbox').attr('data-image');
	if(setcropbox){
		image.src = setcropbox;	
	}
	
	$('.confirm-click').on('click',function(){
		var datatarget = $(this).attr('data-target');
		var thistext = $(this).html();
		setTimeout($.proxy(function() {
			$(this).html('Click To Confirm').attr('href',datatarget);
	    }, this), 100);	    
	    setTimeout($.proxy(function() {
		    $(this).attr('href','#').html(thistext);
	    }, this), 3000);
	});
	
	$('.confirm-submit').on('click',function(){
		$(this).attr('data-text',$(this).html());
		var dataname = $(this).attr('data-name');
		var datavalue = $(this).attr('data-value');
		setTimeout($.proxy(function() {
			var type = $(this).attr('type');
			if(type=='submit'){
				$(this).closest('form').addClass('confirm-submit-action');
			}
			$(this).html('Click To Confirm').attr('type','submit');
			$(this).parent().append('<input class="deleteme hide" type="hidden" name="'+dataname+'[status]" value="'+datavalue+'" />');
	    }, this), 100);
		setTimeout($.proxy(function() {
			var thisattr = $(this).attr('data-text');
	        $(this).html(thisattr).attr('type','button');
	        $('.deleteme').remove();
	    }, this), 3000);
	});
	
	$('.button-form-switch button').on('click',function(){
		var dataname = $(this).attr('data-name');
		var datavalue = $(this).attr('data-value');
		$('.button-form-switch-input').remove();
		$(this).parent().append('<input class="button-form-switch-input" type="hidden" name="'+dataname+'" value="'+datavalue+'" />');
		var submitme = $(this).closest('form').find('.submitme').val();
		if(submitme){
			$(this).closest('form').submit();
		}
	});

	// Tutor Page
	$('.change-sujbects').on('change',function(){
		var activeattr = $('option:selected', this).attr('data-value');
		window.location = activeattr;
		console.log(activeattr);
	});
	
	var activesubject = $('.active-subject-block').attr('data-id');
	if(activesubject){
		$('#'+activesubject).addClass('active-subject');
		$("html, body").animate({ scrollTop: $('#'+activesubject).offset().top }, 1000);
	}
	
	if($('#unapprovedsubjects').attr('id')){
		Sortable.create(unapprovedsubjects, {
			handle: '.fa-reorder',
			animation: 300,
			onUpdate: function (evt/**Event*/){
				$('#unapprovedsortorder .theorder').empty();
				$( "#unapprovedsubjects .block" ).each(function( index ) {
					var swap = $(this).attr('data-id');
					var datainfo = $(this).attr('data-info');
					$('#unapprovedsortorder .theorder').append('<input type="hidden" name="subjectorder['+datainfo+']" value="'+index+'" />');
				});
				setTimeout(function(){
					$('#unapprovedsortorder').submit();
				}, 500);
			}
		
		});
	}
	
	if($('#approvedsubjects').attr('id')){
		Sortable.create(approvedsubjects, {
			handle: '.fa-reorder',
			animation: 300,
			onUpdate: function (evt/**Event*/){
				$('#unapprovedsortorder .theorder').empty();
				$( "#approvedsubjects .block" ).each(function( index ) {
					var swap = $(this).attr('data-id');
					var datainfo = $(this).attr('data-info');
					$('#unapprovedsortorder .theorder').append('<input type="hidden" name="subjectorder['+datainfo+']" value="'+index+'" />');
				});
				setTimeout(function(){
					$('#unapprovedsortorder').submit();
				}, 500);
			}
		
		});
	}
	
	if($('#myvideos').attr('id')){
		Sortable.create(myvideos, {
			handle: '.fa-reorder',
			animation: 300,
			onUpdate: function (evt/**Event*/){
				$('#myvideosorder .theorder').empty();
				$( "#myvideos .block" ).each(function( index ) {
					var swap = $(this).attr('data-id');
					var datainfo = $(this).attr('data-info');
					$('#myvideosorder .theorder').append('<input type="hidden" name="videosorder['+datainfo+']" value="'+index+'" />');
				});
				setTimeout(function(){
					$('#myvideosorder').submit();
				}, 500);
			}
		
		});
	}
	
	$('.changer').on('change',function(){
		var datatarget = $(this).attr('data-target');
		var dataid = '#'+$(this).attr('id');
		var thisvalue = $(dataid+' option:selected').attr('data-value');
		var inputdataname = $(this).attr('data-name');
		$(datatarget).html(this.value);
		$('.editprofile-input').remove();
		$('#editprofile').append('<input type="hidden" class="editprofile-input" name="'+inputdataname+'" value="'+thisvalue+'" />');
		$('#editprofile').submit();
	});
	
	$('.edit-change input, #my_birthday, .edit-change textarea').on('change',function(){
		var inputdata = $(this).val();
		var inputdataname = $(this).attr('name');
		var datavalue = $(this).attr('data-value');
		if(!datavalue){
			var changeme = inputdata;
		}
		else{
			var changeme = datavalue;
		}
		$(this).closest('.edit-block').find('.change-me').html(changeme);
		$(this).parent().parent().find('.edit-profile').click();
		$('#editprofile').append('<input type="hidden" name="'+inputdataname+'" value="'+inputdata+'" />');
		$('#editprofile').submit();
		
	});
	
	$('.edit-profile').on('click',function(){
		var thistarget = '#'+$(this).attr('data-target');
		var thistatus = $(this).attr('data-status');
		if(thistatus=='closed'){
			$(this).attr('data-status','open').addClass('active');
			$(thistarget).slideDown(function(){
				$(thistarget+' input').focus();
			});
		}
		else if(thistatus=='open'){
			$(this).attr('data-status','closed').removeClass('active');
			$(thistarget).slideUp();
		}
	});
	
	$('.day-change select').on('change',function(){
		var year = $('.year-change option:selected').text();
		var month = (parseInt($('.month-change option:selected').attr('data-value'))+1);
		var day = $('.day-change option:selected').text();
		$('#editprofile').append('<input type="hidden" name="editprofile[birthday]" value="'+year+'-'+month+'-'+day+'" />');
		$('#editprofile').submit();
	});
	
	$('#updatecard').on('click',function(){
		$('#updatecreditcard button').click();
	});
	
	$('.autogenerate--subject').autocomplete({
	    serviceUrl: '/get-subjects',
	    onSelect: function (suggestion) {
		    var inputname = $(this).attr('data-name');
		    $('.suggest').remove();
		    $(this).closest('form').append('<input class="suggest" type="hidden" name="'+inputname+'[subject_slug]" value="'+suggestion.data.subject_slug+'" />');
		    $(this).closest('form').append('<input class="suggest" type="hidden" name="'+inputname+'[parent_slug]" value="'+suggestion.data.parent_slug+'" />');
		    $(this).closest('form').append('<input class="suggest" type="hidden" name="'+inputname+'[id]" value="'+suggestion.data.id+'" />');
	    }
	});
	
	$('.searchbox, #setupsession_session_subject').autocomplete({
	    serviceUrl: '/get-subjects',
	    onSelect: function (suggestion) {
		    console.log(suggestion.data);
	    }
	});
	
	$('.find-a-subject').autocomplete({
	    serviceUrl: '/get-subjects',
	    onSelect: function (suggestion) {
		    var thisurl = $(this).attr('data-location')+'/my-subjects/'+suggestion.data.parent_slug+'/'+suggestion.data.subject_slug;
		    window.location = thisurl;
	    }
	});
	
	$('#globalsearch').autocomplete({
	    serviceUrl: '/get-subjects',
	    onSelect: function (suggestion) {
		    $('.global-search form').submit();
	    },
	    onSearchComplete: function (query, suggestions) {
		   $('.autocomplete-suggestions').addClass('center-results');
	    }
	});
	
	$('.data-unlock').on('click',function(){
		var datatarget = $(this).attr('data-target');
		$('.data-unlock-input').val(datatarget);
		$('.unlock-block').hide();
		$(datatarget).show();
	});
	
	$('.star-ranks i').on('click',function(){
		var finish = parseInt($(this).attr('data-value'));
		$('.the-star-score').val(finish);
		$('.star-ranks .fa-star').removeClass('fa-star').addClass('fa-star-o');
		var finish = Array.apply(null, Array(finish)).map(function (_, i) {return i;});
		$.each(finish, function( index, value ) {
			$('.star-ranks .star-'+index).removeClass('fa-star-o').addClass('fa-star');
		});
	});
	
	var strignarray = ['Welcome to AvidBrain','What do you want to learn?'];
	$( ".typed span" ).each(function( index ) {
		strignarray.push($(this).html());
	});
	$('.homepage-typed').focus();
    $(".homepage-typed").typed({
        strings: strignarray,
        typeSpeed: 0
    });
    
	if($('#scribblar').attr('id')){
		
		var targetID = "scribblar";
		var scribblarusername = $('.scribblarusername').val();
		var scribblarroomid = $('.scribblarroomid').val();
		
		var flashvars = {};
		flashvars.username = scribblarusername;
		flashvars.userid = 0;
		flashvars.roomid = scribblarroomid;
		flashvars.preferredLocales = "en_US";
		var params = {};
		params.allowscriptaccess = "always";
		var attributes = {};
		attributes.id = "scribblar";
		attributes.name = "scribblar";
		swfobject.embedSWF("//s3.amazonaws.com/media.muchosmedia.com/scribblar/v3/main.swf", "scribblar", "100%", "100%", "11.1.0", "//s3.amazonaws.com/media.muchosmedia.com/swfobject/expressInstall.swf", flashvars, params, attributes);
	}
	
	// Radio Select Submit
	$('.radio-clicks label').on('click',function(){
		setTimeout($.proxy(function() {
			$(this).closest('form').find('.form-submit button').click();
	    }, this), 300);	
	});
	
	// 	Stripe
	$('#save_tok').on('click',function(){
			
		var country = $('#country').val();
		var currency = $('#currency').val();
		var routing_number = $('#routing_number').val();
		var routing_number_confirm = $('#routing_number_confirm').val();
		var account_number = $('#account_number').val();
		var account_number_confirm = $('#account_number_confirm').val();
		var tax_id = $('#tax_id').val();
		var full_legal_name = $('#full_legal_name').val();
		
		var submit = true;
		$('.bank-details-inputs.required').removeClass('required');
		$('.bank-errors-message').remove();
		
		if(!country){
			$('#country').parent().addClass('required');
			submit = null;
		}
		else if(!currency){
			$('#currency').parent().addClass('required');
			submit = null;
		}
		else if(!full_legal_name){
			$('#full_legal_name').parent().addClass('required');
			$('#full_legal_name').focus();
			submit = null;
		}
		else if(!routing_number){
			$('#routing_number').parent().addClass('required');
			$('#routing_number').focus();
			submit = null;
		}
		else if(!account_number){
			$('#account_number').parent().addClass('required');
			$('#account_number').focus();
			submit = null;
		}
		else if(!tax_id){
			$('#tax_id').parent().addClass('required');
			$('#tax_id').focus();
			submit = null;
		}
		else if(routing_number!=routing_number_confirm){
			$('#routing_number').parent().addClass('required');
			$('#routing_number').parent().find('.error').html('<div class="bank-errors-message">Your routing numbers do not match</div>');
			$('#routing_number').focus();
			submit = null;
		}
		else if(account_number!=account_number_confirm){
			$('#account_number').parent().addClass('required');
			$('#account_number').parent().find('.error').html('<div class="bank-errors-message">Your account numbers do not match</div>');
			$('#account_number').focus();
			submit = null;
		}
		
		if(submit){
			Stripe.bankAccount.createToken({
				country: country,
				currency: currency,
				routing_number: routing_number,
				account_number: account_number
			},stripeResponseHandler);
		}
		
	});
	
	$( "#target" ).keyup(function() {
			
		var thisdata = $(this).val();
		$(".main-content a").unhighlight();
		$(".main-content a").highlight(thisdata);
		
		
		$(this).keypress(function (e) {
			if(e.which == 13) {
				$('html, body').animate({scrollTop: $(".highlight").offset().top - 50}, 100);
			}
		});
		
	});
	
	$('.helper .help').on('click',function(){
		var clickhelp = $(this).attr('data-click');
		Materialize.toast(clickhelp, 6000,'help-box',function(){});
	});
	
	$("#signup_phone, .swapnumber").keyup(function() {
		var swapnumber = $(this).val().replace('(','').replace(')','').replace(/[A-Za-z$-]/g, "");
		$(this).val(swapnumber);
	});
	
	// FAQ's
	var faqid = $('.faqid').attr('id');
	if(faqid){
		$('html, body').animate({scrollTop: $("#"+faqid).offset().top - 120}, 1000);
	}
	
});
$(window).on('scroll', function() {
    scrollPosition = $(this).scrollTop();
    var datastatus = $('.how-it-works').attr('data-status');
    if (scrollPosition >= 501 && datastatus=='open') {
        $('.how-it-works').attr('data-status','closed');
		$('.how-it-works-slide').removeClass('slideDown');
		window.scroll(0, 0);
    }
});
$(document).ajaxError( function(e, xhr, settings, exception) {
	console.log(xhr.responseText);
	resetform();
});
$(window).resize(function() {
	var width = $(window).width();
	var activestatus = $('.activate-mobile').attr('data-status');
	if(width>992){
		if(activestatus=='open'){
			$('.activate-mobile').click();
			$('html,body').removeClass('inaction');
		}
	}
	else if(width<992){
		
	}
});