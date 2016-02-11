
<?php if(isset($myrewards->id)): ?>
	<div class="block session-promotion">
		<div class="row">
			<div class="col s12 m6 l6">
				<div>$<?php echo numbers($myrewards->value,1); ?> off your next session.</div>
				<div>Promo Discount: <?php echo $myrewards->promocode; ?></div>
			</div>
			<div class="col s12 m6 l6">
				When your next tutoring session is billed your will get $<?php echo numbers($myrewards->value,1); ?> off the total price.
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(isset($usedRewards->id)): ?>

	<div class="block session-promotion">
		Your earned $<?php echo numbers($usedRewards->value,1) ?> off this tutoring session
	</div>
<?php endif; ?>
<div class="box">

	<div class="title">
		<?php echo $showsession->session_subject; ?>
	</div>

	<div class="description">

		<?php

			function minutes_to_hours($minutes){
				$hours = ($minutes/60);
				$time = 'Hour';
				if($hours > 1){
					$time='Hours';
				}
				elseif($hours < 1){
					$hours='30';
					$time = 'Minutes';
				}
				return $hours.' '.$time;
			}

			$details = array();

			if(isset($showsession->refund_amount)){

				$refund = '<p>$'.numbers(($showsession->refund_amount/100)).'</p>';
				$refund.='<p>'.$showsession->dispute_response.'</p>';

				$details[$refund] = '<div class="alert green white-text">Refund</div>';
			}

			if(isset($showsession->dispute)){
				$details[$showsession->dispute_text] = '<div class="alert red white-text">Dispute</div>';
			}

			$details['$'.$showsession->session_rate.'/Hour'] = 'Rate';
			$details[$showsession->session_location] = 'Location';
			$details[$showsession->student_notes] = 'Notes';
			if($showsession->session_status=='complete'){
				$details[minutes_to_hours($showsession->session_length)] = 'Session Length';
			}
			else{
				$details[minutes_to_hours($showsession->proposed_length)] = 'Proposed Length';
			}

			if(isset($usedRewards->value)){

				$total = (($showsession->session_cost/100) - $usedRewards->value);
				if($total<=0){
					$total = 0;
				}

				$total = '$'.numbers($total);

				$details[$total] = 'Session Cost + Service Fee';
			}
			else{
				if(isset($showsession->session_cost)){
					$details['$'.numbers($showsession->session_cost/100)] = 'Session Cost + Service Fee';
					//'$'.number_format(($showsession->session_cost/100), 2, '.', ',')
				}
				elseif(isset($showsession->session_status) && $showsession->session_status=='canceled-session'){
					//
				}
				else{
					$details['$'.session_cost($showsession)] = 'Estimated Cost';
				}

			}

			if(isset($showsession->taxes)){
				$taxremoval = (((stripe_transaction($showsession->session_cost))-$showsession->session_cost)/100);
				$totalCost = $showsession->session_cost/100;
				$final = ceil($totalCost - $taxremoval);
				$finalPercent = (($final * $showsession->payrate)/100);
			}
			else{
				$finalPercent = (($showsession->session_cost * $showsession->payrate)/10000);
			}

			#printer($taxremoval);
			#printer($totalCost);
			#printer($final);
			#printer($finalPercent);

			// $taxes = stripe_transaction(($showsession->session_cost/100));
			// $cost = ($showsession->session_cost/100);
			// printer($taxes);
			// printer($cost);

			if(isset($app->user->usertype) && $app->user->usertype=='tutor'){
				$details[$showsession->payrate.'%'] = 'Pay Rate';
				$details['$'.numbers($finalPercent)] = 'You Made:';
			}




			if(isset($myrewards->value)){

				$session_cost = session_cost($showsession);
				$final = numbers(($session_cost-$myrewards->value));
				if($final<=0){
					$final = '<span class="green white-text padd5">$'.numbers(00).'</span>';
					$details[$final] = 'Estimated Cost after Discount';
				}
				else{
					$details['$'.$final] = 'Estimated Cost after Discount';
				}


			}

			if(isset($showsession->refund_amount)){
				$details['$'.numbers(($showsession->session_cost/100-$showsession->refund_amount/100))] = '<div class="alert blue white-text">Adjusted Session Cost</div>';
			}

			$details[$showsession->session_date.' @ '.$showsession->session_time] = 'Session Date:';
			if(isset($showsession->session_length)){
				$details[minutes_to_hours($showsession->session_length)] = 'Session Length';
			}
			//$details[online_session($showsession->session_online)] = 'Session Type';
			if(isset($showsession->review_score) && $showsession->review_score>0){
				$details['<span class="orange-text">'.get_stars($showsession->review_score)->icons.'</span>'] = 'Star Score';
			}

			if(!empty($showsession->roomid)){
				$details['<a href="/resources/whiteboard/'.$showsession->roomid.'" class="btn btn-s">View Whiteboard Session</a>'] = 'Whiteboard Session';
			}

			if(isset($showsession->review_text) && !empty($showsession->review_text)){
				$details[$showsession->review_text] = 'Review';
			}

			if(isset($app->user->usertype) && $app->user->usertype=='tutor' && empty($showsession->review_name)){
				$request = true;
				$details['<a href="'.$app->request->getPath().'/requestreview" class="btn green">Request Session Review</a>'] = "You haven't recieved a review for this session yet, why don't you ask your student for a review.";
			}


		?>

		<?php foreach($details as $key => $values): ?>

		<div class="row">
			<div class="col s12 m6 l6">
				<strong><?php echo $values; ?></strong>
			</div>
			<div class="col s12 m6 l6">
				<?php echo $key; ?>
			</div>
		</div>

		<?php endforeach; ?>
	</div>

	<?php //printer($showsession); ?>
</div>

<?php if(isset($action) && $action=='requestreview' && isset($request)): ?>
<h2>Request Review</h2>
<div class="blocks">
	<?php
		$messagingsystem = new Forms($app->connect);
		$messagingsystem->formname = 'messagingsystem';
		$messagingsystem->url = $showsession->url.'/request-review';
		$messagingsystem->csrf_key = $csrf_key;
		$messagingsystem->csrf_token = $csrf_token;

			$message = "Hi ".short($showsession)." will you please review our last tutoring session?";

			$whiteboard = new stdClass();
			$whiteboard->subject = 'Please Review Our Latest Session';
			$whiteboard->message = $message;
			$whiteboard->extra = $id;

			$messagingsystem->formvalues = $whiteboard;

		$messagingsystem->makeform();

	?>
</div>
<?php endif; ?>
