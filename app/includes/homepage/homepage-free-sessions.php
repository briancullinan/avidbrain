<?php
	$signupcode = signupcode($app->connect,$app->user->email);
?>
<h3>Earn $30 towards tutoring</h3>
<p>When a friend gets tutored with your code, you both get $<?php echo numbers($signupcode->value,1); ?> off your next session.</p>
<div class="block">
	<div>Your Invite Link</div>
	<div class="invite-area"><input type="text" value="<?php echo $app->dependents->DOMAIN; ?>/signup/student/<?php echo $signupcode->promocode; ?>" onclick="select();" /></div>
	<br/>

	<?php
		$facebook = 'https://www.facebook.com/sharer/sharer.php?u='.$app->dependents->DOMAIN.'/student/'.$signupcode->promocode;
		$twitter = 'https://twitter.com/share?url='.$app->dependents->DOMAIN.'/student/'.$signupcode->promocode.'&text=I love @'.str_replace('https://twitter.com/','@',$app->dependents->social->twitter).' Sign up with my promo code and get $'.$signupcode->value.' off your first tutoring session!';
	?>

	<div class="row">
		<div class="col s12 m6 l6">
			<a href="<?php echo $facebook; ?>" target="_blank" class="btn btn-block  blue darken-3 "> <i class="fa fa-facebook"></i> Post It</a>
		</div>
		<div class="col s12 m6 l6">
			<a href="<?php echo $twitter; ?>" target="_blank" class="btn btn-block blue lighten-2"> <i class="fa fa-twitter"></i> Tweet It</a>
		</div>
		<div class="col s12 m6 l6">
			<?php
				$text = 'I just discovered '.$app->dependents->SITE_NAME_PROPPER.'. Signup now & get $'.numbers($signupcode->value,1).' off your next session. '.$app->dependents->DOMAIN.'/signup/student/'.$signupcode->promocode;
				$email = urlencode($text);
			?>
			<a href="mailto:?subject=$<?php echo $signupcode->value; ?> Off Tutoring with <?php echo $app->dependents->SITE_NAME_PROPPER; ?>&amp;body=<?php echo $email; ?>" class="btn btn-block grey darken-3"> <i class="fa fa-envelope"></i> Send It</a>
		</div>
		<div class="col s12 m6 l6">
			<a href="#textit" class="btn btn-block red modal-trigger"> <i class="fa fa-mobile"></i> Text It</a>

			<div id="textit" class="modal">

				<div class="modal-content">
				<h4>Send a text to a friend</h4>

				<form method="post" class="form-post" action="<?php echo $app->request->getPath(); ?>" id="textit">
					<div class="row">
						<div class="col s12 m6 l6">


								<div class="input-field">
									<input id="textnumber" maxlength="10" name="textnumber[number]" type="tel" class="validate">
									<label for="textnumber">
										Phone Number <span class="example">(123456789)</span>
									</label>
								</div>

								<input type="hidden" name="textnumber[target]" value="textnumber"  />
								<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

								<div class="form-submit">
									<button class="btn blue" type="submit">
										Send
									</button>
								</div>


						</div>
						<div class="col s12 m6 l6">
							<div class="sendatext"><textarea maxlength="160" name="textnumber[message]" id="textnumbermessage" class="materialize-textarea"><?php echo $text; ?></textarea></div>
						</div>
					</div>
				</form>

				</div>

				<div class="modal-footer">
					<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Close</a>
				</div>
			</div>

		</div>
	</div>

	<p>Sharing your invite link is the easiest way for you and your friends to get the help you need. Every new student who signs up with your code will get their first session free, and you'll earn a free session (up to $20) for spreading the word. It's the ultimate win-win.</p>

</div>
