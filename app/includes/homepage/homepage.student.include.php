<?php
	function uniquepromocode($connect){
		$random = random_all(8);
		$sql = "SELECT promocode FROM avid___promotions WHERE promocode = :promocode";
		$prepare = array(':promocode'=>$random);
		$results = $connect->executeQuery($sql,$prepare)->rowCount();
		
		if($results==0){
			return $random;
		}
		else{
			return uniquepromocode($connect);
		}
		
	}
	function get_random_promo_value(){
		/*
			$value	=	array(20,20,20,20,20,20,20,20,20,20,30,30,30,30,40,40,40,50,100);
			shuffle($value);
			$value = $value[0];
			return $value;
		*/
		return 30;
	}
	function signupcode($connect,$email){
		
		$promocodevalues = new stdClass();
		$sql = "SELECT * FROM avid___promotions WHERE email = :email";
		$prepare = array(':email'=>$email);
		$results = $connect->executeQuery($sql,$prepare)->fetch();
		
		if(isset($results->id)){
			$promocodevalues->promocode = $results->promocode;
			$promocodevalues->value = $results->value;
		}
		else{
			
			$random = uniquepromocode($connect);
			$value = get_random_promo_value();
			$connect->insert('avid___promotions',array('promocode'=>$random,'value'=>$value,'email'=>$email));
			$promocode = $random;
			$promocodevalues->promocode = $random;
			$promocodevalues->value = $value;
		}
		
		return $promocodevalues;
	}
	
	// Check for sessions without reviews
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('sessions.*, user.first_name,user.last_name,user.url')->from('avid___sessions','sessions');
	$data	=	$data->where('sessions.to_user = :myemail AND sessions.session_status = "complete" AND sessions.review_name IS NULL')->setParameter(':myemail',$app->user->email);
	$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.from_user');
	$data	=	$data->execute()->fetchAll();
	//printer($data);
	if(isset($data[0])){
		$app->needsreview = $data;
	}
	
?>
<div class="homepage-logged-in">
	
	<h1>Welcome to <?php echo $app->dependents->SITE_NAME_PROPPER; ?></h1>
	
	<div class="row">
		
		<div class="col s12 m4 l4">
			
				<?php if(isset($app->mytutors[0])): ?>
				<h3>Your Tutors</h3>
				<div class="compose-list center-align white">
					<?php foreach($app->mytutors as $compose): ?>
						<div class="compose-item <?php if(isset($username) && $compose->username==$username){ echo 'active'; } ?>" id="<?php echo $compose->url; ?>">
							<div class="row">
								<div class="col s12 m3 l3">
									<div class="avatar">
										<?php echo show_avatar($compose,$user=$app->user,$app->dependents); ?>
									</div>
								</div>
								<div class="col s12 m9 l9">
									<div class="user-name">
										<?php echo the_users_name($compose); ?>
									</div>
									<?php
										if(empty($compose->promocode) && $compose->usertype=='student'){
											echo '<div class="badge grey white-text">Student</div>';
										}
										elseif(isset($compose->promocode) && $compose->usertype=='student'){
											echo '<div class="badge blue white-text">Your Student</div>';
										}
										elseif($compose->usertype=='tutor'){
											echo '<div class="badge light-green accent-4 white-text">Tutor</div>';
										}								
									?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					You have no tutors, <a href="/tutors">find one now</a>.
				<?php endif; ?>
			
			
			<?php
				$sql = "SELECT id FROM avid___user_subjects WHERE email = :email";
				$prepare = array(':email'=>$app->user->email);
				$import = $app->connect->executeQuery($sql,$prepare)->rowCount();
				if($import!=0):
			?>
			<div class="alert red white-text">
				We've updated our jobs boards
			</div>
			<div class="center-align"><a class="btn" href="/jobs/import">Import Your Job Posts</a></div>
			<?php endif; ?>
			
			<?php if(isset($app->needsreview)): ?>
				<?php
					$neeedss=NULL;
					if(count($app->needsreview)!=1){$neeedss='s';}
				?>
				<h2>Past Session<?php echo $neeedss; ?></h2>
				<?php foreach($app->needsreview as $needsreview): ?>
					<div class="block">
						<div class="title">
							<?php echo $needsreview->session_subject; ?>
						</div>
						<div class="description">
							<div><a href="/sessions/view/<?php echo $needsreview->id; ?>">Review Session</a></div>
						</div>
						<div class="date">
							With: <a href="<?php echo $needsreview->url; ?>" target="_blank"><?php echo short($needsreview); ?></a> @ <?php echo formatdate($needsreview->session_timestamp); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
		</div>
		
		<div class="col s12 m4 l4">
			<?php if(isset($app->my_tweets)): ?>
				<h3> News from <?php echo str_replace('https://twitter.com/','@',$app->dependents->social->twitter); ?></h3>
				<?php foreach($app->my_tweets as $tweet):# printer($tweet); ?>
				
				<div class="block tweets">
					<div class="row">
						<div class="col s2 m3 l2">
							<a href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank"><img src="<?php echo $tweet->user->profile_image_url; ?>" class="responsive-img" /></a>
						</div>
						<div class="col s10 m9 l10">
							<div class="description"><?php echo linkify_tweet($tweet->text); ?></div>
							<div class="date"><?php echo formatdate($tweet->created_at,'M. jS, Y @ g:i a'); ?></div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<div class="more-tweets"><a target="_blank" href="https://twitter.com/<?php echo $tweet->user->screen_name; ?>">View More Tweets</a></div>
			<?php endif; ?>
			
		</div>
		
		<div class="col s12 m4 l4">
			<?php
				$signupcode = signupcode($app->connect,$app->user->email);
			?>
			<h3>Earn $30 towards tutoring</h3>
			<p>When a friend gets tutored with your code, you both get $<?php echo $signupcode->value; ?> off your next session.</p>
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
							$text = 'I just discovered '.$app->dependents->SITE_NAME_PROPPER.'. Signup now & get $'.$signupcode->value.' off your next session. '.$app->dependents->DOMAIN.'/signup/student/'.$signupcode->promocode;
							
						?>
						<a href="mailto:?subject=$<?php echo $signupcode->value; ?> Off Tutoring with <?php echo $app->dependents->SITE_NAME_PROPPER; ?>&amp;body=<?php echo $text; ?>" class="btn btn-block grey darken-3"> <i class="fa fa-envelope"></i> Send It</a>
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
			
			<?php if(isset($app->myrewards)): ?>
				<h2>Your Rewards</h2>
				<div class="all-my-rewards">
					<?php foreach($app->myrewards as $myrewards):  ?>
						<div class="block my-reward">
							<div class="row">
								<div class="col s12 m6 l6">
									<div class="my-reward-value">
										
										<div><span>$<?php echo $myrewards->value; ?></span> Off Your Next Tutoring Session.</div>
										<div>Automatically applied after your next session</div>
										
									</div>
								</div>
								<div class="col s12 m6 l6">
									<div class="my-reward-promo">Promo Code: <span><?php echo $myrewards->promocode; ?></span></div>
									<div>Activated: <?php echo formatdate($myrewards->date); ?></div>
									
									<div>Shared With: <a href="<?php echo $myrewards->url; ?>" target="_blank"><?php echo short($myrewards); ?></a></div>
									
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			
		</div>
	</div>
	
</div>