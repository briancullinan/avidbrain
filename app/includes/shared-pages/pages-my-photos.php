
<div class="my-photos">

	<h2>Choose Your Image</h2>
	<div class="block">
		<div>Please select what you would like to show up on your profile.</div>




		<form method="post" action="<?php echo $app->request->getPath(); ?>">

			<input type="hidden" name="defaultphototype[target]" value="defaultphototype"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

			<div>
				<?php if(isset($app->currentuser->my_upload)): ?>
				<p>
					<input type="radio" id="myupload" name="defaultphototype[type]" value="1" <?php if(isset($app->currentuser->showmyphotoas) && $app->currentuser->showmyphotoas==1){ echo 'checked="checked"';} ?> />
					<label for="myupload">My Upload</label>
				</p>
				<?php endif; ?>
				<p>
					<input type="radio" id="selectedavatar" name="defaultphototype[type]" value="2" <?php if(isset($app->currentuser->showmyphotoas) && $app->currentuser->showmyphotoas==2){ echo 'checked="checked"';} ?> />
					<label for="selectedavatar">Selected Avatar</label>
				</p>
				<?php if(isset($app->currentuser->custom_avatar)): ?>
				<p>
					<input type="radio" id="customavatar" name="defaultphototype[type]" value="3" <?php if(isset($app->currentuser->showmyphotoas) && $app->currentuser->showmyphotoas==3){ echo 'checked="checked"';} ?> />
					<label for="customavatar">Custom Avatar</label>
				</p>
				<?php endif; ?>
			</div>
			<br>
			<button class="btn blue" type="submit">Set Image Type</button>

		</form>

	</div>


	<h2>Uploads</h2>


	<?php if(isset($app->currentuser->my_upload)): ?>

		<?php if(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status!='verified' && isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
			<div class="alert red white-text">Please Dis-Approve Photo, Then Re-Approve Photo</div>
		<?php elseif(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status=='verified'): ?>
			<div class="alert blue white-text">
				Your photo has been verified, if you delete it, it will have to be re-verified before it's public.
			</div>
		<?php endif; ?>

		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/crop-photo"><i class="fa fa-crop"></i> Crop Photo</a>
		<a class="button confirm-click" data-target="<?php echo $app->currentuser->url; ?>/my-photos/delete-photo" href="#delete"><i class="fa fa-trash"></i> Delete Photo</a>
		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/rotate-right"><i class="fa fa-rotate-right"></i> Rotate Right</a>
		<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/rotate-left"><i class="fa fa-rotate-left"></i> Rotate Left</a>

		<?php if(isset($app->user->usertype) && $app->user->usertype=='admin'): ?>
			<?php if(isset($app->currentuser->my_upload) && $app->currentuser->my_upload_status=='needs-review'): ?>
				<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/approvephoto"><i class="fa fa-check"></i> <i class="fa fa-photo"></i> Approve Photo</a>
			<?php else: ?>
				<a class="button" href="<?php echo $app->currentuser->url; ?>/my-photos/disapprovephoto"><i class="fa fa-ban"></i> <i class="fa fa-photo"></i> Dis-Approve Photo</a>
			<?php endif; ?>
		<?php endif; ?>

		<div class="image-preview">
			<?php if(isset($app->user->my_upload) && $app->user->my_upload_status!='verified'): ?>
			<div class="alert red white-text">
				Your photo needs to be approved before it's public. <a class="btn black btn-s" href="/request-profile-review">Request Photo Review</a>
			</div>
			<?php endif; ?>
			<div class="user-photograph">
				<img class="responsive-img" src="/image/photograph/cropped/<?php echo $app->currentuser->username; ?>">
			</div>

			<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && isset($app->currentuser->my_upload)): ?>
				<div>
					<div>Full Photo</div>

					<a href="/image/photograph/<?php echo $app->currentuser->username; ?>" target="_blank"><img class="responsive-img" src="/image/photograph/<?php echo $app->currentuser->username; ?>"></a>
				</div>
			<?php endif; ?>

		</div>


	<?php else: ?>


		<form enctype="multipart/form-data" action="<?php echo $app->currentuser->url; ?>" method="post" id="upload-photo-form">
			<input type="hidden" name="upload[width]" value="200" id="pagewidth"  />
			<input type="hidden" name="upload[target]" value="upload"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
			<input name="upload[file]" class="hide upload-trigger" type="file" />
			<button class="select-item btn grey darken-1" type="button" data-text = "Uploading Photo">
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

	<?php if(isset($app->customavatars)): ?>
	<!-- Custom Avatars -->
	<h2>Custom Avatar</h2>

	<div class="block">


		<div class="row my-avatar-container">

			<div class="col s12 m12 l12 center-align the-final-avatar">

					<?php

						$customavatar = json_decode($app->currentuser->custom_avatar);
						include($app->dependents->APP_PATH.'includes/user-profile/custom-avatar.php');


					?>
			</div>

			<div class="col s12 m12 l12">
				<div>Select a skin tone:</div>

				<div class="swap-color-type" data-target="custom-avatar-body">
					<div class="default"></div>
					<div class="blue"></div>
					<div class="green"></div>
					<div class="orange"></div>
					<div class="red"></div>
					<div class="yellow"></div>
					<input type="color" class="html5colorpicker" value="#EDD9B4"  />
				</div>

				<div>
					<div>Add A Shirt</div>
					<div class="add-some" id="shirts">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,19) as $shirts): ?>
							<div class="custom-avatar custom-avatar-shirt-<?php echo str_pad($shirts, 2, '0', STR_PAD_LEFT); ?>">
								<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div>
					<div>Add Glasses</div>
					<div class="add-some" id="glasses">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,5) as $glasses): ?>
							<div class="custom-avatar custom-avatar-glasses-<?php echo str_pad($glasses, 2, '0', STR_PAD_LEFT); ?>">
								<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div>
					<div>Add some hair</div>
					<div class="add-some" id="hair">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,7) as $hair): ?>
							<div class="custom-avatar custom-avatar-hair-<?php echo str_pad($hair, 2, '0', STR_PAD_LEFT); ?>"></div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swap-color-type" data-target="addhair">
					<div class="default"></div>
					<div class="blue"></div>
					<div class="green"></div>
					<div class="orange"></div>
					<div class="red"></div>
					<div class="yellow"></div>
					<input type="color" class="html5colorpicker" value="#EDD9B4"  />
				</div>

				<div>
					<div>Add some facial hair</div>
					<div class="add-some" id="facialhair">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,6) as $facialhair): ?>
							<div class="custom-avatar custom-avatar-beard-<?php echo str_pad($facialhair, 2, '0', STR_PAD_LEFT); ?>"></div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="swap-color-type" data-target="addfacialhair">
					<div class="default"></div>
					<div class="blue"></div>
					<div class="green"></div>
					<div class="orange"></div>
					<div class="red"></div>
					<div class="yellow"></div>
					<input type="color" class="html5colorpicker" value="#EDD9B4"  />
				</div>

				<div>
					<div>Add Lips</div>
					<div class="add-some" id="lips">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,1) as $lips): ?>
							<div class="custom-avatar custom-avatar-lips-<?php echo str_pad($lips, 2, '0', STR_PAD_LEFT); ?>"></div>
						<?php endforeach; ?>
					</div>
				</div>

				<form id="submit-avatar" class="form-post" method="post" action="<?php echo $app->request->getPath(); ?>">

					<input type="hidden" name="customizeavatar[target]" value="customizeavatar"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

				</form>

			</div>

		</div>

	</div>
	<!-- Custom Avatars -->
	<?php endif; ?>

</div>
