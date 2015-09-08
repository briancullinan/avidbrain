<?php
	
?>

<?php if(isset($myrewards->id)): ?>
	<div class="block session-promotion">
		<div class="row">
			<div class="col s12 m6 l6">
				<div>$<?php echo $myrewards->value; ?> off your next session.</div>
				<div>Promo Discount: <?php echo $myrewards->promocode; ?></div>
			</div>
			<div class="col s12 m6 l6">
				When your next tutoring session is billed your will get $<?php echo $myrewards->value; ?> off the total price.
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(isset($usedRewards->id)): ?>
	
	<div class="block session-promotion">
		Your earned $<?php echo $usedRewards->value; ?> off this tutoring session
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
				
				$details[$total] = 'Session Cost';
			}
			else{
			
				if(isset($showsession->session_cost)){
					$details['$'.numbers($showsession->session_cost/100)] = 'Session Cost';
					//'$'.number_format(($showsession->session_cost/100), 2, '.', ',')
				}
				else{
					$details['$'.session_cost($showsession)] = 'Estimated Cost';
				}	
			
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
			
			$details[$showsession->session_date.' @ '.$showsession->session_time] = 'Session Date';
			if(isset($showsession->session_length)){		
				$details[minutes_to_hours($showsession->session_length)] = 'Session Length';	
			}
			$details[online_session($showsession->session_online)] = 'Session Type';
			if(isset($showsession->review_score)){
				$details['<span class="orange-text">'.get_stars($showsession->review_score)->icons.'</span>'] = 'Star Score';
			}
			
			if(!empty($showsession->roomid)){
				$details['<a href="/resources/whiteboard/'.$showsession->roomid.'" class="btn btn-s">View Whiteboard Session</a>'] = 'Whiteboard Session';
			}
			
			if(isset($showsession->review_text)){
				$details[$showsession->review_text] = 'Review';
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