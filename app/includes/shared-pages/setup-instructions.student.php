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
                    $('.itsanoverlay').fadeOut(function(){$(this).remove();});
					$('html, body').animate({scrollTop: $(".tutor-left").offset().top - 120}, 1000);
                    $('#addshortdescription input').focus();
					return tour.next();
				}
		}
	]
});

tour.addStep('myStep', {
	title: "Add a short description",
	text: "Add a short description about yourself.",
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

tour.addStep('myStep', {
	title: "Add a lengthy description",
	text: "Talk about yourself, what you need tutored in... words.",
	attachTo: '#addpersonalstatement bottom',
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

tour.addStep('myStep', {
	title: "Update Your Info",
	text: "How far you can travel, your gender, your prefered tutoring location",
	attachTo: '#about-me right',
	classes: 'shepherd shepherd-open shepherd-theme-arrows shepherd-transparent-text',
	buttons: [
		{
			text: 'Activate My Profile',
				action: function() {
					window.location = '<?php echo $app->currentuser->url; ?>/okgotit';
				}
		}
	]
});

tour.start();

</script>
<div class="itsanoverlay"></div>
