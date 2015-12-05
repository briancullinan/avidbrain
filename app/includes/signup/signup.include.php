<div class="row">
	<div class="col s12 m12 l6">
		<h2>Student Signup</h2>
		<p>Are you looking for a tutor? Signup today and gain access to some of the best tutors on the internet.</p>
		<ul class="collection">
			<li class="collection-item">
				<div class="row">
					<div class="col s2 m2 l2">
						<i class="fa fa-search light-green-text accent-2-text"></i>
					</div>
					<div class="col s10 m10 l10">
						Choose a tutor that works for you
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s2 m2 l2">
						<i class="fa fa-calendar-o  light-green-text accent-2-text"></i>
					</div>
					<div class="col s10 m10 l10">
						Choose your schedule
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s2 m2 l2">
						<i class="fa fa-wifi light-green-text accent-2-text"></i>
					</div>
					<div class="col s10 m10 l10">
						Be tutored online or in person
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s2 m2 l2">
						<i class="fa fa-exchange  light-green-text accent-2-text"></i>
					</div>
					<div class="col s10 m10 l10">
						Network with other students
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-plus green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						<a href="/signup/student" class="green-text">Plus More</a>
					</div>
				</div>
			</li>
		</ul>
		<br>
		<div><a href="/signup/student" class="btn btn-block">Become A Student</a></div>
	</div>

	<div class="col s12 m12 l6">
		<h2>Tutor Signup</h2>
		<p>Would you like to become an <?php echo $app->dependents->SITE_NAME_PROPPER; ?> tutor? Begin the application process and start tutoring ASAP.</p>
		<ul class="collection">
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-check green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Choose your rate
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-check green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Choose your hours
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-check green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Choose your clients
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-check green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						Work remotely or in person
					</div>
				</div>
			</li>
			<li class="collection-item">
				<div class="row">
					<div class="col s1 m1 l1">
						<i class="fa fa-plus green-text"></i>
					</div>
					<div class="col s11 m11 l11">
						<a href="/signup/tutor" class="blue-text">Plus More</a>
					</div>
				</div>
			</li>
		</ul>
		<br>
		<div><a href="/signup/tutor" class="btn blue btn-block">Become A Tutor</a></div>
	</div>

	<?php
		/*
		<div class="col s12 m12 l4">
			<h2>Affiliates</h2>
			<p>something</p>
			<ul class="collection">
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-check green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							xxx
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-check green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							xxx
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-check green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							xxx
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-check green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							xxx
						</div>
					</div>
				</li>
				<li class="collection-item">
					<div class="row">
						<div class="col s1 m1 l1">
							<i class="fa fa-check green-text"></i>
						</div>
						<div class="col s11 m11 l11">
							xxx
						</div>
					</div>
				</li>
			</ul>
			<br>
			<div><a href="/signup/affiliate" class="btn orange btn-block">Become An Affiliate</a></div>
		</div>
		*/
	?>

</div>


<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
