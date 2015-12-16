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
	<?php
		$plurals = NULL;
		if($app->count!=1){
			$plurals = 's';
		}
	?>
	<h1><?php echo numbers($app->count,1); ?>  <span class="blue-text"> <?php echo ucwords($app->search->search); ?> Tutor<?php echo $plurals; ?></span></h1>

	<?php foreach($app->searchResults as $searchResults):?>
		<div class="imatutor">
			<div class="row">
				<div class="col s12 m4 l3 center-align">
					<div class="image">
						<a href="<?php echo $searchResults->url; ?>">
							<img src="<?php echo userphotographs($app->user,$searchResults,$app->dependents); ?>" />
						</a>
					</div>
					<div class="user-name">
						<a href="<?php echo $searchResults->url; ?>"><?php echo short($searchResults); ?></a>
					</div>

					<?php if(isset($searchResults->city)): ?>
					<div class="tutor-location">
						<i class="mdi-action-room"></i>
						<a href="/tutors/<?php echo $searchResults->state_slug; ?>/<?php echo $searchResults->city_slug; ?>"><?php echo $searchResults->city; ?></a>, <a href="/tutors/<?php echo $searchResults->state_slug; ?>"><?php echo ucwords($searchResults->state_long); ?></a>
					</div>
					<?php endif; ?>
					<?php if(isset($searchResults->distance)): ?>
					<div class="tutor-distance">
						<?php echo number_format(round($searchResults->distance), 0, '', ','); ?> Miles Away
					</div>
					<?php endif; ?>

				</div>
				<div class="col s12 m8 l9">
					<div class="row">
						<div class="col s12 m12 l7">
							<?php if(isset($searchResults->short_description_verified)): ?>
								<div class="short-description"><a href="<?php echo $searchResults->url; ?>"><?php echo $searchResults->short_description_verified; ?></a></div>
							<?php endif; ?>
							<?php if(isset($searchResults->personal_statement_verified)): ?>
								<div class="personal-statement"><?php echo truncate($searchResults->personal_statement_verified,400); ?></div>
							<?php endif; ?>
						</div>
						<div class="col s12 m12 l5">
							xxx
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>

	<?php echo $app->pagination; ?>

<?php else: ?>
	OH SNAP
<?php endif; ?>


<style type="text/css">
.imatutor{
	background: #fff;
	border: solid 1px #ccc;
	margin-bottom: 15px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	padding: 10px;
}
.imatutor .image{
	text-align: center;
	margin: 0px;
	padding: 0px;
	line-height: normal;
}
.imatutor .image img{
	max-width: 100%;
	max-height: 300px;
	display: inline-block;
}
.short-description a{
	color: #333;
}
.short-description a:hover{
	background: #333;
	color: #fff;
}
</style>
