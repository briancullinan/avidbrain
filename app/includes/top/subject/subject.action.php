<?php

    $topSubs = [];
    if(!empty($app->top)){
        foreach($app->top as $subjectItem){
            $topSubs[] = $subjectItem->subject_slug;
        }
    }

    $subject = str_replace(array('-tutors','-tutor'),'',$subject);

    if(!in_array($subject, $topSubs)){
        $app->redirect('/tutors');
    }


    $counter = 10;

    $sql = "
		SELECT
			subjects.subject_slug,

            user.first_name,
            user.last_name,
            user.username,
            user.email,
            user.url,
            user.last_active,
            user.usertype,
            user.last_active,
            user.emptybgcheck,
            user.city_slug,
            user.state_slug,
            user.city,
            user.state_long,
            user.zipcode,


            profile.hourly_rate,
            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
            profile.short_description_verified,
            profile.personal_statement_verified

		FROM
			avid___user_subjects subjects

        INNER JOIN

            avid___user user on user.email = subjects.email

        INNER JOIN

            avid___user_profile profile on user.email = profile.email

		WHERE
			CONCAT(subjects.subject_name,' ',subjects.subject_slug,' ',subjects.parent_slug) LIKE :subject
                AND
            subjects.status = 'verified'
                AND
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
			user.last_active >= DATE_SUB(CURDATE(), INTERVAL 4 MONTH)

        GROUP BY subjects.email

        ORDER BY RAND()

        LIMIT $counter
	";

	$prepare = array(
		':subject'=>"%$subject%"
	);

    $cachedKey = "topsubjects---".$subject;
    //$app->connect->cache->delete($cachedKey);
    $results = $app->connect->cache->get($cachedKey);
    if($results == null) {
        $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        $app->connect->cache->set($cachedKey, $results, 3600);
    }

    $subjectName = ucwords(str_replace('-',' ',$subject));

    $app->meta = new stdClass();
    $app->meta->title = 'Top '.$counter.' '.$subjectName.' Tutors';
    $app->meta->h1 = 'Top <span class="top-count">'.$counter.'</span> '.$subjectName.' Tutors';

    if(isset($results[0])){
        $app->topresults = $results;
    }
