<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Whiteboard Sessions</h3>
			<?php if(isset($app->getroomdata)): ?>
				<div class="new-order-list">
				<?php foreach($app->getroomdata as $getroomdata): ?>
					<div class="block-list-user <?php if(isset($username) && $username == $getroomdata->roomid){ echo 'active';} ?>">
						<a class="block-list" href="/resources/whiteboard/<?php echo $getroomdata->roomid; ?>">

							<?php echo $getroomdata->session_subject; ?><br/>
							<?php echo formatdate($getroomdata->session_timestamp,'M. jS, Y @ g:i a'); ?><br/>
							<?php echo the_users_name($getroomdata); ?>

						</a>
					</div>
				<?php endforeach; ?>
				</div>
			<?php else: ?>
				You have no white board sessions
			<?php endif; ?>
		</div>
		<div class="col s12 m8 l8">
			<h3>Whiteboard Features</h3>
			<ul class="collection">
				<li class="collection-item">
					Chat, audio, virtual whiteboards
				</li>
				<li class="collection-item">
					Simple, safe, stable
				</li>
				<li class="collection-item">
					Perfect for online tutoring
				</li>
				<li class="collection-item">
					<div>Example Whiteboard</div>
					<img src="/images/scribblar-example.jpg" class="responsive-img" />
				</li>
			</ul>
		</div>
	</div>
</div>
