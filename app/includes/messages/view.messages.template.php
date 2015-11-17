<?php if(isset($app->messages)): ?>
	<?php foreach($app->messages as $message): ?>
	<div class="block message-blocks <?php if(isset($message->status__read)){ echo ' read-message ';} ?>">
		<div class="in-box" id="<?php echo $message->id; ?>">
			<div class="row">
				<div class="col s12 m2 l2">
					<?php
						$results = NULL;
						$fromuser = $message->from_user;

						if(empty($message->usertype) && parent_company_email($fromuser)){
							$sql = "SELECT * FROM avid___admins WHERE email = :email LIMIT 1";
							$prepare = array(':email'=>$fromuser);
							$admininfo = $app->connect->executeQuery($sql,$prepare)->fetch();

						}
						else{
							$sql = "SELECT user.username,user.url,user.first_name,user.last_name,profile.my_avatar,profile.my_upload,profile.my_upload_status FROM avid___user user INNER JOIN avid___user_profile profile on profile.email = user.email WHERE user.email = :email LIMIT 1";
							$prepare = array(':email'=>$fromuser);
							$results = $app->connect->executeQuery($sql,$prepare)->fetch();
						}
					?>

					<?php if(isset($results->username)): ?>
						<div class="user-photograph">
							<a href="<?php echo $results->url; ?>">
								<img src="<?php echo userphotographs($app->user,$results,$app->dependents); ?>" />
							</a>
						</div>
						<div class="user-name">
							<a href="<?php echo $results->url; ?>"><?php echo ucwords(short($results)); ?></a>
						</div>
					<?php elseif(isset($admininfo)): ?>
						<div class="user-photograph">
							<a href="<?php echo $admininfo->url; ?>">
								<img src="<?php echo $admininfo->my_avatar; ?>" />
							</a>
						</div>
						<div class="user-name">
							<a href="<?php echo $admininfo->url; ?>"><?php echo ucwords(short($admininfo)); ?></a>
						</div>
					<?php endif; ?>

				</div>
				<div class="col s12 m10 l10">
					<div class="row killrow">
						<div class="col s12 m8 l8">
							<div class="message-subject"><?php echo $message->subject; ?></div>
						</div>
						<div class="col s12 m4 l4">
							<div class="message-date">
								<?php echo FormatDate($message->send_date); ?>
								<?php
									if(isset($message->status__flagged)){echo '<span class="messages-flags"><i class="fa fa-flag blue-text"></i></span>';}
									if(isset($message->status__starred)){echo '<span class="messages-flags"><i class="fa fa-star orange-text"></i></span>';}
								?>
							</div>

						</div>
					</div>
					<div class="hr"></div>
					<div class="message-message">
						<?php echo truncate($message->message,400); ?>
					</div>
					<?php if(isset($app->user->needs_bgcheck)): ?>
						<br>Please complete your <a href="/background-check" class="green-text">background check</a>, to view this message.
					<?php else: ?>
					<div class="message-view-full">
						<a class="blue white-text" href="/messages/view-message/<?php echo $message->id; ?>">View Full Message</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	<?php echo $app->pagination; ?>

<?php else: ?>
	There are no messages
<?php endif; ?>
