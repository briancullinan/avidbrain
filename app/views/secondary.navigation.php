<?php if(isset($app->navtitle)): ?>
<div class="sub-navigation-title">
	<a <?php if($app->request->getPath()==$app->navtitle->slug){ echo ' class="active" ';} ?> href="<?php echo $app->navtitle->slug; ?>">
		<?php if($app->request->getPath()==$app->navtitle->slug){ echo ' <i class="fa fa-chevron-right"></i> ';} ?>
		<?php echo $app->navtitle->text; ?>
	</a>
</div>
<?php endif; ?>
<ul class="sub-navigation">
	<?php foreach($app->childen as $key=> $value): ?>
	<li <?php if($app->request->getPath()==$value->slug || isset($app->fixedname) && $app->fixedname==$value->slug || isset($app->path) && $app->path==$key){ echo 'class="active"';} ?>>
		<a href="<?php echo $value->slug; ?>">
			<?php echo $value->name; ?>
		</a>
	</li>
	<?php endforeach; ?>
</ul>