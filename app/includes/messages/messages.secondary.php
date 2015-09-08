<?php if(isset($app->trashmessages)): ?>
	
	
	<form method="post" action="<?php echo $app->request->getPath(); ?>">
	
		<button type="button" class="btn btn-block red confirm-submit" data-value="empty-trash" data-name="trashcan">Empty Trash</button>
		
		<input type="hidden" name="trashcan[target]" value="trashcan"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		
	</form>
	
<?php endif; ?>