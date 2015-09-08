<?php
	$selector = 'from_user';
	$sql = "SELECT * FROM avid___sessions WHERE $selector = :email AND pending IS NOT NULL ";
	$prepeare = array(':email'=>$app->user->email);
	$pending = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
	$sql = "SELECT * FROM avid___sessions WHERE $selector = :email AND session_status = 'canceled-session' ";
	$prepeare = array(':email'=>$app->user->email);
	$canceled = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
	$sql = "SELECT * FROM avid___sessions WHERE $selector = :email AND session_status = 'complete' ";
	$prepeare = array(':email'=>$app->user->email);
	$complete = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
	$sql = "SELECT * FROM avid___sessions WHERE $selector = :email AND jobsetup IS NOT NULL ";
	$prepeare = array(':email'=>$app->user->email);
	$jobsessions = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
?>

<h2>Sessions Overview</h2>

<ul class="collection">
	<li class="collection-item">
		<a href="/sessions/jobs">Job Sessions</a> <span class="badge blue white-text"> <?php echo $jobsessions; ?> </span>
	</li>
	<li class="collection-item">
		<a href="/sessions/pending">Pending Sessions</a> <span class="badge grey white-text"> <?php echo $pending; ?> </span>
	</li>
	<li class="collection-item">
		<a href="/sessions/completed">Complete Sessions</a> <span class="badge light-green accent-4 white-text"> <?php echo $complete; ?> </span>
	</li>
	<li class="collection-item">
		<a href="/sessions/canceled">Canceled Sessions</a> <span class="badge red white-text"> <?php echo $canceled; ?> </span>
	</li>
</ul>