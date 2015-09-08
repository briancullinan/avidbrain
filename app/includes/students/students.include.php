<?php if(isset($app->students[0])): ?>

<?php
	
	$filtertype = array(
		'closestdistance'=>'Closest Distance',
		'furthestdistance'=>'Furthest Distance',
		'lastactive'=>'Last Active'
	);
	
	if(empty($app->getDistance)){
		unset($filtertype['closestdistance']);
		unset($filtertype['furthestdistance']);
	}
	
	if(empty($app->filterbylocation)){
		notify('needs: filterbylocation');
	}
	
?>

	<div class="filter-by right-align">
		<a class="dropdown-button red btn btn-s" href="#" data-activates="filterby">
			Filter By <i class="fa fa-chevron-down"></i>
		</a>
		
		<!-- Dropdown Structure -->
		<ul id="filterby" class="dropdown-content">
			<?php foreach($filtertype as $key=>$value): ?>
			<li <?php if(isset($app->filterby) && $app->filterby==$key){ echo 'class="active"';} ?>>
				<a href="<?php echo '/filterby/'.$app->filterbylocation.'/'.$key.'/'.$app->number; ?>">
					<?php echo $value; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>


	<?php foreach($app->students as $searchResults): ?>
		
		<?php include($app->dependents->APP_PATH."includes/user-profile/mini.student.profile.php"); ?>
		
	<?php endforeach; ?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	There were no students found
<?php endif; ?>