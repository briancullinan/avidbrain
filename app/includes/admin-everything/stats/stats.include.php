<div class="row">
	<div class="col s12 m2 l2">
		<div class="block block-list">
			<?php foreach($app->statslinks as $key=> $link): ?>
			<a <?php if(isset($page) && $page==$key){ echo 'class="active"';} ?> href="/admin-everything/stats/<?php echo $key; ?>"><?php echo $link; ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="col s12 m10 l10">

		<?php
			
			if(isset($page)){
				$file = str_replace('stats.include.','page.'.$page.'.',$app->target->include);
				if(file_exists($file)){
					include($file);
				}
				else{
					printer('touch '.$file);
				}
			}
			else{
				echo 'Please select a stat from the left';
			}
			
		?>
	</div>
</div>