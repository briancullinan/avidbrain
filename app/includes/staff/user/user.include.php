<ul class="breadcrumb">
	<li><a href="/staff">Our Staff</a></li>
	<li><a href="<?php echo $app->request->getPath(); ?>"><?php echo $app->userinfo->first_name.' '.$app->userinfo->last_name; ?></a></li>
</ul>

<div class="row">
	<div class="col s12 m3 l3 center-align">
		<div class="avatar staff"><img class="responsive-img" src="<?php echo $app->userinfo->my_avatar; ?>"></div>
	</div>
	<div class="col s12 m9 l9">
		<h1><?php echo $app->userinfo->first_name.' '.$app->userinfo->last_name; ?></h1>
		<h2><?php echo $app->userinfo->short_description; ?></h2>
		
		<div>
			<?php echo nl2br($app->userinfo->personal_statement); ?>
		</div>
			
	</div>
</div>