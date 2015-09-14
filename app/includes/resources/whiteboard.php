<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Whiteboard Sessions</h3>
			<div class="compose-list center-align white">
				<?php if(isset($app->getroomdata)): ?>
				<?php foreach($app->getroomdata as $compose): ?>
					<div class="compose-item <?php if(isset($username) && $compose->username==$username){ echo 'active'; } ?>" id="/resources/whiteboard/<?php echo $compose->roomid; ?>">
						<div class="row">
							<div class="col s12 m3 l3">
								<div class="avatar">
									<?php echo show_avatar($compose,$user=$app->user,$app->dependents); ?>
								</div>
							</div>
							<div class="col s12 m9 l9">
								<div class="user-name">
									<div><?php echo $compose->session_subject; ?></div>
									<div><?php echo formatdate($compose->session_timestamp,'M. jS, Y @ g:i a'); ?></div>
									<div><?php echo the_users_name($compose); ?></div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<?php else: ?>
					<p>You have no whiteboard sessions</p>
					<p><a href="/sessions/setup-new">Schedule A Whiteboard Session</a></p>
				<?php endif; ?>
			</div>
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