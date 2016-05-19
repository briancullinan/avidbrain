<?php
	$sql = "
		SELECT
			count(DATE_FORMAT(signup_date,'%m')) as count, DATE_FORMAT(signup_date,'%M') as date, DATE_FORMAT(signup_date,'%Y') as year, DATE_FORMAT(signup_date,'%Y %M') as monthyear
		FROM
			avid___user
		WHERE
			signup_date IS NOT NULL
				AND
			usertype = 'tutor'
		GROUP BY
			DATE_FORMAT(signup_date,'%Y %M')
		ORDER BY signup_date ASC
	";
	$prepare = array();
	$tutorsignups = $app->connect->executeQuery($sql,$prepare)->fetchAll();
?>

<!-- <div class="title">Signups VS Accounts</div> -->

<?php
/*
	$sql = "SELECT count(id) as total FROM signup_avidbrain.signup___signups";
	$prepare = array();
	$totalTutorSignups = $app->connect->executeQuery($sql,$prepare)->fetch();
	echo numbers($totalTutorSignups->total,1).'<br>';
	//notify($results);

	$sql = "SELECT count(id) as total FROM avidbrain.avid___user WHERE usertype = 'tutor'";
	$prepare = array();
	$totalActivatedTutors = $app->connect->executeQuery($sql,$prepare)->fetch();
	echo numbers($totalActivatedTutors->total,1).'<br>';

	$sql = "
		SELECT
			count(DATE_FORMAT(signupdate,'%m')) as count, DATE_FORMAT(signupdate,'%M') as date, DATE_FORMAT(signupdate,'%Y') as year, DATE_FORMAT(signupdate,'%Y %M') as monthyear
		FROM
			signup_avidbrain.signup___signups
		WHERE
			signupdate IS NOT NULL
		GROUP BY
			DATE_FORMAT(signupdate,'%Y %M')
		ORDER BY signupdate DESC
	";
	$prepare = array();
	$breakdown = $app->connect->executeQuery($sql,$prepare)->fetchAll();

*/
?>
<?php if(isset($breakdown[0])): ?>
	<div class="block">
		<div class="title">Tutor Signups</div>
		<?php foreach($breakdown as $key=> $info): ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<?php echo $info->date.' '.$info->year; ?>
				</div>
				<div class="col s12 m10 l10">
					<div>
						<div class="colors <?php echo color($key); ?>" style="width: <?php echo (($info->count)/40); ?>%;">
							<?php echo numbers($info->count,1); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if(isset($tutorsignups[0])): ?>
	<div class="block">
		<!-- <div class="title">Tutor Account Activation</div> -->
		<div class="title">Tutor Signups</div>
		<?php foreach($tutorsignups as $key=> $info): ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<?php echo $info->date.' '.$info->year; ?>
				</div>
				<div class="col s12 m10 l10">
					<div>
						<div class="colors <?php echo color($key); ?>" style="width: <?php echo (($info->count+50)/10); ?>%;">
							<?php echo $info->count; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php
	$sql = "
		SELECT
			count(DATE_FORMAT(signup_date,'%m')) as count, DATE_FORMAT(signup_date,'%M') as date, DATE_FORMAT(signup_date,'%Y') as year, DATE_FORMAT(signup_date,'%Y %M') as monthyear
		FROM
			avid___user
		WHERE
			signup_date IS NOT NULL
				AND
			usertype = 'student'
		GROUP BY
			DATE_FORMAT(signup_date,'%Y %M')
		ORDER BY signup_date ASC
	";
	$prepare = array();
	$tutorsignups = $app->connect->executeQuery($sql,$prepare)->fetchAll();
?>

<?php if(isset($tutorsignups[0])): ?>
	<div class="block">
		<div class="title">Student Signups</div>
		<?php foreach($tutorsignups as $key=> $info): ?>
			<div class="row">
				<div class="col s12 m2 l2">
					<?php echo $info->date.' '.$info->year; ?>
				</div>
				<div class="col s12 m10 l10">
					<div>
						<div class="colors <?php echo color($key); ?>" style="width: <?php echo (($info->count+50)/10); ?>%;">
							<?php echo $info->count; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
