<div class="row">
	<div class="col s12 m3 l3">
		<?php if(isset($app->categories[0])): ?>
			<?php foreach($app->categories as $categories): ?>
				<a class="btn btn-block btn-s blue <?php if(isset($category) && $category==$categories->parent_slug){ echo ' active ';} ?>" href="/admin-everything/manage-subjects/<?php echo $categories->parent_slug; ?>">
					<?php echo $categories->subject_parent; ?>
				</a>
			<?php endforeach; ?>
			<a class="btn btn-block green" href="/admin-everything/manage-subjects/addcat"> <i class="fa fa-plus"></i> Add Category</a>
			<?php if(isset($category) && isset($app->subjects)): ?>
			<a class="btn btn-block orange" href="/admin-everything/manage-subjects/<?php echo $category; ?>/addsubject"> <i class="fa fa-plus"></i> Add Subject</a>
			<?php endif; ?>
		<?php else: ?>
			There are no categories
		<?php endif; ?>
	</div>
	<div class="col s12 m9 l9">
		
		<?php if(isset($app->subjects)): ?>
		
			<?php
				$zero = $app->subjects[0];
			?>
		
			<?php if(isset($action) && $action=='addsubject'): ?>
			<h3>Add New Subject</h3>
			<div class="block" style="border: solid 5px #54bf00;">
				<form method="post" action="<?php echo $app->request->getPath(); ?>" id="new">
					
					<div class="input-field">
						<input id="new-subject_name" name="addnewsubject[subject_name]" type="text" value="" class="validate">
						<label for="new-subject_name">
							Subject Name
						</label>
					</div>
					
					<div class="input-field">
						<input id="new-keywords" name="addnewsubject[keywords]" type="text" class="validate" value="">
						<label for="new-keywords">
							Keywords. Comma delimited 
						</label>
					</div>

					<div class="input-field">
						<textarea id="new-description"  name="addnewsubject[description]" class="materialize-textarea"></textarea>
						<label for="new-description">Description</label>
					</div>
					
					
					<input type="hidden" class="validate"  name="addnewsubject[subject_parent]" value="<?php echo $zero->subject_parent; ?>">
					<input type="hidden" class="validate"  name="addnewsubject[parent_slug]" value="<?php echo $category; ?>">
					<input type="hidden" name="addnewsubject[target]" value="addnewsubject"  />
					<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
					
					<div class="form-submit">
						<button class="btn btn-s blue" type="submit">
							Add New Subject
						</button>		
					</div>
					
				</form>
			</div>
			<?php endif; ?>
		
			<?php foreach($app->subjects as $subjects): ?>
				<div class="block">
					<form method="post" action="<?php echo $app->request->getPath(); ?>" id="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>">
						
						<div class="input-field">
							<input id="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-subject_name" name="managesubjects[subject_name]" type="text" value="<?php echo $subjects->subject_name; ?>" class="validate">
							<label for="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-subject_name">
								Subject Name
							</label>
						</div>
						
						<div class="input-field">
							<input id="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-keywords" name="managesubjects[keywords]" type="text" class="validate" value="<?php echo $subjects->keywords; ?>">
							<label for="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-keywords">
								Keywords. Comma delimited 
							</label>
						</div>
	
						<div class="input-field">
							<textarea id="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-description"  name="managesubjects[description]" class="materialize-textarea"><?php echo $subjects->description; ?></textarea>
							<label for="<?php echo $subjects->parent_slug.$subjects->subject_slug; ?>-description">Description</label>
						</div>
						
						<input id="subject_slug" type="hidden" class="validate"  name="managesubjects[subject_slug]" value="<?php echo $subjects->subject_slug; ?>">
						<input id="parent_slug" type="hidden" class="validate"  name="managesubjects[parent_slug]" value="<?php echo $subjects->parent_slug; ?>">
						<input id="id" type="hidden" class="validate"  name="managesubjects[id]" value="<?php echo $subjects->id; ?>">
						<input type="hidden" name="managesubjects[target]" value="managesubjects"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						
						<div class="form-submit">
							<button class="btn btn-s blue" type="submit">
								Save
							</button>
							<a href="#" class="confirm-click btn btn-s red" data-target="/admin-everything/manage-subjects/<?php echo $category; ?>/delete--<?php echo $subjects->id; ?>">Delete</a>
						</div>
						
					</form>
					
				</div>
			<?php endforeach; ?>
		<?php elseif(isset($category) && $category=='addcat'): ?>
			<h3>
				Add Category
			</h3>
			<div class="block" style="border: solid 5px #5ace00;">
				<form method="post" action="<?php echo $app->request->getPath(); ?>">
	
				<div class="input-field">
					<input id="textid" name="addcategory[name]" type="text" class="validate">
					<label for="textid">
						Category Name
					</label>
				</div>
				
				<input type="hidden" name="addcategory[target]" value="addcategory"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				
				<div class="form-submit">
					<button class="btn blue" type="submit">
						Add
					</button>		
				</div>
				
			</form>
			</div>
		<?php else: ?>
			Please select a category from the left
		<?php endif; ?>
	</div>
</div>