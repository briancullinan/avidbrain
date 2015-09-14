<?php if(isset($app->user->usertype) && $app->user->usertype=='tutor'): ?>
<p><button class="btn blue">Send <?php echo short($app->roominfo); ?> an invite to join your Whiteboard Session</button></p>
<?php endif; ?>

<div id="scribblar">
	<a href="//www.adobe.com/go/getflashplayer">This page requires the latest version of Adobe Flash. Please download it now.<br>
		<img src="//s3.amazonaws.com/media.muchosmedia.com/scribblar/assets/get_flash_player.gif" border="0" alt="Get Adobe Flash Player" />
	</a>

	<input type="hidden" class="scribblarusername" value="<?php echo $app->user->email; ?>" />
	<input type="hidden" class="scribblarroomid" value="<?php echo $app->roomid; ?>" />
</div>
	
