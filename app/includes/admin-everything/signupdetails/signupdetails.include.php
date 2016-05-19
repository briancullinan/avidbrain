<div class="row">
	<div class="col s12 m2 l2">
		<div class="block block-list">
			<?php foreach($app->signupdetailslinks as $key=> $link): ?>
			<a <?php if(isset($page) && $page==$key){ echo 'class="active"';} ?> href="/admin-everything/signupdetails/<?php echo $key; ?>"><?php echo $link; ?></a>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="col s12 m10 l10">

		<?php

			if(isset($page)){
				$file = str_replace('signupdetails.include.','page.'.$page.'.',$app->target->include);
				if(file_exists($file)){
					include($file);
				}
				else{
					printer('touch '.$file);
				}
			}
			else{
				$file = str_replace('signupdetails.include.','page.students.',$app->target->include);
				if(file_exists($file)){
					include($file);
				}
			//	echo 'Please select item from the left';
			}

		?>
	</div>
</div>
