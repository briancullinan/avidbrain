<?php
	
	$childen = array();
	//$childen['edit-profile'] = (object) array('name'=>'Edit Profile','slug'=>'/admin-everything/edit-profile');
	$childen['stats'] = (object) array('name'=>'Stats','slug'=>'/admin-everything/stats');
	$childen['view-everyone'] = (object) array('name'=>'View Everyone','slug'=>'/admin-everything/view-everyone');
	$childen['profile-approvals'] = (object) array('name'=>'Profile Approvals','slug'=>'/admin-everything/profile-approvals');
	$childen['help-requests'] = (object) array('name'=>'Help Requests','slug'=>'/admin-everything/help-requests');
	$childen['monitor-messages'] = (object) array('name'=>'Monitor Messages','slug'=>'/admin-everything/monitor-messages');
	$childen['manage-subjects'] = (object) array('name'=>'Manage Subjects','slug'=>'/admin-everything/manage-subjects');
	$childen['pay-tutors'] = (object) array('name'=>'Pay Tutors','slug'=>'/admin-everything/pay-tutors');
	$childen['pay-recruiters'] = (object) array('name'=>'Pay Recruiters','slug'=>'/admin-everything/pay-recruiters');
	$childen['contested-sessions'] = (object) array('name'=>'Contested Sessions','slug'=>'/admin-everything/contested-sessions');
	$childen['create-tutor'] = (object) array('name'=>'Create Tutor','slug'=>'/admin-everything/create-tutor');
	#$childen['xxx'] = (object) array('name'=>'xxx','slug'=>'/admin-everything/xxx');
	
	if($app->user->email=='david'.$app->dependents->mailgun->EMAIL_DOMAIN){
		
		$childen['fix-photos'] = (object) array('name'=>'Fix Photos','slug'=>'/admin-everything/fix-photos');
		$childen['fix-username'] = (object) array('name'=>'Fix Username','slug'=>'/admin-everything/fix-username');
	}
	
	
	//$childen['student-approvals'] = (object) array('name'=>'Student Approvals','slug'=>'/admin-everything/student-approvals');
	//$childen['xxx'] = (object) array('name'=>'xxx','slug'=>'/admin-everything/xxx');
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/admin-everything','text'=>'Admin Everything');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;