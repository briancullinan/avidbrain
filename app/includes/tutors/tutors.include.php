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
	<h1><?php echo numbers($app->count,1); ?>  <span class="blue-text"> <?php if(isset($app->search->search)){ echo ucwords($app->search->search); } ?> Tutor<?php echo $plurals; ?></span></h1>

	<?php foreach($app->searchResults as $searchResults):?>
		<div class="imatutor">
			<div class="row no-bottom">
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

					<div class="my-rate">
						$<?php echo numbers($searchResults->hourly_rate,1); ?><span>/ Hour <?php if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){ echo '<i class="fa fa-asterisk"></i>';} ?></span>
					</div>

				</div>
				<div class="col s12 m8 l9">
					<div class="row">
						<div class="col s12 m12 l8">
							<?php if(isset($searchResults->short_description_verified)): ?>
								<div class="short-description"><a href="<?php echo $searchResults->url; ?>"><?php echo $searchResults->short_description_verified; ?></a></div>
							<?php endif; ?>
							<?php if(isset($searchResults->personal_statement_verified)): ?>
								<div class="personal-statement"><?php echo truncate($searchResults->personal_statement_verified,400); ?></div>
							<?php endif; ?>
						</div>
						<div class="col s12 m12 l4">
							<a class="btn btn-block blue" href="<?php echo $searchResults->url; ?>">View Profile</a>
							<a class="btn btn-block" href="<?php echo $searchResults->url; ?>/send-message">Send Message</a>
							<div class="badges minisdfadges">
								<?php

									if(empty($searchResults->emptybgcheck)){
										echo batter_badges('background-check','mdi-action-assignment-ind','<a class="modal-trigger" href="#bgcheck_modal">Background Check</a>');
									}

									if(!empty($searchResults->star_score)){
										$score = ($searchResults->star_score*1);
										echo batter_badges('star-score-average','fa fa-star', $score.'/5 Stars');

									}

									if(isset($searchResults->negotiableprice) && $searchResults->negotiableprice=='yes'){
										echo batter_badges('negotiable-price','fa fa-dollar','My Rates Are Negotiable');
									}


								?>

								<div class="ajax-badges" id="<?php echo str_replace('/','',$searchResults->url); ?>" data-url="<?php echo $searchResults->url; ?>"></div>


							</div>
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
.action-badge{
	display: block;
	background: #efefef;
	line-height: normal;
	margin-bottom: 5px;
	font-size: 12px;
	float: left;
	width: 100%;
	color: #333;

}
.action-badge a{
	color: #333;
}
.action-badge-icon{
	float: left;
	width: 20%;
	text-align: center;
	padding: 5px;
	background: #ccc;
}
.action-badge-text{
	float: left;
	width: 80%;
	padding:9px 0px 0px 9px;
}
.hours-tutors .action-badge-icon{
	background: #3f51b5;
	color: #fff;
}
.background-check .action-badge-icon{
	background: #57ce0d;
	color: #fff;
}
.star-score-average .action-badge-icon{
	background: #ff9800;
	color: #fff;
}
.negotiable-price .action-badge-icon{
	background: #0069bd;
	color: #fff;
}
.total-reviews .action-badge-icon{
	background: #2196F3;
	color: #fff;
}
.total-students .action-badge-icon{
	background: #8f00dd;
	color: #fff;
}

.action-badge:last-child{
	margin-bottom: 0px;
}

.no-bottom{
	margin-bottom: 0px;
}
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
.my-rate{
	display: inline-block;
	margin-top: 15px;
	color: #009cff;
	font-size: 18px;
}
.my-rate span{
	font-size: 12px;
	color: #999;
}
</style>

<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>


<script type="text/javascript">

	$(document).ready(function() {

		$( ".ajax-badges" ).each(function( index ) {
			var badgeurl = $(this).attr('data-url');
			var badgeid = '#'+$(this).attr('id');
			$.ajax({
				type: 'POST',
				url: '/ajax-badges',
				data: {url:badgeurl,csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html()},
				success: function(response){
					$(badgeid).html('<div class="mybadge">'+response+'</div>');
					$(badgeid+' .mybadge').hide().fadeIn('slow');
				}
			});
		});


	});

</script>
