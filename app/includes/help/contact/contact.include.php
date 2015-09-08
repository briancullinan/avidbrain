<div class="row">
	<div class="col s12 m6 l6">
		<p>Need help with something? Found an error, or a bug, let us know.</p>
		
		<ul class="collection">
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-star green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						collection-item
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-star green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						collection-item
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-star green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						collection-item
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-star green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						collection-item
					</div>
				</div>
			</li>
		</ul>
		
	</div>
	<div class="col s12 m6 l6">
		<?php
			$variablename = new Forms($app->connect);
			$variablename->formname = 'contactus';
			$variablename->url = $app->request->getPath();
			$variablename->dependents = $app->dependents;
			if(isset($app->user->email)){
				$myemail = new stdClass();
				$myemail->name = short($app->user);
				$myemail->email = $app->user->email;
				$variablename->formvalues = $myemail;
			}
			$variablename->csrf_key = $csrf_key;
			$variablename->csrf_token = $csrf_token;
			$variablename->makeform();
		?>
	</div>
</div>