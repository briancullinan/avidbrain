<?php
	$sql = "SELECT id FROM avid___user WHERE usertype = :usertype";
	$prepare = array(':usertype'=>'tutor');
	$tutors = $app->connect->executeQuery($sql,$prepare)->rowCount();
	
	$sql = "SELECT id FROM avid___user WHERE usertype = :usertype";
	$prepare = array(':usertype'=>'student');
	$students = $app->connect->executeQuery($sql,$prepare)->rowCount();
	
	$sql = "SELECT id FROM avid___user WHERE usertype = :usertype";
	$prepare = array(':usertype'=>'recruiter');
	$recruiter = $app->connect->executeQuery($sql,$prepare)->rowCount();
	
	$sql = "SELECT id FROM avid___messages";
	$messages = $app->connect->executeQuery($sql,$prepare)->rowCount();
	
	$sql = "SELECT id FROM avid___sessions WHERE session_status = 'complete'";
	$sessions = $app->connect->executeQuery($sql,$prepare)->rowCount();
?>

<ul class="collection">
	<li class="collection-item">
		Tutors <span class="badge green white-text">
			<?php echo numbers($tutors,1); ?>
		</span>
	</li>
	<li class="collection-item">
		Students <span class="badge blue white-text">
			<?php echo numbers($students,1); ?>	
		</span>
	</li>
	<li class="collection-item">
		Recruiters <span class="badge red white-text">
			<?php echo numbers($recruiter,1); ?>	
		</span>
	</li>
	<li class="collection-item">
		Sent Messages <span class="badge orange white-text">
		
		<?php echo numbers($messages,1); ?>	
		
		</span>
	</li>
	<li class="collection-item">
		Completed Sessions <span class="badge purple white-text">
		
		<?php echo numbers($sessions,1); ?>	
		
		</span>
	</li>
</ul>