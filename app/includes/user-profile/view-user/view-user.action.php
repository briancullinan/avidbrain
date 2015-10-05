<?php

	if(isset($app->messagingsystem) && isset($app->user->table) && $app->user->table=='avid___admins'){
		$adminsend = true;
	}

	$url = '/'.$usertype.'/'.$state.'/'.$city.'/'.$username;

	if(isset($app->user->usertype) && $app->user->usertype=='admin' && empty($adminsend)){
		$app->admin = true;
	}
	if(isset($app->user->url) && $app->user->url == $url || isset($app->admin) && empty($adminsend)){
		$app->thisisme = true;
	}

	if(isset($app->thisisme) && empty($app->admin)){
		$sql = "SELECT * FROM avid___user_first_time WHERE email = :email AND name = :name ";
		$prepeare = array(':email'=>$app->user->email,':name'=>'profile-check');
		$myfirsttime = $app->connect->executeQuery($sql,$prepeare)->fetch();
		if(empty($myfirsttime)){
			$app->setupinstructions = true;
			if(isset($pagename) && $pagename=='okgotit'){
				$app->setupinstructions = NULL;
				$app->connect->insert('avid___user_first_time',array('email'=>$app->user->email,'name'=>'profile-check'));
				$app->redirect($url);
			}
		}
	}

	$data	=
			$app->connect->createQueryBuilder()->
			select('user.*,profile.*,'.account_settings().',user.id')->from('avid___user','user')->where('url = :url')->setParameter(':url',$url)->
			innerJoin('user','avid___user_profile','profile','user.email = profile.email')->
			innerJoin('user','avid___user_account_settings','settings','user.email = settings.email')->
			addSelect(' IF(COUNT(user.sessiontoken) = 0, NULL, 1) as activenow ')->
			execute()->fetch();

			if(isset($app->admin) && isset($data->id)){
				$app->user->email = $data->email;
				$data->thisisme = true;
			}
			elseif(isset($app->thisisme) && isset($data->id)){
				$data->thisisme = 1;
				unset($app->thisisme);
			}

	if(empty($data->id) || $data->usertype=='student' && empty($app->user->usertype)){
		$app->redirect('/'.$usertype);
	}

	if(isset($data->customer_id) && $data->usertype=='student'){

		$creditcard = get_creditcard($data->customer_id);
		if($creditcard!=NULL){
			$data->creditcard = $creditcard;
		}

	}

	$allowedPages = array();
	$allowedPages[] = 'about-me';
	if(isset($data->thisisme)){
		$allowedPages[] = 'my-photos';
	}
	$allowedPages[] = 'my-videos';
	$allowedPages[] = 'my-reviews';
	if(isset($data->usertype) && $data->usertype=='tutor'){
		$allowedPages[] = 'my-subjects';
	}
	if(isset($data->usertype) && $data->usertype=='student'){
		$allowedPages[] = 'i-need-help-with';
	}
	if(empty($data->thisisme) || $app->user->usertype=='admin'){
		$allowedPages[] = 'send-message';
	}
	$allowedPages[] = 'makehidden';
	$allowedPages[] = 'makevisible';

	if(isset($app->admin)){
		$allowedPages[] = 'approveprofile';
		$allowedPages[] = 'disapproveprofile';
		$allowedPages[] = 'unlockprofile';
		$allowedPages[] = 'lockprofile';
	}

	if(isset($pagename)){
		$app->pagename = $pagename;
		if(!in_array($pagename, $allowedPages)){
			$app->redirect('/'.$usertype);
		}
	}
	else{
		$pagename = 'about-me';
		$app->pagename = $pagename;
		$app->fixedname = $data->url.'/about-me';
	}

	if(isset($pagename) && $pagename=='my-subjects'){
		$app->fixedname = $data->url.'/my-subjects';
	}

	if(isset($data->promocode) && isset($app->user->email) && $data->promocode == $app->user->email){
		// Do Nothing
	}
	elseif(isset($data->hidden) && empty($data->thisisme)){
		$app->target->include = str_replace('.include.','.hidden.include.',$app->target->include);
		$app->secondary = NULL;
	}

	$app->secondary = NULL;

	// No Get Everything Else

	if(isset($data->id)){

		if(!$data->my_subjects = get_subjects($app->connect,$data->email,'verified')){
			unset($data->my_subjects);
		}
		if(!$data->my_other_subjects = get_subjects($app->connect,$data->email,'needs-review')){
			unset($data->my_other_subjects);
		}
		if(!$data->my_videos = get_videos($app->connect,$data->email)){
			unset($data->my_videos);
		}
		if(!$data->my_reviews = get_reviews($app->connect,$data->email,$data->usertype)){
			unset($data->my_reviews);
		}
		if(!$data->my_testimonials = my_testimonials($app->connect,$data->email,$data->usertype)){
			unset($data->my_testimonials);
		}
		if(!$data->reviewinfo = get_reviewinfo($app->connect,$data->email,$data->usertype)){
			unset($data->reviewinfo);
		}
		if(isset($data->reviewinfo)){
			$data->reviewinfo->student_count = $app->connect->executeQuery('SELECT id FROM avid___sessions WHERE from_user = :myemail AND session_status = "complete" GROUP BY to_user ',array(':myemail'=>$data->email))->rowCount();
		}
		if(!$data->myjobs = get_jobs($app->connect,$data->email)){
			unset($data->myjobs);
		}

		//notify($data);

	}

	$toplinks['about-me'] = (object)array(
		'slug'=>$url.'/about-me',
		'name'=>'About Me'
	);
	if(isset($data->usertype) && $data->usertype=='tutor'){
		$toplinks['my-subjects'] = (object)array(
			'slug'=>$url.'/my-subjects',
			'name'=>'My Subjects'
		);
	}
	if($data->usertype=='tutor'){
		$toplinks['my-reviews'] = (object)array(
			'slug'=>$url.'/my-reviews',
			'name'=>'My Reviews'
		);
	}
	elseif($data->usertype=='student'){
		$toplinks['my-reviews'] = (object)array(
			'slug'=>$url.'/my-reviews',
			'name'=>"My Reviews"
		);
	}
	if(isset($data->my_videos)){
		$toplinks['my-videos'] = (object)array(
			'slug'=>$url.'/my-videos',
			'name'=>'My Videos'
		);
	}
	if(isset($data->thisisme)){
		$toplinks['my-photos'] = (object)array(
			'slug'=>$url.'/my-photos',
			'name'=>'My Photos'
		);
	}
	if(isset($data->usertype) && $data->usertype=='student'){
		$toplinks['i-need-help-with'] = (object)array(
			'slug'=>$url.'/i-need-help-with',
			'name'=>'I Need Help With'
		);
	}
	if(empty($data->thisisme) || $app->user->usertype=='admin'){
		$toplinks['send-message'] = (object)array(
			'slug'=>$url.'/send-message',
			'name'=>'Send Message'
		);
	}

	$app->childen = $toplinks;
	$navtitle = (object)array('slug'=>'/'.$usertype,'text'=>ucwords($usertype));
	$app->navtitle = $navtitle;

	if(isset($data->thisisme)){
		$app->currentuser = new activeUser($app->connect,$data);
	}
	else{
		$app->currentuser = $data;
	}


	if(isset($pagename) && isset($data->thisisme) && empty($app->admin)){

		if($pagename=='makehidden'){
			$app->currentuser->hidden = 1;
			$app->currentuser->save();
				$app->redirect($app->currentuser->url);
		}
		elseif($pagename=='makevisible'){
			$app->currentuser->hidden = NULL;
			$app->currentuser->save();
				$app->redirect($app->currentuser->url);
		}
	}
	elseif(isset($pagename) && isset($app->admin)){

		if($pagename=='approveprofile'){

			$delete = $app->connect->delete('avid___user_needsprofilereview', array('email' => $app->currentuser->email));

			if($app->currentuser->usertype=='tutor'){
				$message = 'Your profile has been approved, you may now login and start tutoring.';
			}
			elseif($app->currentuser->usertype=='student'){
				$message = 'Your profile has been approved, you may now login and find a tutor.';
			}

			$app->mailgun->to = $app->currentuser->email;
			$app->mailgun->subject = 'Profile Approved';
			$app->mailgun->message = $message;
			$app->mailgun->send();


			$app->currentuser->short_description_verified_status = NULL;
			$app->currentuser->personal_statement_verified_status = NULL;


			$app->currentuser->status = NULL;
			$app->currentuser->lock = NULL;
			$app->currentuser->hidden = NULL;
			$app->currentuser->save();
			$app->redirect($app->currentuser->url);
		}
		elseif($pagename=='disapproveprofile'){
			$app->currentuser->status = 'needs-review';
			$app->currentuser->save();
			$app->redirect($app->currentuser->url);
		}
		elseif($pagename=='unlockprofile'){
			$app->currentuser->lock = NULL;
			$app->currentuser->save();
			$app->redirect($app->currentuser->url);
		}
		elseif($pagename=='lockprofile'){
			$app->currentuser->lock = 1;
			$app->currentuser->sessiontoken = NULL;
			$app->currentuser->save();
			$app->redirect($app->currentuser->url);
		}


		if($pagename=='makehidden'){
			$app->currentuser->hidden = 1;
			$app->currentuser->save();
				$app->redirect($app->currentuser->url);
		}
		elseif($pagename=='makevisible'){
			$app->currentuser->hidden = NULL;
			$app->currentuser->save();
				$app->redirect($app->currentuser->url);
		}

	}

	#notify($data);

	//
	$app->target->include = str_replace('view-user.','view-user.'.$app->currentuser->usertype.'.',$app->target->include);
	$app->target->post = str_replace('view-user.','view-user.'.$app->currentuser->usertype.'.',$app->target->post);

	if(isset($category) && $category=='whiteboard' && isset($subject) && isset($pagename) && $pagename=='send-message'){
		$sql = "SELECT roomid FROM avid___sessions WHERE roomid = :roomid AND to_user = :thisuser";
		$prepare = array(':roomid'=>$subject,':thisuser'=>$data->email);
		$results = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($results->roomid)){
			$app->sendwhiteboard = $results;
		}
	}

	$sql = "SELECT * FROM avid___user_needsprofilereview WHERE email = :email ORDER BY id DESC";
	$prepare = array(':email'=>$app->currentuser->email);
	$needsprofilereview = $app->connect->executeQuery($sql,$prepare)->fetch();
	if(isset($needsprofilereview->id)){
		$app->needsprofilereview = $needsprofilereview;
	}


	if(isset($app->currentuser->showfullname) && $app->currentuser->showfullname=='yes'){
		$myname = $app->currentuser->first_name.' '.$app->currentuser->last_name;
	}
	else{
		$myname = short($app->currentuser);
	}

	$var = NULL;
	if(isset($app->currentuser->short_description_verified)){
		$var = ' - '.$app->currentuser->short_description_verified;
	}
	$keywords = NULL;
	if(isset($app->currentuser->my_subjects)){
		$keywords = strip_tags(showsubjects($app->currentuser->my_subjects,10));
	}

	$app->meta = new stdClass();
	$app->meta->title = $myname.$var.' / '.$app->currentuser->city.', '.ucwords($app->currentuser->state_long).' '.$app->dependents->SITE_NAME_PROPPER.' Tutor';
	$app->meta->h1 = false;
	$app->meta->keywords = $keywords;
	$app->meta->description = truncate($app->currentuser->personal_statement_verified,100);
