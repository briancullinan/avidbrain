<h2>General</h2>

<ul class="collapsible faqs" data-collapsible="accordion">
	<?php foreach($app->general as $qa): ?>
	<li>
		<div class="collapsible-header">
			<?php echo $qa->question; ?>
		</div>
		<div class="collapsible-body">
			<div class="collapsible-text">
				<?php echo $qa->answer; ?>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>

<h2>Students</h2>

<ul class="collapsible faqs" data-collapsible="accordion">
	<?php foreach($app->students as $qa): ?>
	<li>
		<div class="collapsible-header">
			<?php echo $qa->question; ?>
		</div>
		<div class="collapsible-body">
			<div class="collapsible-text">
				<?php echo $qa->answer; ?>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>

<h2>Tutors</h2>

<ul class="collapsible faqs" data-collapsible="accordion">
	<?php foreach($app->tutors as $qa): ?>
	<li>
		<div class="collapsible-header">
			<?php echo $qa->question; ?>
		</div>
		<div class="collapsible-body">
			<div class="collapsible-text">
				<?php echo $qa->answer; ?>
			</div>
		</div>
	</li>
	<?php endforeach; ?>
</ul>