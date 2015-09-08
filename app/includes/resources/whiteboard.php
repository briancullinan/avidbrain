<div class="compose-box">
	<div class="row">
		<div class="col s12 m4 l4">
			<h3>Active Whiteboard Sessions</h3>
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
					You have no whiteboard sessions
				<?php endif; ?>
			</div>
		</div>
		<div class="col s12 m8 l8">
			<p>You can now schedule a whiteboard session with your students.</p>
			<ul class="collection">
				<li class="collection-item">
					xxx
				</li>
				<li class="collection-item">
					xxx
				</li>
				<li class="collection-item">
					xxx
				</li>
				<li class="collection-item">
					xxx
				</li>
				<li class="collection-item">
					xxx
				</li>
			</ul>
		</div>
	</div>
</div>