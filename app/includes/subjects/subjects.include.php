<div class="row">
	<div class="col s12 m2 l2">
		<div class="left-navigation">
			<div class="sub-navigation-title">
					<a	href="/subjects">Subjects</a>
			</div>
			<ul class="sub-navigation" >
				<?php foreach($app->subjectslinks as $key=> $link): ?>
				<li>
					<a <?php if(isset($page) && $page==$key){ echo 'class="active"';} ?> href="/subjects/<?php echo $key; ?>"><?php echo $link; ?></a>
				</li>
			<?php endforeach; ?>
		 </ul>
		</div>
	</div>
	<div class="col s12 m10 l10">

		<?php

			if(isset($page)){
				$file = str_replace('subjects.include.','page.'.$page.'.',$app->target->include);
				if(file_exists($file)){
					include($file);
				}
				else{
					printer('touch '.$file);
				}
			}
			else{
					$file = str_replace('subjects.include.','page.subjects.',$app->target->include);
					 if(file_exists($file)){
						 include($file);
					 }
			}

		?>
	</div>
</div>
