<div class="block view-message">

    <div class="previous-next-nav">
		<?php if(isset($app->message->prevnext->prev)): ?>
		<div class="previous-next-nav-left">
            <a href="/messages/view-message/<?php echo $app->message->prevnext->prev; ?>">
    			<i class="fa fa-chevron-left"></i>
    		</a>
        </div>
		<?php endif; ?>

        <?php if(isset($app->message->prevnext->next)): ?>
        <div class="previous-next-nav-right">
    		<a href="/messages/view-message/<?php echo $app->message->prevnext->next; ?>">
    			<i class="fa fa-chevron-right"></i>
    		</a>
        </div>
		<?php endif; ?>
	</div>


    <div class="row">
    	<div class="col s12 m3 l3">
            <div class="user-photograph">
                <a href="<?php echo $app->message->user->url; ?>">
                    <img src="<?php echo $app->message->user->image; ?>" />
                </a>
            </div>

    		<div class="user-name">
                <a href="<?php echo $app->message->user->url; ?>">
                    <?php echo $app->message->user->name; ?>
                </a>
            </div>






    	</div>
    	<div class="col s12 m9 l9">
            <div class="message-subject"><?php echo $app->message->subject; ?></div>
            <div class="message-dates"><?php echo FormatDate($app->message->send_date); ?></div>
            <div class="message-message">
				<?php echo nl2br($app->message->message); ?>
			</div>
    	</div>
      <?php if($app->message->to_user==$app->user->email): ?>
          <div class="form-block message-buttons">
              <form method="post" class="form-post button-form-switch" action="<?php echo $app->request->getPath(); ?>">
                  <ul class="">
                  <?php if($app->message->location=='trash'): ?>
                  <!-- <button class="btn red darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-delete">
                      <i class="fa fa-trash"></i> Un-Delete
                  </button> -->
                  <?php else: ?>
                  <li>
                    <a class="btn btn-s btn-block" href="/messages/view-message/<?php echo $id; ?>/reply">
                      <i class="fa fa-reply"></i> Reply
                    </a>
                  <li>
                  <li>
                    <button class="btn btn-s btn-block" data-name="inboxaction[value]" data-value="delete">
                      <i class="fa fa-trash"></i> Delete
                    </button>
                </li>
                  <?php endif; ?>

                  <?php if($app->message->location!='trash'): ?>
                  <!-- <button class="btn grey btn-s btn-block" data-name="inboxaction[value]" data-value="markunread">
                      <i class="fa fa-check"></i> Mark As Un-Read
                  </button> -->
                  <?php endif; ?>


                  <?php if(isset($app->message->status__flagged)): ?>
                  <!-- <button class="btn blue darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-flag">
                      <i class="fa fa-flag"></i> Un-Flag Spam
                  </button> -->
                  <?php else: ?>
                  <!-- <button class="btn blue btn-s btn-block" data-name="inboxaction[value]" data-value="flag">
                      <i class="fa fa-flag"></i> Flag as Spam
                  </button> -->
                  <?php endif; ?>

                <li>
                  <?php if(isset($app->message->status__starred)): ?>
                  <button class="btn darken-2 btn-s btn-block" data-name="inboxaction[value]" data-value="un-star">
                      <i class="fa fa-star"></i> Un-Star
                  </button>
                  <?php else: ?>
                  <button class="btn btn-s btn-block" data-name="inboxaction[value]" data-value="star">
                      <i class="fa fa-star"></i> Star
                  </button>
                  <?php endif; ?>
                </li>
                  <input type="hidden" name="inboxaction[target]" value="inboxaction"  />
                  <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                </ul>
              </form>
          </div>
      <?php endif; ?>
    </div>

</div>

<?php if(isset($app->user->needs_bgcheck)): ?>
	&nbsp;
<?php elseif(isset($action) && $action=='reply' && $app->message->location=='inbox' && $app->message->to_user==$app->user->email): ?>

	<?php if(isset($app->user->creditcardonfile) || isset($app->user->validateactive)): ?>

		<?php

            $reply = new stdClass();
            $reply->subject = 'Reply: '.$app->message->subject;
            if(isset($app->message->parent_id)){
                $reply->extra = $app->message->parent_id;
            }
            else{
                $reply->extra = $id;
            }

			$messagingsystem = new Forms($app->connect);
			$messagingsystem->formname = 'messagingsystem';
			$messagingsystem->url = $app->message->user->url;
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
