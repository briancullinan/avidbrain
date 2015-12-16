<?php if(isset($app->searchResults)): ?>

	<div class="filter-by right-align">
		<a class="dropdown-button grey btn btn-s" href="#" data-activates="filterby">
			Filter By <i class="fa fa-chevron-down"></i>
		</a>

		<!-- Dropdown Structure -->
		<ul id="filterby" class="dropdown-content">
			<?php foreach($app->filtertype as $key=>$value): ?>
			<li <?php if(isset($app->filterby) && $app->filterby==$key){ echo 'class="active"';} ?>>
				<a href="<?php echo '/filterby/'.$app->filterbylocation.'/'.$key.'/'.$app->number; ?>">
					<?php echo $value; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php echo numbers($app->count,1); ?>

	<?php printer($app->searchResults); ?>

	<?php echo $app->pagination; ?>

<?php else: ?>
	OH SNAP
<?php endif; ?>
