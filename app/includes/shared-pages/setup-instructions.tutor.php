<script type="text/javascript">

tour = new Shepherd.Tour({
  defaults: {
    classes: 'shepherd-theme-dark',
    scrollTo: true,
  }
});

tour.addStep('step0', {
	title: "Welcome to the new AvidBrain",
	text: "Something about the new interface and stuff",
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
					return tour.next();
				}
		}
	]
});

tour.addStep('step1', {
	title: "Add a short description",
	text: "Add a short description about yourself.",
	attachTo: '#addshortdescription bottom',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $("#addpersonalstatement").offset().top - 120}, 1000);
					return tour.next();
				}
		}
	]
});

tour.addStep('step2', {
	title: "Add a lengthy description",
	text: "Talk about yourself, what you need tutored in... words.",
	attachTo: '#addpersonalstatement bottom',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
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
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
					return tour.next();
				}
		}
	]
});

tour.addStep('step4', {
	title: "Add a Subject & A Photo",
	text: "addasubjectandaphoto",
	attachTo: '#mylinks right',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Next',
				action: function() {
					return tour.next();
				}
		}
	]
});

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
