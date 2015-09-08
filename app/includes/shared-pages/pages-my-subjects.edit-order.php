<?php foreach($thesubjects as $key=> $subject):  ?>
	<div id="<?php echo $subject->parent_slug.'-'.$subject->subject_slug; ?>" class="block <?php if(isset($subject->status) && $subject->status=='needs-review'){ echo 'block-inactive'; } ?>" <?php if(isset($subject->sortorder)){ echo 'data-info="'.$subject->id.'"'; } ?> <?php if(isset($subject->sortorder)){ echo 'data-id="'.$subject->sortorder.'"'; } ?> >
		
		<?php if(isset($app->currentuser->thisisme)): ?>
			<div class="reorder-subjects"><i class="fa fa-reorder"></i></div>
		<?php endif; ?>
		<div class="title">
			<?php if(isset($subject->status) && $subject->status=='verified'): ?>
				<i class="mdi-maps-beenhere tooltipped verified-by" data-position="top" data-delay="50" data-tooltip="Verified By <?php echo $app->dependents->SITE_NAME_PROPPER; ?>"></i>
				  
			<?php endif; ?>
			<span class="blue white-text badge"><?php echo ucwords(str_replace('-',' ',$subject->parent_slug)); ?></span>
			<?php  echo $subject->subject_name; ?>
		</div>
		
		<form method="post" action="<?php echo $app->request->getPath(); ?>">
			
			<?php if(isset($subject->description_verified)): ?>
				<textarea name="mysubjects[description_verified]" class="materialize-textarea"><?php echo $subject->description_verified; ?></textarea>
			<?php else: ?>
				<textarea name="mysubjects[description]" class="materialize-textarea"><?php echo $subject->description; ?></textarea>
			<?php endif; ?>
			
			<input type="hidden" name="mysubjects[target]" value="mysubjects"  />
			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
			<input type="hidden" name="mysubjects[subject_name]" value="<?php echo $subject->subject_name; ?>"  />
			<?php if(isset($subject->parent_slug)): ?><input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $subject->parent_slug; ?>"  /><?php endif; ?>
			<input type="hidden" name="mysubjects[subject_slug]" value="<?php echo $subject->subject_slug; ?>"  />
			<?php if(isset($subject->id)): ?><input type="hidden" name="mysubjects[id]" value="<?php echo $subject->id; ?>"  /><?php endif; ?>
			
			<button type="submit" class="btn">Save</button>
			<button type="button" class="btn red confirm-submit" data-value="deleteme" data-name="mysubjects"> <i class="fa fa-trash"></i> Delete</button>
			
			<?php if(isset($subject->description_verified)): ?>
			<div class="alert blue white-text">
				<?php  echo $subject->subject_name; ?> has bee verified by <?php echo $app->dependents->SITE_NAME_PROPPER; ?>. If you modify it now, it will have to be re-verified before it's public.
			</div>
			<?php endif; ?>
			
		</form>
		
		<?php if(isset($app->user->usertype) && $app->user->usertype=='admin' && empty($subject->description_verified)): ?>
			<div class="hr"></div>
			<form method="post" action="<?php echo $app->request->getPath(); ?>">
				
				<textarea name="approvesubjects[description]" class="hide"><?php echo $subject->description; ?></textarea>
				
				<button type="submit" class="btn blue">
					Approve Subject
				</button>
				
				<input type="hidden" name="approvesubjects[target]" value="mysubjects"  />
				<input type="hidden" name="approvesubjects[subject_name]" value="<?php echo $subject->subject_name; ?>"  />
				<?php if(isset($subject->parent_slug)): ?><input type="hidden" name="approvesubjects[parent_slug]" value="<?php echo $subject->parent_slug; ?>"  /><?php endif; ?>
				<input type="hidden" name="approvesubjects[subject_slug]" value="<?php echo $subject->subject_slug; ?>"  />
				<?php if(isset($subject->id)): ?><input type="hidden" name="approvesubjects[id]" value="<?php echo $subject->id; ?>"  /><?php endif; ?>
				
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">	
			</form>
		<?php endif; ?>
		
	</div>
<?php endforeach; ?>