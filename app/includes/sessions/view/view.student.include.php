<?php
	if($app->user->usertype=='student'){
		
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('promotions_active.*, promotions.email as shared_email, user.first_name, user.last_name, user.url')->from('avid___promotions_active','promotions_active');
		$data	=	$data->where('promotions_active.email = :email AND promotions_active.used IS NULL AND promotions_active.activated IS NOT NULL')->setParameter(':email',$app->user->email);
		$data	=	$data->leftJoin('promotions_active','avid___promotions','promotions','promotions_active.promocode = promotions.promocode');
		$data	=	$data->leftJoin('promotions_active','avid___user','user','user.email = promotions.email');
		$data	=	$data->setMaxResults(1);
		$data	=	$data->orderBy('value','DESC');
		$myrewards	=	$data->execute()->fetch();
		
	//	printer($myrewards,1);
		
		
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('promotions.*, payments.*')->from('avid___user_payments','payments');
		$data	=	$data->where('payments.session_id = :id AND payments.discount IS NOT NULL')->setParameter(':id',$id);
		$data	=	$data->leftJoin('payments','avid___promotions_active','promotions','payments.discount = promotions.id');
		$data	=	$data->execute()->fetch();
		
		if(isset($data->id)){
			$usedRewards = $data;
		}
		
	}
	
	if(isset($usedRewards->value)){
				
		$total = (($app->viewsession->session_cost/100) - $usedRewards->value);
		if($total<=0){
			$total = 0;
		}
		
		$total = numbers($total);
	}
	else{
		//$total = numbers($app->viewsession/100);
		$total = numbers(($app->viewsession->session_cost/100));
	}
	
	//printer($total);
	
?>
<div class="row">
	<div class="col s12 m4 l4">
		<?php $userinfo = $app->viewsession; include($app->dependents->APP_PATH."includes/user-profile/user-block.php"); ?>
		
		<div class="center-align">
			<?php if($app->viewsession->session_status=='canceled-session'): ?>
				<div class="alert red white-text">Canceled Session</div>
			<?php elseif(isset($app->viewsession->refund_amount) && isset($app->viewsession->dispute_support)): ?>
				<div class="alert orange white-text">
					<?php echo $app->dependents->SITE_NAME_PROPPER; ?> Staff has been contacted to help you out.
				</div>
			<?php elseif(isset($app->viewsession->refund_amount) && isset($app->viewsession->dispute)): ?>
			
				<p><?php echo short($app->viewsession); ?> has refunded <span class="notice blue white-text">$<?php echo numbers(($app->viewsession->refund_amount/100)); ?></span> you for your tutoring session. </p>
				
				
				<p>Do you approve, these changes?</p>
				
				<form method="post" class="form-post button-form-switch" action="<?php echo $app->request->getPath(); ?>">
				
					<button type="button" class="btn waves-effect" data-name="disputeaction[value]" data-value="yes">
						Yes
					</button>
					
					<button type="button" class="btn red waves-effect" data-name="disputeaction[value]" data-value="no">
						No
					</button>
					
					<input type="hidden" class="submitme" name="disputeaction[submitme]" value="submitme" />
					
					<input type="hidden" name="disputeaction[target]" value="disputeaction"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				</form>
				
			
			<?php elseif(isset($app->viewsession->dispute)): ?>
				You have disputed your tutoring session with <?php echo short($app->viewsession); ?>, please wait for them to correct the issue.
			<?php elseif(isset($app->viewsession->review_name)): ?>
				<div class="alert alert-thanks green white-text">
					Thank you for reviewing your tutor
				</div>
			<?php elseif(isset($app->viewsession->session_status) && $app->viewsession->session_status=='complete' && isset($app->viewsession->dispute_date) && empty($app->viewsession->review_name)): ?>
				
				<button class="btn btn-block  waves-effect data-unlock" data-target="#review-session" type="button">
					Review Session
				</button>
				
			<?php elseif(isset($app->viewsession->session_status) && $app->viewsession->session_status=='complete'): ?>
			
				<div class="alert blue white-text">
					You have been charged $<?php echo $total; ?> for this session. Please review your tutoring session, or if something is incorrect dispute the charge below.
				</div>
				
				<button class="btn btn-block  waves-effect data-unlock" data-target="#review-session" type="button">
					Review Session
				</button>
				
				<button class="btn btn-block red waves-effect data-unlock" data-target="#dispute-session" type="button">
					Dispute Charge
				</button>
			
			<?php elseif($app->viewsession->dateDiff->invert==1): ?>
				<div class="hr"></div>
				<p>It looks like your session occurred <br> <span class="notice red white-text"><?php echo $app->viewsession->dateDiff->text; ?> ago </span> </p>
				
				<a target="_blank" class="btn  btn-block" href="<?php echo $app->viewsession->url; ?>/send-message">Send Message</a>
				
				<?php if(isset($app->viewsession->cancellation_rate) && $app->viewsession->cancellation_rate>0): ?>
				<a href="#" data-target="/sessions/view/<?php echo $id; ?>/cancel" class="confirm-click btn btn-block red darken-2">Cancel With $<?php echo $app->viewsession->cancellation_rate; ?> Charge</a>
				<?php else: ?>
				<a href="#" data-target="/sessions/view/<?php echo $id; ?>/cancel" class="confirm-click btn red btn-block" href="">Cancel Session</a>
				<?php endif; ?>
				
			<?php elseif(isset($app->viewsession->dateDiff->text)): ?>
				<p>Your session will occur in <br> <span class="notice blue white-text"><?php echo $app->viewsession->dateDiff->text; ?></span></p>
				<a  target="_blank" class="btn  btn-block" href="<?php echo $app->viewsession->url; ?>/send-message">Send Message</a>
				
				<?php if(can_i_cancel($app->viewsession)==true): ?>
					<a href="#" data-target="/sessions/view/<?php echo $id; ?>/cancel" class="confirm-click btn red btn-block" href="">Cancel Session</a>
				<?php else: ?>
					<a href="#" data-target="/sessions/view/<?php echo $id; ?>/cancel" class="confirm-click btn btn-block red darken-2">Cancel With $<?php echo $app->viewsession->cancellation_rate; ?> Charge</a>
				<?php endif; ?>
				
			<?php endif; ?>
		</div>
		
	</div>
	<div class="col s12 m8 l8">
		<h2>Session Details</h2>
		
		<?php
			$showsession = $app->viewsession;
			include($app->target->base.'show-session.php');
		?>
		
		<?php if(empty($showsession->dispute)): ?>
		<div class="data-unlock-group">
			<div class="unlock-block" id="review-session">
				<?php
					$sessionreviews = new Forms($app->connect);
					$sessionreviews->formname = 'sessionreviews';
					$sessionreviews->url = $app->request->getPath();
					$sessionreviews->dependents = $app->dependents;
					$sessionreviews->csrf_key = $csrf_key;
					$sessionreviews->csrf_token = $csrf_token;
					$sessionreviews->makeform();
				?>
			</div>
			<div class="unlock-block" id="dispute-session">
				<?php
					$sessionreviews = new Forms($app->connect);
					$sessionreviews->formname = 'disputeclaim';
					$sessionreviews->url = $app->request->getPath();
					$sessionreviews->dependents = $app->dependents;
					$sessionreviews->csrf_key = $csrf_key;
					$sessionreviews->csrf_token = $csrf_token;
					$sessionreviews->makeform();
				?>
			</div>
		</div>
		<?php endif; ?>
		
	</div>
</div>