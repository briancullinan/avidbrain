<div class="avatarbg my-avatar edit-avatar">
	<div class="icon-user">
		<div class="custom-avatar custom-avatar-body" <?php if(isset($customavatar->skintoneid)){ echo 'id="'.$customavatar->skintoneid.'"'; }  if(isset($customavatar->skintonecolor)){ echo 'style="'.$customavatar->skintonecolor.'"'; } ?> ></div>
		<div class="custom-avatar custom-avatar-ears-shadow"></div>
		<div class="custom-avatar addhair <?php if(isset($customavatar->hairtype)){ echo $customavatar->hairtype; } ?>" <?php if(isset($customavatar->addhairid)){ echo 'id="'.$customavatar->addhairid.'"'; }  if(isset($customavatar->addhaircolor)){ echo 'style="'.$customavatar->addhaircolor.'"'; } ?>></div>
		<div class="custom-avatar addshirts <?php if(isset($customavatar->shirtype)){ echo $customavatar->shirtype; } ?>">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="custom-avatar addglasses <?php if(isset($customavatar->glasstype)){ echo $customavatar->glasstype; } ?>">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
		<div class="custom-avatar addlips "></div>
		<div class="custom-avatar addfacialhair <?php if(isset($customavatar->facialhairtype)){ echo $customavatar->facialhairtype; } ?>" <?php if(isset($customavatar->addfacialhairid)){ echo 'id="'.$customavatar->addfacialhairid.'"'; }  if(isset($customavatar->addfacialhaircolor)){ echo 'style="'.$customavatar->addfacialhaircolor.'"'; } ?>></div>
	</div>
</div>