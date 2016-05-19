<div class="box">
	<form method="post" action="<?php echo $app->request->getPath(); ?>">
		<div class="row">
			<div class="">

					<div class="col s12 m4 l4">
							<label for="textid">
								Start Date
							</label>
							<input type="date" name="findstudent[startdate]" class="validate" placeholder="MM/DD/YYYY"
								value="<?php if(isset($app->findstudent->startdate)){ echo $app->findstudent->startdate;} ?>" >
					</div>
					<div class="col s12 m4 l4">
						<label for="textid">
							End Date
						</label>
						<input type="date" name="findstudent[enddate]" class="validate" placeholder="MM/DD/YYYY"
							value="<?php if(isset($app->findstudent->enddate)){ echo $app->findstudent->enddate;}?>" >
					</div>
					<div class="col s12 m4 l4">
						<input type="hidden" name="findstudent[target]" value="findstudent"  />
						<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

						<div class="form-submit">
							<button class="btn blue" type="submit">
								Search
							</button>
						</div>
					</div>

		</div>

	</form>
</div>

<?php
  $title_range =  " ";

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select(" id,
													DATE_FORMAT(signup_date,'%m/%d/%Y') as signup_date,
													first_name,
													last_name,
													city,
													state,
													url,
													DATE_FORMAT(last_active,'%m/%d/%Y') as last_active"
										)->from('avid___user','user');


	$data	=	$data->where("  usertype = 'student' AND signup_date IS NOT NULL AND usertype = 'student'  ");
	if(isset($app->findstudent->startdate) && isset($app->findstudent->enddate))
	{
		$title_range = $app->findstudent->startdate." to ".$app->findstudent->enddate;
		$data	=	$data->andwhere(" signup_date IS NOT NULL AND signup_date BETWEEN :startdate AND :enddate ");
	  $data	=	$data->setParameter(':startdate',$app->findstudent->startdate);
	  $data	=	$data->setParameter(':enddate',$app->findstudent->enddate);

	}else{

			$title_range =  " the last month.";
		$data	=	$data->andwhere(" signup_date BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() ");
	}

	$data	=	$data->orderBy('id','DESC');
	$studentsignups	=	$data->execute()->fetchAll();


	$sql = " SELECT COUNT(u.id) as numStudents FROM avid___user u
					INNER JOIN avid___jobs j ON u.email = j.email
					WHERE  signup_date IS NOT NULL AND usertype = 'student' ";


	if(isset($app->findstudent->startdate) && isset($app->findstudent->enddate))
	{
		$title_range = "From ".$app->findstudent->startdate." to ".$app->findstudent->enddate.":";
		$sql =  $sql." AND signup_date BETWEEN :startdate AND :enddate ";
		$prepare = array(':startdate' => $app->findstudent->startdate
											,':enddate' => $app->findstudent->enddate);

	}else{

			$title_range =  "For last month.";
			$sql =  $sql." AND signup_date BETWEEN NOW() - INTERVAL 1 MONTH AND NOW()  ";
			$prepare = array();
	}
			$studentsignupsWithJobs	=	$app->connect->executeQuery($sql,$prepare)->fetchAll();


?>
<h5>
	 <?php echo $title_range;  ?> <br/>
	 <?php echo count($studentsignups); ?> student signed up <br/>
	 <?php echo $studentsignupsWithJobs[0]->numStudents; ?> students posted jobs

 </h5>	<br/>
    <div class="row">
					<b>
					<div class="col s12 m2 l2">
							 Signup Date
					</div>
					<div class="col s12 m4 l4">
								First & Last Name
					</div>
					<div class="col s12 m2 l2">
							City
					</div>
					<div class="col s12 m1 l1">
						  State
					</div>
					<div class="col s12 m2 l2">
					 	 Last active
					</div>
				</b>
				</div>
		<?php if(isset($studentsignups)): ?>
			<?php foreach($studentsignups as $value): ?>
			<div class="row">
				<div class="col s12 m2 l2">
							<div>  <?php echo $value->signup_date; ?></div>
				</div>
				<div class="col s12 m4 l4">
							<div><a href="<?php echo $value->url; ?>">  <?php echo $value->first_name.' '.$value->last_name; ?></a></div>
				</div>
				<div class="col s12 m2 l2">
							<div>  <?php echo $value->city; ?></div>
				</div>
				<div class="col s12 m1 l1">
						<div>  <?php echo $value->state; ?></div>
				</div>
				<div class="col s12 m2 l2">
						<div>  <?php echo $value->last_active;?></div>
				</div>
			</div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no students
		<?php endif; ?>
