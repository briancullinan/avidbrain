<?php if(isset($app->messages)): ?>
	<?php foreach($app->messages as $message): ?>
	<div class="block message-blocks <?php if(isset($message->status__read)){ echo ' read-message ';} ?>">
		<div class="messages-active">
		<?php	
			if(isset($message->status__flagged)){echo '<div class="messages-flags"><i class="fa fa-flag blue-text"></i></div>';}
			if(isset($message->status__starred)){echo '<div class="messages-flags"><i class="fa fa-star orange-text"></i></div>';}
		?>
		</div>
		<div class="in-box" id="<?php echo $message->id; ?>">
			<div class="row">
				<div class="col s12 m2 l2">
					<?php
						
						if(empty($message->usertype) && avidbrainemail($message->from_user)){
							$email = $message->from_user;
							include($app->dependents->APP_PATH.'includes/user-profile/staff-block.php');
						}
						else{
							$userinfo = $message;
							$userinfo->dontshow = 1;
							include($app->dependents->APP_PATH.'includes/user-profile/user-block.php');
						}
					?>	
				</div>
				<div class="col s12 m10 l10">
					<div class="row killrow">
						<div class="col s12 m8 l8">
							<div class="message-subject"><?php echo $message->subject; ?></div>
						</div>
						<div class="col s12 m4 l4">
							<div class="message-date"><?php echo FormatDate($message->send_date); ?></div>
						</div>
					</div>
					<div class="hr"></div>
					<div class="message-message">
						<?php echo truncate($message->message,400); ?>
					</div>
					<div class="message-view-full">
						<a class="blue white-text" href="/messages/view-message/<?php echo $message->id; ?>">View Full Message</a>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<?php endforeach; ?>
	<?php echo $app->pagination; ?>
<?php else: ?>
	There are no messages
<?php endif; ?>