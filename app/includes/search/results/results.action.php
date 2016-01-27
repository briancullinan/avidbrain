<?php

    $searching = [];

    $where = [];
    $additionalSelect = [];
    $orderBy = 'user.last_active DESC';
    $having = '';

    $cachedName = '';

    foreach($app->parameters as $key=> $param){
        $cachedName.= $param;
        if($param=='---'){
            //$$param = NULL;
            $$key = NULL;
        }
    }
    if(empty($pricelow)){
        $pricelow = 1;
    }

    //search--subject--location--distance--name--gender--pricerange--page--sort


    if(isset($subject)){
        $searching[':subject'] = "%$subject%";
        $additionalSelect[] = 'subjects.subject_slug';
        $where[] = "CONCAT(subjects.subject_name,' ',subjects.subject_slug,' ',subjects.parent_slug) LIKE :subject";

    }
    if(isset($location)){
        //notify($location);
        if(strlen($location)==5){
            $zipcodedata = get_zipcode_data($app->connect,$location);
        }
        else{
            $locationCheck = explode(',',$location);
            if(isset($locationCheck[0])){
                $city = $locationCheck[0];
                $searching[':location-city'] = $city;
            }
            if(isset($locationCheck[1])){
                $state = $locationCheck[1];
                $searching[':location-state'] = $state;
            }


            $zipcodedata = getcitystate($app->connect,$city,$state);

            $searching[':location'] = $location;
        }
        if(empty($distance)){
            $distance = 15;
        }

        if(isset($zipcodedata->id)){

            $getDistance = " round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) ";
            $asDistance = ' as distance ';
            $additionalSelect[] = $getDistance.$asDistance;
            $having = "HAVING distance <= :distance";

            $orderBy = 'distance ASC';

        }

    }
    if(isset($distance)){
        $searching[':distance'] = $distance;
    }

    if(isset($name)){
        $searching[':name'] = "%$name%";
        $additionalSelect[] = "CONCAT(user.first_name,' ',user.last_name) as name";
        $where[] = "CONCAT(user.first_name,' ',user.last_name) LIKE :name";
    }
    if(isset($gender)){
        $additionalSelect[] = 'profile.gender';
        $searching[':gender'] = $gender;
        $where[] = "profile.gender = :gender";
    }

    if(isset($pricehigh)){
        $searching[':pricelow'] = $pricelow;
        $searching[':pricehigh'] = $pricehigh;
        $where[] = "profile.hourly_rate BETWEEN :pricelow and :pricehigh";
        //notify($where);
    }

    //$sort
    //$page


    $offsets = new offsets((isset($page) ? $page : 1),$app->dependents->pagination->items_per_page);
    //notify($offsets);

	$limitOffset = "
		LIMIT
			".$offsets->perpage."
		OFFSET
			".$offsets->offsetStart."
	";


    $searching[':usertype'] = 'tutor';

    $addonSelect = '';
    if(!empty($additionalSelect)){
        foreach($additionalSelect as $select){
            $addonSelect.= ", $select \n";
        }
    }

    $addonWhere = '';
    if(!empty($where)){
        foreach($where as $addWhere){
            $addonWhere.= "AND $addWhere \n";
        }
    }

    //notify($addonWhere);

    $sql = "

        SELECT
            SQL_CALC_FOUND_ROWS
            user.email,
            user.username,
            user.usertype,
            user.last_active,
            user.url,
            user.city,
            user.state,
            user.state_long,
            user.zipcode,
            user.first_name,
            profile.hourly_rate,
            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
            profile.short_description_verified,
            profile.personal_statement_verified

            $addonSelect

        FROM
            avid___user user

        INNER JOIN
            avid___user_subjects subjects on subjects.email = user.email

        INNER JOIN
            avid___user_profile profile on profile.email = user.email

        WHERE

            user.usertype = :usertype
                AND
            user.status IS NULL
                AND
            user.hidden IS NULL
                AND
            profile.hourly_rate IS NOT NULL
                AND
            user.lock IS NULL
                AND
            user.last_active >= DATE_SUB(CURDATE(), INTERVAL 9 MONTH)

                $addonWhere

        GROUP BY user.email

            $having

        ORDER BY  $orderBy

            $limitOffset

    ";

    //notify($orderBy);

    /*
    GROUP BY jobs.id

        $having

    ORDER BY  $additionalOrder jobs.open DESC, jobs.date DESC

        $limitOffset
    */

    //notify($sql);

    //$app->connect->cache->clean();

    $cachedName = 'cachedget--'.str_replace('-','',$cachedName);
    $results = $app->connect->cache->get($cachedName);

    if($results == null) {
        $results = (object)[];
        $results->results = $app->connect->executeQuery($sql,$searching)->fetchAll();
        $count = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
        $results->count = $count->count;
        $results->numbers = numbers($count->count,1);
        $app->connect->cache->set($cachedName, $results, 3600);
    }

    if(isset($results->count)){
        $pagify = new Pagify();
		$config = array(
			'total'    => $results->count,
            'ignoreslash'=>true,
			'url'      => '/search#',
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);

		$pagify->initialize($config);
        $results->pagination = $pagify->get_links();

    }

    foreach($results->results as $key=> $build){
        $results->results[$key]->personal_statement_verified = truncate($build->personal_statement_verified,400);
        $results->results[$key]->img = userphotographs($app->user,$build,$app->dependents);
        unset($results->results[$key]->my_avatar);
        unset($results->results[$key]->my_upload);
        unset($results->results[$key]->my_upload_status);
        unset($results->results[$key]->email);
        unset($results->results[$key]->username);
    }

    echo json_encode($results);
    exit;
