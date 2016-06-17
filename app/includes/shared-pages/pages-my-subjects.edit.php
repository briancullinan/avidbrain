<?php

	$sql = "SELECT subject_parent,parent_slug FROM avid___available_subjects GROUP BY parent_slug";
	$prepeare = array();
	$app->subjectcategories = $app->connect->executeQuery($sql,$prepeare)->fetchAll();

	if(isset($category)){

		$app->subjects = $app->connect->createQueryBuilder()
			->select('subjects.*')->from("avid___available_subjects",'subjects')
			//->addSelect('usub.email')->from("avid___user_subjects",'usub')
			->where("subjects.parent_slug = :parent_slug")->setParameter(':parent_slug',$category)
			->execute()->fetchAll();

			//printer($app->subjects);

	}

	if(isset($subject)){
		$sql = "SELECT * FROM avid___available_subjects WHERE subject_slug = :subject_slug AND parent_slug = :parent_slug";
		$prepeare = array(':subject_slug'=>$subject,':parent_slug'=>$category);
		$app->subjectinfo = $app->connect->executeQuery($sql,$prepeare)->fetch();


		$sql = "
			SELECT
				*
			FROM
				avid___user_subjects
			WHERE
				subject_slug = :subject_slug
					AND
				parent_slug = :parent_slug
					AND
				email = :email
		";
		$prepeare = array(
			':subject_slug'=>$subject,
			':parent_slug'=>$category,
			':email'=>$app->user->email,
		);
		$app->mysubjectinfo = $app->connect->executeQuery($sql,$prepeare)->fetch();
	}

	$app->alltherest = $app->connect->createQueryBuilder()->select("*")->from("avid___user_subjects")
		->where("email = :email")->setParameter(":email",$app->user->email)
		->andWhere("status = :status")->setParameter(":status","needs-review")
		->orderBy("sortorder","ASC")->execute()->fetchAll();

		//printer($app->alltherest);

?>
<h3><i class="fa fa-plus"></i> Add A Tutored Subject</h3>
<p>Select from the drop-down, or start typing in the text box below to find your subject.</p>
<div class="type-subject">
	<input type="text" placeholder="Start typing a subject name" class="find-a-subject" data-location="<?php echo $app->currentuser->url; ?>" />
</div>
<select class="browser-default change-sujbects">
	<option data-value="">Select a category</option>
<?php foreach($app->subjectcategories as $subjectcategories): ?>
	<?php $jump = $app->currentuser->url.'/my-subjects/'.$subjectcategories->parent_slug; ?>
	<option <?php if(isset($category) && $category==$subjectcategories->parent_slug){ echo 'selected="selected"';} ?> data-value="<?php echo $jump; ?>">
		<?php echo $subjectcategories->subject_parent; ?>
	</option>
<?php endforeach; ?>
</select>

<?php if(isset($app->subjects)): ?>
<select class="browser-default change-sujbects">
	<option data-value="">Select a subject</option>
<?php foreach($app->subjects as $subjects): ?>
	<?php $jump2 = $app->currentuser->url.'/my-subjects/'.$category.'/'.$subjects->subject_slug; ?>
	<option <?php if(isset($subject) && $subject==$subjects->subject_slug){ echo 'selected="selected"';} ?> data-value="<?php echo $jump2; ?>">
		<?php echo $subjects->subject_name; ?>
	</option>
<?php endforeach; ?>
</select>
<?php endif; ?>

<p></p>
<?php if(isset($category) && isset($subject) && empty($app->mysubjectinfo->description)): ?>
	<div class="basic-block">
		<div class="">
			<?php echo $app->subjectinfo->subject_name; ?>
		</div>

		<div>
			<form method="post" action="<?php echo $app->request->getPath(); ?>">

				<textarea name="mysubjects[description]" class="materialize-textarea" placeholder="Write about why you tutor this subject"><?php
					if(isset($app->mysubjectinfo->description)){
						echo $app->mysubjectinfo->description;
					}
				?></textarea>
				<input type="hidden" name="mysubjects[target]" value="mysubjects"  />
				<input type="hidden" name="mysubjects[subject_name]" value="<?php echo $app->subjectinfo->subject_name; ?>"  />
				<input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $app->subjectinfo->parent_slug; ?>"  />
				<input type="hidden" name="mysubjects[subject_slug]" value="<?php echo $app->subjectinfo->subject_slug; ?>"  />
				<input type="hidden" name="mysubjects[id]" value="<?php echo $app->subjectinfo->id; ?>"  />
				<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
				<div>
					<button class="btn" type="submit">
						Save
					</button>
				</div>

			</form>
		</div>

	</div>
	<div class="hr"></div>
<?php elseif(isset($category) && isset($subject) && isset($app->mysubjectinfo->description)): ?>

	<div class="active-subject-block" data-id="<?php echo $app->mysubjectinfo->parent_slug.'-'.$app->mysubjectinfo->subject_slug; ?>"></div>

<?php endif; ?>

<?php if(isset($app->currentuser->my_subjects[0])): ?>
	<h2>Approved Subjects</h2>
	<div id="approvedsubjects">
		<?php $thesubjects = $app->currentuser->my_subjects; include('pages-my-subjects.edit-order.php'); ?>
	</div>
	<div class="hr"></div>

	<form class="form-post hide" method="post" action="<?php echo $app->request->getPath(); ?>" id="approvedsortorder">
		<input type="hidden" name="subjectorder[target]" value="subjectorder"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		<div class="theorder"></div>
	</form>

<?php endif; ?>

<?php if(isset($app->alltherest[0])): ?>
	<h2>Non-Approved Subjects</h2>
	<div id="unapprovedsubjects">
		<?php $thesubjects = $app->alltherest; include('pages-my-subjects.edit-order.php'); ?>
	</div>

	<form class="form-post hide" method="post" action="<?php echo $app->request->getPath(); ?>" id="unapprovedsortorder">
		<input type="hidden" name="subjectorder[target]" value="subjectorder"  />
		<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
		<div class="theorder"></div>
	</form>
<?php endif; ?>
