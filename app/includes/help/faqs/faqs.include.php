<h2>General</h2>

<ul class="collapsible faqs" data-collapsible="accordion" id="general">
	<?php foreach($app->general as $key=> $qa): ?>
	<li>
		<div class="collapsible-header <?php if(isset($type) && $type=='general' && $key==0){ echo 'active';} ?>">
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

<ul class="collapsible faqs" data-collapsible="accordion" id="students">
	<?php foreach($app->students as $key=> $qa): ?>
	<li>
		<div class="collapsible-header <?php if(isset($type) && $type=='students' && $key==0){ echo 'active';} ?>">
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

<ul class="collapsible faqs" data-collapsible="accordion" id="tutors">
	<?php foreach($app->tutors as $key=> $qa): ?>
	<li>
		<div class="collapsible-header <?php if(isset($type) && $type=='tutors' && $key==0){ echo 'active';} ?>">
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

<?php
	$clicky = NULL;
	if(isset($type) && $type=='general'){
		echo '<div class="faqid" id="general"></div>';
	}
	elseif(isset($type) && $type=='students'){
		echo '<div class="faqid" id="students"></div>';
	}
	elseif(isset($type) && $type=='tutors'){
		echo '<div class="faqid" id="tutors"></div>';
	}
?>