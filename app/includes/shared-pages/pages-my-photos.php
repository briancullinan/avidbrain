<div class="my-photos">
	
	<h2>Uploads</h2>
	
	<?php if(isset($app->currentuser->my_upload)): ?>
	
		<?php if(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status=='verified'): ?>
			<div class="alert blue white-text">
				Your photo has been verified, if you delete it, it will have to be re-verified before it's public.
			</div>
		<?php endif; ?>
		
		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/crop-photo"><i class="fa fa-crop"></i> Crop Photo</a>
		<a class="button confirm-click" data-target="<?php echo $app->currentuser->url; ?>/my-photos/delete-photo" href="#delete"><i class="fa fa-trash"></i> Delete Photo</a>
		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/rotate-right"><i class="fa fa-rotate-right"></i> Rotate Right</a>
		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/rotate-left"><i class="fa fa-rotate-left"></i> Rotate Left</a>
		
		<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && file_exists(croppedfile($app->currentuser->my_upload)) && isset($app->currentuser->username)): ?>
			<?php if(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status=='needs-review'): ?>
				<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/approvephoto"><i class="fa fa-check"></i> <i class="fa fa-photo"></i> Approve Photo</a>
			<?php else: ?>
				<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/disapprovephoto"><i class="fa fa-ban"></i> <i class="fa fa-photo"></i> Dis-Approve Photo</a>
			<?php endif; ?>
		<?php endif; ?>
		
		<div class="image-preview">
			<?php if(isset($app->user->my_upload) && $app->user->my_upload_status!='verified'): ?>
			<div class="alert red white-text">
				Your photo needs to be approved before it's public. <a class="btn btn-s" href="/request-profile-review">Request Profile Review</a>
			</div>
			<?php endif; ?>
			<img class="responsive-img" src="<?php echo $app->currentuser->url.'/thumbnail'; ?>">
			
			<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && isset($app->currentuser->my_upload)): ?>
				<div>
					<div>Full Photo</div>
					<a href="<?php echo $app->currentuser->url.'/photo'; ?>" target="_blank"><img class="responsive-img" src="<?php echo $app->currentuser->url.'/photo'; ?>"></a>
				</div>
			<?php endif; ?>
			
		</div>
		
		
	<?php else: ?>
		<form enctype="multipart/form-data" action="<?php echo $app->currentuser->url; ?>" method="post" id="upload-photo-form">
			<input type="hidden" name="upload[width]" value="200" id="pagewidth"  />
			<input type="hidden" name="upload[target]" value="upload"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
			<input name="upload[file]" class="hide" id="upload-trigger" type="file" />
			<button id="select-photo" class="btn grey darken-1" type="button">
				<i class="fa fa-upload"></i> Upload Photo
			</button>
		</form>
	<?php endif; ?>
	
	<h2>Avatars</h2>
		
	<div class="basic-block">
		<form method="post" action="<?php echo $app->currentuser->url; ?>" id="myavatar">
			<div class="row">
				<?php foreach(get_avatars($app->dependents->DOCUMENT_ROOT) as $avatars): ?>
					<div class="col s6 m4 l4 avatar-clicks <?php if($app->currentuser->my_avatar==$avatars){ echo 'active-avatar';} ?>">
						<label>
							<img class="responsive-img circle" src="<?php echo $avatars; ?>" />
							<input <?php if($app->currentuser->my_avatar==$avatars){ echo 'checked="checked"';} ?> type="radio" name="myavatar[name]" value="<?php echo $avatars; ?>" />
						</label>
					</div>
				<?php endforeach; ?>
			</div>
			<input type="hidden" name="myavatar[target]" value="myavatar"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		</form>
	</div>
</div>
<?php
	#$img_canvas = $app->imagemanager->canvas(160, 160);
	#$img_canvas->fill($app->imagemanager->make($app->dependents->DOCUMENT_ROOT.'profiles/avatars/hair-brown.png'), 0, 0);
	#$img_canvas->fill($app->imagemanager->make($app->dependents->DOCUMENT_ROOT.'profiles/avatars/shirt-blue.png'), 0, 0);
	#$img_canvas->fill($app->imagemanager->make($app->dependents->DOCUMENT_ROOT.'profiles/avatars/base-white.png'), 0, 0);
	#$img_canvas->fill(Image::make('img/grey.jpg'), 100, 0); // add offset
	#$img_canvas->save($app->dependents->DOCUMENT_ROOT.'profiles/avatars/hamburger.png', 100);
?>