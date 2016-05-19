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

	$sql = " SELECT

									affiliates.mycode as mycode,
									user.first_name as first_name,
									user.last_name as last_name,
									DATE_FORMAT(affiliates.date,'%m/%d/%Y') as date ,
									DATE_FORMAT(affiliates.lastlogin,'%m/%d/%Y') as lastlogin ,
									user.id as userid,
									affiliates.email as email,
									user.usertype,
									user.url
							FROM
									avid___affiliates affiliates
							LEFT JOIN
									avid___user user on user.email = affiliates.email
							WHERE  affiliates.date IS NOT NULL ";


	if(isset($app->findstudent->startdate) && isset($app->findstudent->enddate))
	{
		$title_range = "From ".$app->findstudent->startdate." to ".$app->findstudent->enddate.":";
		$sql =  $sql." AND affiliates.date BETWEEN :startdate AND :enddate ";
		$prepare = array(':startdate' => $app->findstudent->startdate
											,':enddate' => $app->findstudent->enddate);

	}else{

			$title_range =  "For last month.";
			$sql =  $sql." AND affiliates.date  BETWEEN NOW() - INTERVAL 1 MONTH AND NOW()  ";
			$prepare = array();
	}
			$sql =  $sql." ORDER BY affiliates.id DESC ";
			$affiliatesignups	=	$app->connect->executeQuery($sql,$prepare)->fetchAll();

?>
<h5>
	 <?php echo $title_range;  ?> <br/>
	 <?php echo count($affiliatesignups); ?> affiliate signed up
 </h5>	<br/>
    <div class="row">
					<b>
					<div class="col s12 m2 l3">
							 Signup Date
					</div>
					<div class="col s12 m4 l4">
								Email
					</div>
					<div class="col s12 m2 l2">
							Promo Code
					</div>

					<div class="col s12 m2 l3">
					 	 Last login
					</div>
				</b>
				</div>
		<?php if(isset($affiliatesignups)): ?>
			<?php foreach($affiliatesignups as $value): ?>
			<div class="row">
				<div class="col s12 m2 l3">
							<div>  <?php echo $value->date; ?></div>
				</div>
				<div class="col s12 m4 l4">
					<div><a href="<?php echo $value->url; ?>">  <?php echo $value->email; ?></a></div>
				</div>
				<div class="col s12 m2 l2">
							<div>  <?php echo $value->mycode; ?></div>
				</div>

				<div class="col s12 m2 l3">
						<div>  <?php echo $value->lastlogin;?></div>
				</div>
			</div>
			<?php endforeach; ?>
		<?php else: ?>
			There are no affiliates
		<?php endif; ?>
