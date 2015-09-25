function getNumberOfDays(year, month) {
    var isLeap = ((year % 4) == 0 && ((year % 100) != 0 || (year % 400) == 0));
    return [31, (isLeap ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
}

function resetform(){
	setTimeout(function(){
		$('.form-post .form-submit button, #confirm-charge, #becomeatutor button').removeAttr('disabled').removeClass('disabled');
	}, 500);
}

function kill_form(formid,message){
	
	$(formid).fadeOut('slow',function(){
		$(formid).parent().append('<div class="kill-form"><div class="slide-down invisible">'+message+'</div></div>');
		var messageHeight = $('.slide-down').outerHeight();
		$('.slide-down').css({
			"top":-messageHeight
		});
		setTimeout(function(){
			$('.slide-down').addClass('slide').removeClass('invisible');
			$('.slide-down').removeAttr('style');
		},500);
	});
}

function handlepost(response){

	console.log(response);

	var formid = '#'+response.formID;
	var fieldid = '#'+response.field;

	if(response.action=='login'){
		$(formid).closeModal();
		Materialize.toast(response.message, 3000,'login-toast',function(){});
		setTimeout(function(){
			var loginurl = document.location.href.split('#')[0];
			window.location = loginurl;
		}, 2700);

	}
	else if(response.action=='required'){
		
		$('.notify-user').remove();
		$('.required-form').removeClass('required-form');
		$(formid).addClass('required-form');
		$(formid+'.required-form').prepend('<span class="notify-user"><i class="mdi-action-report-problem"></i></span>');
		setTimeout(function(){
			$('.notify-user').fadeIn();
		}, 100);
		$('.required-field').removeClass('required-field');
		$(formid+' '+fieldid).addClass('required-field');
		$(formid+' '+fieldid).find('input,textarea,select,label').first().focus().click();
		Materialize.toast(response.message, 4000,'fixed-toast',function(){});
		
	}
	else if(response.action=='alert'){
		Materialize.toast(response.message, 4000,'fixed-toast saved-toast',function(){});
	}
	else if(response.action=='kill-form'){
		kill_form(formid,response.message);
	}
	else if(response.action=='jump-to'){
		kill_form(formid,response.message);
		Materialize.toast(response.message, 4000,'fixed-toast saved-toast',function(){});
		setTimeout(function(){
			window.location = response.location;
		}, 2000);
		
	}
	else if(response.action=='custom'){
		$(response.target).html(response.message);
	}
	else if(response.action=='confirm-payment'){
		$('.confirm-payment').removeClass('hide').hide().fadeIn().html(response.html);
		Materialize.toast(response.message, 4000,'fixed-toast',function(){});
		$('#confirm-charge').on('click',function(){
			$('#cancel-charge').fadeOut();
			$(this).attr('disabled','disabled').addClass('disabled');
			$('#completesession').append('<input type="hidden" name="completesession[secret]" value="'+response.secret+'" />');
			setTimeout(function(){
				$('#completesession').submit();
			}, 100);
		});
	}

	resetform();

}

function stripeResponseHandler(status, response) {
	
	if(response.error){
		$('.bank-errors').html('<div class="bank-problems">'+response.error.message+'</div>');
	}
	else{
		$('#save_tok').attr('disabled','disabled');
		$('.bank-details input').addClass('disabled').attr('disabled','disabled');
		var token = response.id;
		$('.bank_token').val(token);
		$('.full_legal_name').val($('#full_legal_name').val());
		$('.tax_id').val($('#tax_id').val());
		$('#bank_token').submit();
	}
	
}
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
	    console.log('Geolocation is not supported by this browser.');
    }
}
function showPosition(position){
	
	$.ajax({
		type: 'POST',
		url: '/my-location',
		data: {latitude:position.coords.latitude,longitude:position.coords.longitude,csrf_token:$('input[name="csrf_token"]').val()},
		success: function(response){
			if(response.zipcode){
				Cookies.set('mylocation', response, { expires: 1 });
				var thislocation = document.location.href.split('#')[0];
				window.location = thislocation;
			}
		}
	});
	return false;
	
}

function fixavatars(){
	
	
	$(".my-avatar.edit-avatar").each(function( index ) {
		
		var avatarwidth = $(this).outerWidth();
		var maxheight = 200;
		if(avatarwidth>maxheight){
			avatarwidth = maxheight
		}
		
		$(this).attr('style','font-size:'+avatarwidth+'px;height:'+avatarwidth+'px');
		
	});
	
}