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
	
	<!-- Custom Avatars -->
	<h2>Custom Avatar</h2>
	<link rel="stylesheet" href="/css/customize-avatar.css" />	
	
	<div class="block">
		
		
		<div class="row my-avatar-container">
			
			
			<div class="col s12 m12 l6">
				<div class="my-avatar">
					<div class="icon-user">
						<div class="custom-avatar custom-avatar-body"></div>
						<div class="custom-avatar custom-avatar-ears-shadow"></div>
						<div class="custom-avatar custom-avatar-lips-01"></div>
					</div>
				</div>
			</div>
			
			<div class="col s12 m12 l6">
				<div>Select a skin tone:</div>
				
				<div class="select-skin-tone">
					<div class="default"></div>
					<div class="peaches"></div>
					<div class="blue"></div>
					<div class="green"></div>
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
				
				<div>
					<div>Add some facial hair</div>
					<div class="add-some" id="facialhair">
						<div class="empty"><i class="fa fa-times"></i></div>
						<?php foreach(range(1,6) as $facialhair): ?>
							<div class="custom-avatar custom-avatar-beard-<?php echo str_pad($facialhair, 2, '0', STR_PAD_LEFT); ?>"></div>
						<?php endforeach; ?>
					</div>
				</div>
				
				
				
			</div>
			
		</div>
		
	</div>
	<!-- Custom Avatars -->
	
</div>


<style type="text/css">
.custom-avatar-ears-shadow{
	color: #000;
	opacity: .2;
}
.empty{
	width: 72px;
	height: 72px;
	float: left;
	color: red;
	text-align: center;
	font-size: 45px;
	border: solid 1px #ccc;
	margin-right: 2px;
	margin-bottom: 2px;
	cursor: pointer;
}
.add-some{
	width: 100%;
	float: left;
	position: relative;
}
.add-some .custom-avatar{
	cursor: pointer;
	width: 72px;
	height: 72px;
	float: left;
	display: inline-block;
	display: block;
	font-size: 70px;
	background: #efefef;
	position: relative;
	margin-right: 2px;
	margin-bottom: 2px;
	border: solid 1px #ccc;
}
.default{
	background: #222;
}
#default{
	color: #222;
}
.peaches{
	background: #EDD9B4;
}
#peaches{
	color: #EDD9B4;
}
.blue{
	background: #EDD9B4;
}
#blue{
	color: #2196F3;
}
.green{
	background: #4CAF50;
}
#green{
	color: #4CAF50;
}
.select-skin-tone{
	float: left;
	width: 100%;
}
.select-skin-tone div{
	float: left;
	width: 50px;
	height: 50px;
	margin-right: 1px;
}

.custom-avatar.active{
	border: solid 1px #f11900;
}
</style>


<script type="text/javascript">
	
	$(document).ready(function() {
		$('.select-skin-tone div').on('click',function(){
			var skintone = $(this).attr('class');
			$('.custom-avatar-body').attr('id','').attr('id',skintone);
		});
		
		$('.add-some div').on('click',function(){
			
			var parentid = $(this).parent().attr('id');
			var thisitem = $(this).attr('class');
			
			$('#'+parentid+' .active').removeClass('active');
			$(this).addClass('active');
			
			$('#addme-'+parentid).remove();
			
			if(thisitem=='empty'){
				
			}
			else{
				$('.icon-user').append('<div id="addme-'+parentid+'" class="'+thisitem+'"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');	
			}
			$('.icon-user .active').removeClass('active');
			
			$('html, body').animate({scrollTop: $(".my-avatar").offset().top - 100}, 300);
			
		});
		
		
		
	});
	
</script>