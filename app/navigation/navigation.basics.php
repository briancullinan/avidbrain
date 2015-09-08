<?php
	
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
	
	
	$navigation = array();
	$navigation['/'] = (object) array('name'=>'<i class="fa fa-home"></i> Home');
	$navigation['/tutors'] = (object) array('name'=>'Tutors');
	$navigation['/jobs'] = (object) array('name'=>'Jobs');
	if(isset($app->user->email)){
		$navigation['/students'] = (object) array('name'=>'Students');
	}
	
	if(empty($app->user->email)){
		$navigation['#loginModule'] = (object) array('name'=>'<i class="fa fa-sign-in"></i> Login','class'=>'modal-trigger modal-login');
		$navigation['/signup'] = (object) array('name'=>'<i class="fa fa-exclamation"></i> Signup','class'=>' signup');
	}
	else{
		$navigation['/messages'] = (object) array('name'=>'Messages '.countnewmessages($app->connect,$app->user->email));
		$navigation['/sessions'] = (object) array('name'=>'Sessions '.countpendingsessions($app->connect,$app->user->email,$app->user->usertype));
	}

	$navigation['/help'] = (object) array('name'=>'Help');
	$navigation['/how-it-works'] = (object) array('name'=>'How It Works');
	if(isset($app->user->email)){
		$navigation['/resources'] = (object) array('name'=>'Resources');
	}
	
	
	$footerlinks = array();
	if(isset($app->user->email) && empty($app->user->status)){
		$email = $app->crypter->encrypt($app->user->email);
		$sessiontoken = $app->crypter->encrypt($app->user->sessiontoken);
		$qalink = $app->dependents->social->qa.'/login.php?one='.$email.'&two='.$sessiontoken;
		$footerlinks[$qalink] = (object) array('name'=>'Questions & Answers');
	}
	elseif(isset($app->user->email) && isset($app->user->status)){
		$qalink = '/resources/questions-and-answers';
		$footerlinks[$qalink] = (object) array('name'=>'Questions & Answers');
	}
	else{
		$footerlinks[$app->dependents->social->qa] = (object) array('name'=>'Questions & Answers');
	}
	$footerlinks[$app->dependents->social->blog] = (object) array('name'=>'Our Blog');
	$footerlinks['/terms-of-use'] = (object) array('name'=>'Terms of Use');
	$footerlinks['/help/contact'] = (object) array('name'=>'Contact Us');
	$footerlinks['/staff'] = (object) array('name'=>'Our Staff');
	$footerlinks['/tutors-by-location'] = (object) array('name'=>'Tutors By Location');
	$footerlinks['/sitemap'] = (object) array('name'=>'Sitemap');
	
	
	
	$app->footerlinks = $footerlinks;

	$app->leftnav = $navigation;
