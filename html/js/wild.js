$(document).ready(function() {

	$('.activate-menu, .sidebar-close i').on('click',function(){
		var activestatus = $('.activate-menu').attr('data-status');
		if(activestatus=='closed'){
			$('.activate-menu').attr('data-status','open').addClass('active');
			$('header,main,footer,sidebar,html,body').addClass('activeaction').removeClass('inaction');
		}
		else if(activestatus=='open'){
			$('.activate-menu').attr('data-status','closed').removeClass('active');
			$('header,main,footer,sidebar,html,body').removeClass('activeaction').addClass('inaction');
		}
	});

});