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
	
	$('.slider').slider({
		height:300
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
	

});

// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('header').addClass("itstheheader-top").removeClass('itstheheader-bottom');
        $('.all-the-way-up').remove();
        $('main').append('<div class="all-the-way-up"><span class="fa-stack fa-lg"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-arrow-up fa-stack-1x"></i></span></div>');
        
        $('.all-the-way-up').on('click',function(){
	       // $(this).remove();
	        $('html, body').animate({scrollTop: $("main .container, main .homepage-container").offset().top - 100}, 1000);
        });
        
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
	        $('header').removeClass("itstheheader-top").addClass('itstheheader-bottom');
        }
    }
    
    if(st < 100){
	    $('.all-the-way-up').fadeOut(function(){
		    $(this).remove();
	    });
    }
    
    lastScrollTop = st;
}