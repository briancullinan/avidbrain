<?php

	$url = '';
	if(isset($state) && isset($city) && isset($username)){
		$url = "/tutors/$state/$city/$username";
	}


	$app->target->css = str_replace('main','view-user---',$app->target->css);
	$app->secondary = false;

	function mystars($count){
		if(!empty($count)){
			$total = 5;
			$minus = $total - $count;
			if($minus!=0){
				$rangeOne = range(1,$minus);
			}
			$stars = '';
			if(isset($rangeOne)){
				foreach($rangeOne as $brokenStars){
					$stars.=' <i class="fa fa-star-o"></i> ';
				}
			}
			if($minus===0){
				foreach(range(1,5) as $brokenStars){
					$stars.=' <i class="fa fa-star"></i> ';
				}
			}
			else{
				foreach(range(1,$count) as $brokenStars){
					$stars.=' <i class="fa fa-star"></i> ';
				}
			}
			return $stars;
		}
	}

	function getmysubjects($connect,$email){

		$select = "subjects.*";

		$mysubjects = (object)[];
		$sql = "
			SELECT
				$select
			FROM
				avid___user_subjects subjects
			WHERE
				subjects.email = :email
					AND
				subjects.status = 'verified'
					AND
				subjects.description_verified IS NOT NULL

			ORDER BY subjects.sortorder ASC
		";
		$prepare = array(
			':email'=>$email
		);
		$approved = $connect->executeQuery($sql,$prepare)->fetchAll();
		if(!empty($approved)){
			$mysubjects->approved = $approved;
		}

		$sql = "
			SELECT
				$select
			FROM
				avid___user_subjects subjects
			WHERE
				subjects.email = :email
					AND
				subjects.status = 'needs-review'

			ORDER BY subjects.sortorder ASC
		";
		$prepare = array(
			':email'=>$email
		);
		$notApproved = $connect->executeQuery($sql,$prepare)->fetchAll();
		if(!empty($notApproved)){
			$mysubjects->notApproved = $notApproved;
		}
		return $mysubjects;
	}

	$sql = "
		SELECT
			user.id,
			user.email,
			user.usertype,
			user.last_active,
			user.city,
			user.state,
			user.state_long,
			user.state_slug,
			user.zipcode,
			user.first_name,
			user.last_name,
			user.url,
			user.username,
			user.signup_date,
			user.lat,
			user.long,
			user.phone,
			user.anotheragency,
			user.anotheragency_rate,
			user.hidden,
			user.status,
			user.lock,
			user.emptybgcheck,

			profile.hourly_rate,
            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
			profile.short_description,
            profile.short_description_verified,
            profile.personal_statement_verified,
            profile.personal_statement,
			profile.gender,
			profile.travel_distance,
			profile.cancellation_policy,
			profile.cancellation_rate,
			profile.online_tutor

		FROM
			avid___user user

		INNER JOIN avid___user_profile profile on profile.email = user.email

		WHERE
			user.url = :url
	";
	$prepare = array(
		':url'=>$url
	);
	$actualuser = $app->connect->executeQuery($sql,$prepare)->fetch();

	if(isset($actualuser->email) && isset($app->user->usertype) && $app->user->usertype=='admin'){
		$app->user->email = $actualuser->email;
		$app->adminnow = true;
	}

	if(isset($app->user->email) && $app->user->email == $actualuser->email){
		if(isset($pagename) && $pagename=='actions' && isset($category) && $category=='hideprofile'){
			$app->connect->update('avid___user',array('hidden'=>1),array('email'=>$app->user->email));
			$app->redirect($actualuser->url);
		}
		elseif(isset($pagename) && $pagename=='actions' && isset($category) && $category=='showprofile'){
			$app->connect->update('avid___user',array('hidden'=>NULL),array('email'=>$app->user->email));
			$app->redirect($actualuser->url);
		}

	}

	if(isset($category) && $category=='crop-photo'){

		$myupload = APP_PATH.'uploads/photos/'.$actualuser->my_upload;
		$app->img = $app->imagemanager->make($myupload);

		$app->target->include = str_replace('.include.','.crop-photo.',$app->target->include);
	}

	//notify($actualuser);
	if(isset($actualuser->id)){

		if(isset($app->user->email) && $app->user->email==$actualuser->email && isset($actualuser->short_description)){
			$tagline = $actualuser->short_description;
		}
		elseif(isset($actualuser->short_description_verified)){
			$tagline = $actualuser->short_description_verified;
		}
		elseif(empty($actualuser->short_description_verified) && isset($actualuser->short_description)){
			$tagline = $actualuser->short_description;
		}
		else{
			$tagline = NULL;
		}

		if(isset($app->user->email) && $app->user->email==$actualuser->email && isset($actualuser->personal_statement)){
			$statement = $actualuser->personal_statement;
		}
		elseif(isset($actualuser->personal_statement_verified)){
			$statement = $actualuser->personal_statement_verified;
		}
		elseif(empty($actualuser->personal_statement_verified) && isset($actualuser->personal_statement)){
			$statement = $actualuser->personal_statement;
		}
		else{
			$statement = NULL;
		}

		//printer($actualuser,1);

		if(isset($app->user->email) && $app->user->email==$actualuser->email &&  isset($actualuser->short_description) && isset($actualuser->short_description_verified) && $actualuser->short_description != $actualuser->short_description_verified){
			$actualuser->mytaglineflag = true;
		}
		if(isset($app->user->email) && $app->user->email==$actualuser->email &&  isset($actualuser->personal_statement) && isset($actualuser->personal_statement_verified) && $actualuser->personal_statement != $actualuser->personal_statement_verified){
			$actualuser->statementflag = true;
		}
		$actualuser->mytagline = $tagline;
		$actualuser->statement = $statement;


		$app->actualuser = $actualuser;
		//notify($app->actualuser);

		if(isset($pagename)){
			if($pagename=='my-subjects'){
				$app->actualuser->subjects = getmysubjects($app->connect,$app->actualuser->email);
			}
			elseif($pagename=='send-message'){
				if(isset($app->user->email)){
					if($app->user->email==$app->actualuser->email){
						$app->actualuser->sendform->message = "You can't message yourself.";
					}
					elseif(isset($app->user->emptybgcheck) && $app->user->usertype=='tutor'){
						$app->actualuser->sendform->message = 'Please complete your <a class="green-text" href="/background-check">Background Check</a> to send messages.';
					}
				}
				else{
					$app->actualuser->sendform->message = '<a class="modal-trigger btn " href="#loginModule">Please Login To Message</a> ';
				}
			}
			elseif($pagename=='my-reviews'){

				$sql = "
					SELECT
						sessions.review_score,
						sessions.review_date,
						sessions.review_name
					FROM
						avid___sessions sessions
					WHERE
						sessions.from_user = :email
							AND
						sessions.review_date IS NOT NULL
							AND
						sessions.dispute IS NULL
							AND
						sessions.review_score IS NOT NULL

					ORDER BY sessions.review_score DESC
				";
				$prepare = array(
					':email'=>$app->actualuser->email
				);
				$mystarscore = $app->connect->executeQuery($sql,$prepare)->fetchAll();
				//printer($mystarscore);
				if(!empty($mystarscore)){
					$finalScore = [];
					$total = 0;
					foreach($mystarscore as $scoring){
						$finalScore[$scoring->review_score][] = 1;
						$total++;
					}

					$fives = count($finalScore[5]);
					$fours = count($finalScore[4]);
					$threes = count($finalScore[3]);
					$twos = count($finalScore[2]);
					$ones = count($finalScore[1]);
					$app->actualuser->finalscore = (object)array(
						'scores'=>(object)array(
							'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'=>$fives,
							'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'=>$fours,
							'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>'=>$threes,
							'<i class="fa fa-star"></i><i class="fa fa-star"></i>'=>$twos,
							'<i class="fa fa-star"></i>'=>$ones,
						),
						'total'=>$total
					);
				}

				$sql = "
					SELECT
						sessions.review_score,
						sessions.review_text,
						sessions.review_date,
						sessions.review_name,
						user.first_name,
						user.last_name,
						user.url
					FROM
						avid___sessions sessions

					INNER JOIN avid___user user on user.email = sessions.review_name

					WHERE
						sessions.from_user = :email
							AND
						sessions.review_date IS NOT NULL
							AND
						sessions.dispute IS NULL
							AND
						sessions.review_text IS NOT NULL
							AND
						sessions.review_text != ' '

					ORDER BY sessions.id DESC
				";
				$prepare = array(
					':email'=>$app->actualuser->email
				);
				$myreviews = $app->connect->executeQuery($sql,$prepare)->fetchAll();
				if(!empty($myreviews)){
					$app->actualuser->myreviews = $myreviews;
				}
			}
			elseif($pagename=='qa-posts'){

				$sql = "
					SELECT
						posts.postid,
						posts.parentid,
						posts.content,
						post2.title
					FROM
						questions_answers.qa_posts posts

					INNER JOIN questions_answers.qa_posts post2 on post2.postid = posts.parentid

					WHERE

						posts.userid = :myid
							AND
						post2.title IS NOT NULL

					ORDER BY posts.parentid DESC

					LIMIT 20

				";
				$prepare = array(
					':myid'=>$app->actualuser->id
				);
				$qaposts = $app->connect->executeQuery($sql,$prepare)->fetchAll();
				if(!empty($qaposts)){
					$app->actualuser->qaposts = $qaposts;
				}


			}
		}


		$getDistance = "round(((acos(sin((" . $app->actualuser->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $app->actualuser->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$app->actualuser->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) ";
		$asDistance = ' as distance ';
		$select = $getDistance.$asDistance;
		$having = "HAVING distance <= :distance";


		$sql = "
			SELECT
				user.id,
				user.email,
				user.first_name,
				user.last_name,
				user.username,
				user.url,
				profile.hourly_rate,
				profile.my_avatar,
	            profile.my_avatar_status,
	            profile.my_upload,
	            profile.my_upload_status,
				$select
			FROM
				avid___user user

			INNER JOIN avid___user_profile profile on profile.email = user.email

			WHERE
				user.usertype = 'tutor'
					AND
				user.status IS NULL
					AND
				user.hidden IS NULL
					AND
				profile.hourly_rate IS NOT NULL
					AND
				user.lock IS NULL
					AND
				profile.hourly_rate BETWEEN :pricelow and :pricehigh
					AND
				user.email != :myemail
					AND
				user.first_name IS NOT NULL

			$having

			ORDER BY distance ASC

			LIMIT 4
		";

		$prepare = [];
		$prepare[':distance'] = 30;
		$prepare[':myemail'] = $app->actualuser->email;
		$prepare[':pricelow'] = ($app->actualuser->hourly_rate-20);
		$prepare[':pricehigh'] = ($app->actualuser->hourly_rate+20);
		$cachedKeyforReccomendations = "cachedrecomendationsfor".$app->actualuser->email;
		$recommendations = $app->connect->cache->get($cachedKeyforReccomendations);
		if($recommendations == null) {
		    $recommendations = $app->connect->executeQuery($sql,$prepare)->fetchAll();
		    $app->connect->cache->set($cachedKeyforReccomendations, $results, 3600);
		}
		if(!empty($recommendations)){
			$app->recommendations = $recommendations;
		}



		$mypages = [
			'about-me'=>'About Me',
			'my-subjects'=>'My Subjects',
			'qa-posts'=>'Q&amp;A Posts',
			'my-reviews'=>'My Reviews',
			'send-message'=>'Send Message'
		];

		if(isset($app->user->email) && $app->user->email==$app->actualuser->email){
			$mypages['my-photos'] = 'My Photos';
		}

		if(isset($app->adminnow)){
			$mypages['administer'] = 'Administer';
		}

		if(isset($pagename) && !array_key_exists($pagename, $mypages)){
			$app->redirect($app->actualuser->url);
		}

		unset($mypages['my-photos']);
		unset($mypages['administer']);

		$app->mypages = $mypages;

		$app->meta = new stdClass();
		$app->meta->title = $app->actualuser->short_description_verified.' - '.short($app->actualuser).' - '.online_tutor($app->actualuser->online_tutor).' Tutor in '.$app->actualuser->city.' '.ucwords($app->actualuser->state_long);
		$app->meta->h1 = false;

	}
