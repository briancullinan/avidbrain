<p>You have <span class="blue-text"><?php echo count($app->import); ?></span> existing job posts. You can either import or delete them.</p>

<?php
	function getsubjectid($connect,$jobinfo){
		$sql = "SELECT id FROM avid___available_subjects WHERE subject_slug = :subject_slug AND parent_slug = :parent_slug";
		$prepare = array(':subject_slug'=>$jobinfo->subject_slug,':parent_slug'=>$jobinfo->parent_slug);
		$results = $connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->id)){
			return $results->id;
		}
	}
?>

<?php foreach($app->import as $import): ?>
	<div class="box">
		<form class="form-post importexport" method="post" action="<?php echo $app->request->getPath(); ?>" >
			<div class="title"><?php echo $import->subject_name; ?></div>
			<div class="row">
				<div class="col s12 m6 l6">
					<?php if(isset($import->description)): ?>
					<div><?php echo $import->description; ?></div>
					<?php else: ?>
					<textarea name="importstatus[description]" class="materialize-textarea" placeholder="Please enter a description"></textarea>
					<?php endif; ?>
					<div>Allow Job Requests? <?php echo $import->allow_job_requests; ?></div>
					<div><?php echo $import->description; ?></div>
					<div>Last Modified: <?php echo formatdate($import->last_modified); ?></div>
				</div>
				<div class="col s12 m6 l6 form-submit">
					
						
						<input type="hidden" name="importstatus[subject_name]" value="<?php echo $import->subject_name; ?>"  />
						<?php if(!empty($import->description)): ?>
						<input type="hidden" name="importstatus[description]" value="<?php echo $import->description; ?>"  />
						<?php endif; ?>
						<input type="hidden" name="importstatus[allow_job_requests]" value="<?php echo $import->allow_job_requests; ?>"  />
						<input type="hidden" name="importstatus[subject_slug]" value="<?php echo $import->subject_slug; ?>"  />
						<input type="hidden" name="importstatus[parent_slug]" value="<?php echo $import->parent_slug; ?>"  />
						<input type="hidden" name="importstatus[last_modified]" value="<?php echo $import->last_modified; ?>"  />
						<input type="hidden" name="importstatus[status]" value="<?php echo $import->status; ?>"  />
						<input type="hidden" name="importstatus[id]" value="<?php echo $import->id; ?>"  />
						<input type="hidden" name="importstatus[sortorder]" value="<?php echo $import->sortorder; ?>"  />
						<input type="hidden" name="importstatus[subject_id]" value="<?php echo getsubjectid($app->connect,$import); ?>"  />
	
						<input type="hidden" name="importstatus[target]" value="importstatus"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
						
						<button type="submit" class="btn">Import</button>
						<button type="button" class="btn red confirm-submit" data-name="importstatus" data-value="delete">Delete</button>
						
					
				</div>
			</div>
		</form>	
	</div>
<?php endforeach; ?>