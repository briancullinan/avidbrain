<?php


	$app->howitworks = true;



	$cachedKey = "featured-homepage-tutor";
	//$app->connect->cache->clean();
	//$app->connect->cache->delete($cachedKey);
	$featuredhomepagetutor = $app->connect->cache->get($cachedKey);
	if($featuredhomepagetutor == null) {

		$featuredEmail = array(
			#'ross.leonmiller@gmail.com',
			'whereiskatima@gmail.com',
			'teallen04@yahoo.com',
			'acooper29@nycap.rr.com',
			'dr.thatch.tutor@gmail.com',
			#'hidehi.rosenberg@gmail.com',
			'mosam@inbox.com',
			'sonya.marrus@gmail.com',
			#'joelyn.k.foy@gmail.com'
		);
		shuffle($featuredEmail);
		$featuredEmail = $featuredEmail[0];

		$sql = "
			SELECT
				user.first_name, user.last_name, user.url, user.city, user.state_long,
				profile.my_upload, profile.short_description_verified, profile.personal_statement_verified
			FROM
				avid___user user, avid___user_profile profile
			WHERE
				user.email = :email
					AND
				profile.email =:email
		";
		$prepare = array(
			':email'=>$featuredEmail
		);
		$featuredTutor = $app->connect->executeQuery($sql,$prepare)->fetch();
		$myphoto = '/profiles/avatars/default-avatar.png';
		if(isset($featuredTutor->my_upload)){
			$myphoto = '/profiles/approved/'.croppedfile($featuredTutor->my_upload);
		}
		$featuredTutor->myphoto = $myphoto;

		$sql = "SELECT (sum(review_score)/count(review_score)) as average  FROM avid___sessions WHERE from_user = :from_user AND review_score IS NOT NULL";
		$prepare = array(':from_user'=>$featuredEmail);
		$starscore = $app->connect->executeQuery($sql,$prepare)->fetch();
		if(isset($starscore->average)){
			$average = round($starscore->average,1);
			if($average>0){
				$featuredTutor->starscore = $average;
			}
		}

		$sql = "SELECT subject_name,subject_slug,parent_slug FROM avid___user_subjects WHERE email = :email AND status = :status ORDER BY rand() LIMIT 9";
		$prepare = array(':email'=>$featuredEmail,':status'=>'verified');
		$featuredTutor->subjects = $app->connect->executeQuery($sql,$prepare)->fetchAll();

		$results = $featuredTutor;
		$featuredhomepagetutor = $results;
		$app->connect->cache->set($cachedKey, $results, 3600);
	}

	$app->featuredhomepagetutor = $featuredhomepagetutor;
