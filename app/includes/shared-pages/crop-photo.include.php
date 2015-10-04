<h1>Crop Your Photo</h1>

<p>
	<div id="cropbox" data-image="<?php echo $app->currentuser->url.'/photo'; ?>"><img src="<?php echo $app->currentuser->url.'/photo'; ?>"></div>
</p>
<form id="cropform" action="<?php echo $app->currentuser->url; ?>/my-photos/crop-photo" method="post">
	<input type="hidden" id="x" name="crop[x]" />
	<input type="hidden" id="y" name="crop[y]" />
	<input type="hidden" id="w" name="crop[w]" />
	<input type="hidden" id="h" name="crop[h]" />
	
	<input type="hidden" name="crop[target]" value="crop"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
	
	<button type="submit" class="btn btn-success">
		Crop Photo
	</button>	
</form>