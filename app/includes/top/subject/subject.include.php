<div class="row top-subjects">
	<div class="col s12 m3 l3 hide-on-small-only">
		<?php if(isset($app->top)): ?>
			<h2> Tutored Subjects</h2>
			<div class="block">
				<ul class="top-listed-subjects">
					<?php foreach($app->top as $top): ?>
						<li <?php $topname = '/top/'.$top->subject_slug.'-tutors'; if($topname==$app->request->getPath()){ echo ' class="active"';} ?>>
							<a href="/top/<?php echo $top->subject_slug; ?>-tutors">
								<span class="top-count"><?php echo $top->count; ?></span> <?php echo $top->subject_name; ?>
							</a>

						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	</div>
	<div class="col s12 m9 l9">

		<div class="top-subjects-signup">

			<div class="top-subjects-signup-now">
				<a href="/signup/students/toptutors" class="btn btn-block blue">
					Signup Now &amp; get <span>$30 Off</span> your first tutoring session
				</a>
			</div>

		</div>

		<?php if(isset($app->topresults)): ?>
			<?php foreach($app->topresults as $searchResults):?>
				<?php include($app->dependents->APP_PATH.'includes/tutors/search.results.php'); ?>
			<?php endforeach; ?>

			<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
			<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
		<?php else: ?>
			There are no tutors available
		<?php endif; ?>
	</div>
</div>

<?php if(isset($app->purechat)): ?>
	<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'a450183c-ea47-4537-89d4-f8b55a44e006', f: true }); done = true; } }; })();</script>
<?php endif; ?>
