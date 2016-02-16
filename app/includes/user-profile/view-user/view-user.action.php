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

			profile.hourly_rate,
            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
            profile.short_description_verified,
            profile.personal_statement_verified,
			profile.gender,
			profile.travel_distance,
			profile.cancellation_policy,
			profile.cancellation_rate

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
	//notify($actualuser);
	if(isset($actualuser->id)){
		$app->actualuser = $actualuser;
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

				/*
				$sql = "
					SELECT
						posts.postid,
						posts.title,
						posts.created,
						posts.content,
						postsJoin.content as answere
					FROM
						questions_answers.qa_posts posts

					LEFT JOIN
						questions_answers.qa_posts postsJoin on postsJoin.parentid = posts.postid

					WHERE
						posts.userid = :myid
				";
				$prepare = array(
					':myid'=>$app->actualuser->id
				);
				$qaposts = $app->connect->executeQuery($sql,$prepare)->fetchAll();
				if(!empty($qaposts)){
					$app->actualuser->qaposts = $qaposts;
				}
				*/
				//notify('science');
			}
		}
	}
