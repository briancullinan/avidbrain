<?php



	$children = array();
	//$children['edit-profile'] = (object) array('name'=>'Edit Profile','slug'=>'/admin-everything/edit-profile');
	$children['stats'] = (object) array('name'=>'Stats','slug'=>'/admin-everything/stats');
	$children['post-a-job'] = (object) array('name'=>'Post a Job','slug'=>'/admin-everything/post-a-job');
	$children['view-everyone'] = (object) array('name'=>'View Everyone','slug'=>'/admin-everything/view-everyone');
	$children['new-tutor-approvals'] = (object) array('name'=>'New Tutor Profile Approvals','slug'=>'/admin-everything/new-tutor-approvals');
	$children['profile-approvals'] = (object) array('name'=>'Profile Approvals','slug'=>'/admin-everything/profile-approvals');
	$children['help-requests'] = (object) array('name'=>'Help Requests','slug'=>'/admin-everything/help-requests');
	$children['monitor-messages'] = (object) array('name'=>'Monitor Messages','slug'=>'/admin-everything/monitor-messages');
	$children['spam-messages'] = (object) array('name'=>'Spam Messages','slug'=>'/admin-everything/spam-messages');
	$children['manage-subjects'] = (object) array('name'=>'Manage Subjects','slug'=>'/admin-everything/manage-subjects');
	$children['pay-tutors'] = (object) array('name'=>'Pay Tutors','slug'=>'/admin-everything/pay-tutors');
	$children['pay-affiliates'] = (object) array('name'=>'Pay Affiliates','slug'=>'/admin-everything/pay-affiliates');
//	$children['pay-recruiters'] = (object) array('name'=>'Pay Recruiters','slug'=>'/admin-everything/pay-recruiters');
	$children['contested-sessions'] = (object) array('name'=>'Contested Sessions','slug'=>'/admin-everything/contested-sessions');
	$children['create-tutor'] = (object) array('name'=>'Create Tutor','slug'=>'/admin-everything/create-tutor');
	#$children['xxx'] = (object) array('name'=>'xxx','slug'=>'/admin-everything/xxx');

	if($app->user->email=='david@avidbrain.com'){

		$children['fix-breaks'] = (object) array('name'=>'Fix Breaks','slug'=>'/admin-everything/fix-breaks');
		//$children['fix-username'] = (object) array('name'=>'Fix Username','slug'=>'/admin-everything/fix-username');
	}


	//$children['student-approvals'] = (object) array('name'=>'Student Approvals','slug'=>'/admin-everything/student-approvals');
	//$children['xxx'] = (object) array('name'=>'xxx','slug'=>'/admin-everything/xxx');

	if(isset($app->user->role) && $app->user->role=='other'){
		unset($children['create-tutor']);
		unset($children['contested-sessions']);
		unset($children['pay-tutors']);
		unset($children['post-a-job']);
		unset($children['stats']);

	}

	$app->childen = $children;
	$navtitle = (object)array('slug'=>'/admin-everything','text'=>'Admin Everything');
	$app->navtitle = $navtitle;

	$app->secondary = $app->target->secondaryNav;
