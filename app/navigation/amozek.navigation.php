<?php

	if(isset($app->user->usertype) && $app->user->usertype=='student' && empty($app->user->customer_id) && empty($app->user->validateactive)){
		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('settings.*,waiting.*, user.first_name, user.last_name, user.url')->from('avid___waiting_to_email','waiting');
		$data	=	$data->where('waiting.from_user = :myemail')->setParameter(':myemail',$app->user->email);
		$data	=	$data->innerJoin('waiting','avid___user','user','waiting.to_user = user.email');
		$data	=	$data->innerJoin('waiting','avid___user_account_settings','settings','waiting.to_user = settings.email');
		$app->waitingtoemail	=	$data->execute()->fetch();

		if(isset($app->waitingtoemail->id)){
			$notications = new stdClass();
			$notications->status = 'moderate';
			$notications->type = 'messages-waiting';
			$notications->message = '<a class="btn btn-s" href="/payment">Acitvate Messaging</a>';
			$app->notifications = $notications;
		}
	}

	#if(isset($app->user->needs_bgcheck)){
		#$notications = new stdClass();
		#$notications->status = 'background-check';
		#$notications->message = '<a class="btn btn-s" href="/background-check">Complete Background Check</a>';
		#$app->notifications = $notications;
	#}

	if(isset($app->user->status) && $app->user->status=='needs-review' && $app->user->usertype=='student' && isset($app->user->welcome)){

		#$notications = new stdClass();
		#$notications->status = 'urgent';
		#$notications->message = '<a class="btn black btn-s" href="/activate-profile">Activate Your Profile</a>';
		#$app->notifications = $notications;

		// if($app->request->getPath()=='/activate-profile'){
		//
		// }
		// elseif(isset($app->user->short_description) && !empty($app->user->short_description) && isset($app->user->personal_statement) && !empty($app->user->personal_statement)){
		// 	$app->redirect('/activate-profile');
		// }

	}

	if(isset($app->user->status) && $app->user->status=='needs-review' && $app->user->usertype=='tutor' && isset($app->user->zipcode)){

		$notications = new stdClass();
		$notications->status = 'urgent';
		$notications->message = '<a class="btn black btn-s" href="/request-profile-review">Request Profile Review</a>';
		$app->notifications = $notications;

	}
	if(isset($app->user->my_upload) && isset($app->user->my_upload_status) && $app->user->my_upload_status=='needs-review'){

		$sql = "SELECT type FROM avid___user_needsprofilereview WHERE email = :email ORDER BY id DESC";
		$prepare = array(':email'=>$app->user->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();

		if(isset($results->type) && $results->type=='My Photo'){
			$notications = new stdClass();
			$notications->status = 'low';
			$notications->message = '<a href="'.$app->user->url.'/my-photos">Your photo is under review</a>';
			$app->notifications = $notications;
		}
	}


	function countnewmessages($connect,$email){
		$sql = "SELECT id FROM avid___messages WHERE to_user = :email AND location = :location AND status__read IS NULL ";
		$prepeare = array(':email'=>$email,':location'=>'inbox');
		$results = $connect->executeQuery($sql,$prepeare)->rowCount();
		if($results>0){
			return '<span class="new badge waves-effect">'.$results.'</span>';
		}

	}

	function countpendingsessions($connect,$email,$usertype){
		if(isset($usertype) && $usertype=='tutor'){
			$selector = 'from_user';
		}
		elseif(isset($usertype) && $usertype=='student'){
			$selector = 'to_user';
		}
		else{
			$selector = 'from_user';
		}
		$currentdate = thedate();
		$sql = "SELECT * FROM avid___sessions WHERE $selector = :email AND session_status IS NULL AND session_timestamp IS NOT NULL ";
		$prepeare = array(':email'=>$email);
		$results = $connect->executeQuery($sql,$prepeare)->rowCount();
		if($results>0){
			return '<span class="new badge waves-effect">'.$results.'</span>';
		}
	}

	$navigationsubs = array();
	$navigationsubs['/terms-of-use'] = (object) array('name'=>'Terms of Service');
	$navigationsubs['/help/contact'] = (object) array('name'=>'Contact Us');
	//$navigationsubs['/about-us'] = (object) array('name'=>'About Us');
	#$navigationsubs['/xxx'] = (object) array('name'=>'xxx');
	#$navigationsubs['/xxx'] = (object) array('name'=>'xxx');
	#$navigationsubs['/xxx'] = (object) array('name'=>'xxx');



	$navigation = array();
	$navigation['/'] = (object) array('name'=>'<i class="fa fa-home"></i> Home');

	if(isset($app->user->usertype) && $app->user->usertype=='tutor'){
		$navigation['/tutors'] = (object) array('name'=>'Tutors');
		$navigation['/jobs'] = (object) array('name'=>'Tutoring Jobs');
	}
	elseif(isset($app->user->usertype) && $app->user->usertype=='student'){
		$navigation['/tutors'] = (object) array('name'=>'Find A Tutor');
		$navigation['/jobs'] = (object) array('name'=>'Request A Tutor');
	}
	else{
		$navigation['/tutors'] = (object) array('name'=>'Tutors');
		$navigation['/jobs'] = (object) array('name'=>'Jobs');
	}


	if(isset($app->user->email)){
		$navigation['/students'] = (object) array('name'=>'Students');
	}

	if(empty($app->user->email)){
	}
	else{


		$countnewmessages = countnewmessages($app->connect,$app->user->email);
		if(isset($countnewmessages)){
			$app->messsesscount = 1;
		}
		$countpendingsessions = countpendingsessions($app->connect,$app->user->email,$app->user->usertype);
		if(isset($countpendingsessions)){
			$app->messsesscount = 1;
		}

		$navigation['/messages'] = (object) array('name'=>'Messages '.$countnewmessages);
		$navigation['/sessions'] = (object) array('name'=>'Sessions '.$countpendingsessions);
	}

	$navigation['/help'] = (object) array('name'=>'Help');
	if(isset($app->enableaffiliates)){
		$navigation['/affiliates'] = (object) array('name'=>'Affiliate Program');
	}
	$navigation['/ab-qa'] = (object) array('name'=>'Q&A Forum','class'=>'qa-link');
	$navigation['/how-it-works'] = (object) array('name'=>'How It Works');
	if(isset($app->user->email)){
		$navigation['/resources'] = (object) array('name'=>'Resources');
	}


	$footerlinks = array();
	if(isset($app->user->email) && empty($app->user->status)){
		$qalink = '/qa-login';
	#	$footerlinks[$qalink] = (object) array('name'=>'Questions & Answers');
	}
	elseif(isset($app->user->email) && isset($app->user->status)){
		$qalink = '/resources/questions-and-answers';
	#	$footerlinks[$qalink] = (object) array('name'=>'Questions & Answers');
	}
	else{
	#	$footerlinks[socialQa] = (object) array('name'=>'Questions & Answers');
	}
	#$footerlinks[socialBlog] = (object) array('name'=>'Our Blog');
	$footerlinks['/terms-of-use'] = (object) array('name'=>'Terms of Use');
	$footerlinks['/help/contact'] = (object) array('name'=>'Contact Us');
	$footerlinks['/staff'] = (object) array('name'=>'Our Staff');
	$footerlinks['/tutors-by-location'] = (object) array('name'=>'Tutors By Location');
	$footerlinks['/attributions'] = (object) array('name'=>'Attributions');
	$footerlinks['/partners'] = (object) array('name'=>'Partners');
	//$footerlinks['/signup/affiliate'] = (object) array('name'=>'Affiliates');
	$footerlinks['/sitemap'] = (object) array('name'=>'Sitemap');




	$app->footerlinks = $footerlinks;

	$app->leftnav = $navigation;

	$app->leftnavsubs = $navigationsubs;
