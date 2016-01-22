<?php if(isset($app->top)): ?>
	<div class="block">
		<ul class="top-listed-subjects">
			<?php foreach($app->top as $top): ?>
				<li>
					<a href="/top/<?php echo $top->subject_slug; ?>-tutors">
						<span class="top-count"><?php echo $top->count; ?></span> <?php echo $top->subject_name; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
