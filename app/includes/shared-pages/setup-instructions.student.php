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

tour.addStep('myStep', {
	title: "Add a short description",
	text: "This short description is used to help tutors see what you need help in.",
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
	text: "Go into detail about your self and what you really need from a tutor. <br />Some things to include in this section are: <br/><ul><li>Grade Level</li><li>Online or in person</li><li>Tutoring Goals</li><li>Frequency</li></ul>",
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
	text: "This is extra information that will help our tutors reach you.",
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
