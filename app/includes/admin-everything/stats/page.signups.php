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

<?php if(isset($tutorsignups[0])): ?>
	<div class="block">
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