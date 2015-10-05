<script type="text/javascript">
	
tour = new Shepherd.Tour({
  defaults: {
    classes: 'shepherd-theme-dark',
    scrollTo: true,
  }
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
			text: 'Close',
				action: function() {
					window.location = '<?php echo $app->currentuser->url; ?>/okgotit';
				}
		}
	]
});

tour.start();
	
</script>