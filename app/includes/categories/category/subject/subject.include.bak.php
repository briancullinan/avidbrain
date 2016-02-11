<ul class="breadcrumb">
	<li><a href="/categories">Categories</a></li>
	<li><a href="/categories/<?php echo $category; ?>"><?php echo $app->zero->subject_parent; ?></a></li>
	<li><a href="/categories/<?php echo $category; ?>"><?php echo $app->zero->subject_name; ?></a></li>
</ul>

<?php if(!empty($app->pagedescription) && DEBUG==true):?>
<div class="block">
	<?php echo nl2br($app->pagedescription); ?>
</div>
<?php endif; ?>

<div class="top-subjects-signup">

	<div class="top-subjects-signup-now">
		<a href="/signup/students/toptutors" class="btn btn-block blue">
			Signup Now &amp; get <span>$30 Off</span> your first tutoring session
		</a>
	</div>

</div>

<?php include(APP_PATH.'includes/tutors/tutors.include.php'); ?>

<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
