<div class="row">
	<div class="col s12 m12 l6">
		<h2>Student Signup</h2>
		<p>Are you looking for a tutor? Signup today and gain access to some of the best tutors on the internet.</p>
		<ul class="collection signup-mid">
			<li class="collection-item">

						Choose a tutor that works for you

			</li>
			<li class="collection-item">

						Choose your schedule

			</li>
			<li class="collection-item">

						Be tutored online or in person

			</li>
			<li class="collection-item">

						Network with other students

			</li>

		</ul>
		<br>
		<div><form action="/signup/student">
					<button type="submit" class="btn btn-block">Become A Student</button>
				</form>
		</div>
	</div>

	<div class="col s12 m12 l6">
		<h2>Tutor Signup</h2>
		<p>Would you like to become an <?php echo SITENAME_PROPPER; ?> tutor? Begin the application process and start tutoring ASAP.</p>
		<ul class="collection signup-mid">
			<li class="collection-item ">

						Choose your rate

			</li>
			<li class="collection-item">

						Choose your hours

			</li>
			<li class="collection-item ">

						Choose your clients

			</li>
			<li class="collection-item">

						Work remotely or in person

			</li>

		</ul>
		<br>
		<div><form action="/signup/tutor">
					<button type="submit" class="btn tutorbtn btn-block">Become A Tutor</button>
				</form>
		</div>
		</div>

	<?php
	/*
	<div class="col s12 m12 l4">
		<h2>Affiliates</h2>
		<p>Become an affiliate and get $20.00 for every student or tutor who signs up with your promo code and has a tutoring session.</p>
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
