<script type="text/javascript">

tour = new Shepherd.Tour({
  defaults: {
    classes: 'shepherd-theme-dark',
    scrollTo: true,
  }
});

tour.addStep('step0', {
	title: "Welcome to the new AvidBrain",
	text: "Let us help you create the best profile so we can help you find what you need.",
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
                    $('.itsanoverlay').fadeOut(function(){$(this).remove();});
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
                    $('#addshortdescription input').focus();
					return tour.next();
				}
		}
	]
});

tour.addStep('step1', {
	title: "Add a short description",
	text: "This short description is used to help students find out more about you.",
	attachTo: '#addshortdescription bottom',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $("#addpersonalstatement").offset().top - 120}, 1000);
                    $('#addpersonalstatement textarea').focus();
					return tour.next();
				}
		}
	]
});

tour.addStep('step2', {
	title: "Add a lengthy description",
	text: "Go into detail about your self and what makes you a great tutor. <br />Some things to include in this section are: <br/><ul><li>Education Level</li><li>Years of Experience</li><li>Awards, Promotions</li></ul>",
	attachTo: '#addpersonalstatement bottom',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
                    $('.reset-input.hourly_rate').focus();
					return tour.next();
				}
		}
	]
});

tour.addStep('step5', {
	title: "Hourly Rate",
	text: "Enter your hourly rate",
	attachTo: '#changehourlyrate right',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text, calelation policy / fee',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $("#about-me").offset().top - 120}, 1000);
					return tour.next();
				}
		}
	]
});

// tour.addStep('step4', {
// 	title: "Add a Subject & A Photo",
// 	text: "addasubjectandaphoto",
// 	attachTo: '#mylinks right',
// 	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
// 	buttons: [
// 		{
// 			text: 'Next',
// 				action: function() {
// 					return tour.next();
// 				}
// 		}
// 	]
// });

tour.addStep('step3', {
	title: "Update Your Info",
	text: "How far you can travel, your gender, your prefered tutoring location",
	attachTo: '#about-me right',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Close',
				action: function() {
					window.location = '<?php echo $app->currentuser->url; ?>/okgotit';
				}
		}
	]
});



tour.start();

</script>
<div class="itsanoverlay"></div>
