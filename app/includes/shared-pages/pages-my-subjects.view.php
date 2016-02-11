<?php if(isset($app->currentuser->my_subjects[0])): ?>
	<h2>My Areas of Expertise</h2>
	<?php foreach($app->currentuser->my_subjects as $subject): ?>
		<div class="block">
			<div class="title">
				<?php if(isset($subject->status) && $subject->status=='verified'): ?>
					<i class="mdi-maps-beenhere tooltipped verified-by" data-position="top" data-delay="50" data-tooltip="Verified By <?php echo SITENAME_PROPPER; ?>"></i>
				<?php endif; ?>
				<?php echo $subject->subject_name; ?>
			</div>
			<?php if(isset($subject->description_verified)): ?><div class="description"><?php echo nl2br($subject->description_verified); ?></div><?php endif; ?>
		</div>
	<?php endforeach; ?>

<?php endif; ?>

<?php if(isset($app->currentuser->my_other_subjects[0])): ?>

	<div class="hr"></div>
	<h2>Subjects I Tutor</h2>

	<?php echo showsubjects($app->currentuser->my_other_subjects,100,1); ?>
<?php endif; ?>
