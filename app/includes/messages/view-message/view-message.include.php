<div class="block view-message">
	<?php if(isset($app->viewmessage->next) || isset($app->viewmessage->prev)): ?>
	<div class="prev-next right-align">
		<?php if(isset($app->viewmessage->prev)): ?>
		<a href="/messages/view-message/<?php echo $app->viewmessage->prev; ?>">
			<i class="fa fa-chevron-left"></i>
		</a>
		<?php endif; ?>
		<?php if(isset($app->viewmessage->next)): ?>
		<a href="/messages/view-message/<?php echo $app->viewmessage->next; ?>">
			<i class="fa fa-chevron-right"></i>
		</a>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="col s12 m2 l2">

			<?php
			    $results = NULL;
			    $fromuser = $app->viewmessage->from_user;
			    if(empty($message->usertype) && parent_company_email($fromuser)){
			        $sql = "SELECT * FROM avid___admins WHERE email = :email LIMIT 1";
			        $prepare = array(':email'=>$fromuser);
			        $admininfo = $app->connect->executeQuery($sql,$prepare)->fetch();
					$results = $admininfo;
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
		<div class="col s12 m4 l3">
		<?php if(isset($app->user->needs_bgcheck)): ?>
			&nbsp;
		<?php elseif($app->viewmessage->to_user==$app->user->email): ?>

			<form method="post" class="form-post button-form-switch" action="<?php echo $app->request->getPath(); ?>">

				<?php if($app->viewmessage->location=='trash'): ?>
				<button class="btn red darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-delete">
					<i class="fa fa-trash"></i> Un-Delete
				</button>
				<?php else: ?>

				<a class="btn btn-s btn-block" href="/messages/view-message/<?php echo $id; ?>/reply">
					<i class="fa fa-reply"></i> Reply
				</a>

				<button class="btn red btn-s btn-block" data-name="inboxaction[value]" data-value="delete">
					<i class="fa fa-trash"></i> Delete
				</button>
				<?php endif; ?>

				<?php if($app->viewmessage->location!='trash'): ?>
				<button class="btn grey btn-s btn-block" data-name="inboxaction[value]" data-value="markunread">
					<i class="fa fa-check"></i> Mark As Un-Read
				</button>
				<?php endif; ?>


				<?php if(isset($app->viewmessage->status__flagged)): ?>
				<button class="btn blue darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-flag">
					<i class="fa fa-flag"></i> Un-Flag Spam
				</button>
				<?php else: ?>
				<button class="btn blue btn-s btn-block" data-name="inboxaction[value]" data-value="flag">
					<i class="fa fa-flag"></i> Flag as Spam
				</button>
				<?php endif; ?>

				<?php if(isset($app->viewmessage->status__starred)): ?>
				<button class="btn orange darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-star">
					<i class="fa fa-star"></i> Un-Star
				</button>
				<?php else: ?>
				<button class="btn orange btn-s btn-block" data-name="inboxaction[value]" data-value="star">
					<i class="fa fa-star"></i> Star
				</button>
				<?php endif; ?>

				<input type="hidden" name="inboxaction[target]" value="inboxaction"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			</form>
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
		</div>
		<div class="col s12 m6 l7">

			<div class="row row-fix title">
				<div class="col s12 m8 l8">
					<div class="message-subject"><?php echo $app->viewmessage->subject; ?></div>
				</div>
				<div class="col s12 m4 l4">
					<div class="message-date"><?php echo FormatDate($app->viewmessage->send_date); ?></div>
				</div>
			</div>
			<br>
			<div class="message-message">
				<?php echo nl2br($app->viewmessage->message); ?>
			</div>

		</div>
	</div>
</div>

<?php if(isset($app->user->needs_bgcheck)): ?>
	&nbsp;
<?php elseif(isset($action) && $action=='reply' && $app->viewmessage->location=='inbox'): ?>

	<?php if(isset($app->user->creditcardonfile) || isset($app->user->validateactive)): ?>

		<?php

			if(isset($aviduser)){
				$userinfo = new stdClass();
				$userinfo->url = $aviduser->url;
			}

			$reply = new stdClass();
			$reply->subject = 'Reply: '.$app->viewmessage->subject;
			if(isset($app->viewmessage->parent_id)){
				$reply->extra = $app->viewmessage->parent_id;
			}
			else{
				$reply->extra = $id;
			}

			$messagingsystem = new Forms($app->connect);
			$messagingsystem->formname = 'messagingsystem';
			$messagingsystem->url = $results->url;
			$messagingsystem->dependents = $app->dependents;
			$messagingsystem->csrf_key = $csrf_key;
			$messagingsystem->csrf_token = $csrf_token;
			$messagingsystem->formvalues = $reply;
			$messagingsystem->makeform();
		?>

	<?php else: ?>
	<div class="block">
		<div class="row">
			<div class="col s12 m6 l6">
				We required that all student's have a credit card on file before they can send out messages. We don't charge your card, it's only used for Authenticating that you are a student who is looking for tutors.
			</div>
			<div class="col s12 m6 l6">
				<a href="/payment/credit-card" class="btn blue">Activate Messaging</a>
			</div>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>
