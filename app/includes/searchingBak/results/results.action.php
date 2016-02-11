<?php

    $map = [
        0=>'subject',
        1=>'zipcode',
        2=>'distance',
        3=>'name',
        4=>'gender',
        5=>'pricelow',
        6=>'pricehigh'
    ];

    $appget = (object)[];
    if(!empty($query)){
        foreach($query as $key=> $assignMap){
            if(strpos($assignMap, "(") !== false || strpos($assignMap, ")") !== false) {
                $sort = str_replace(array('(',')'),'',$assignMap);
            }
            elseif(strpos($assignMap, "[") !== false || strpos($assignMap, "]") !== false) {
                $page = str_replace(array('[',']'),'',$assignMap);
            }
            elseif(!empty($assignMap) && $assignMap!='---'){
                if(isset($map[$key])){
                    $appget->$map[$key] = $assignMap;
                    $$map[$key] = $assignMap;
                }

            }
        }

        if(empty($sort)){
            $sort = 'user.last_active';
        }
        if(empty($page)){
            $page = 1;
        }
    }
    $app->queries = $appget;
    //notify($app->queries);

    if(!empty($subject)){
        $cachedSubjectInfo = 'cachedsubjectinfo'.$subject;
        notify($cachedSubjectInfo);
    }


    $sortMap = [
        'last_active'=>'user.last_active DESC',
        'distance_asc'=>'distance ASC',
        'distance_desc'=>'distance DESC',
        'hourly_asc'=>'profile.hourly_rate ASC',
        'hourly_desc'=>'profile.hourly_rate DESC',
        'star_score'=>'star_score DESC'
    ];

    $sortType = $sort;
    if(isset($sortMap[$sort])){
        $sortType = $sortMap[$sort];
    }


    $having = '';
    $select = [];
    $joins = [];
    $where = [];

    $offsets = new offsets((isset($page) ? $page : 1),PERPAGE);
    //notify($offsets);

	$limitOffset = "
		LIMIT
			".$offsets->perpage."
		OFFSET
			".$offsets->offsetStart."
	";

    if(isset($sort) && $sort=='star_score'){
        $select['starscore'] = "
            round((SELECT sum(sessions.review_score) as sum FROM avid___sessions sessions WHERE sessions.from_user = user.email)
                /
            ( SELECT count(sessions.review_score) as count FROM avid___sessions sessions WHERE sessions.from_user = user.email ) ,2) as star_score
        ";
        $where[] = "round((SELECT sum(sessions.review_score) as sum FROM avid___sessions sessions WHERE sessions.from_user = user.email)
            /
        ( SELECT count(sessions.review_score) as count FROM avid___sessions sessions WHERE sessions.from_user = user.email ) ,2) IS NOT NULL";
    }

    if(isset($subject)){
        $preparedStatement[':subject'] = "%$subject%";
        $select[] = "subjects.subject_slug";
        $where[] = "CONCAT(subjects.subject_name,' ',subjects.subject_slug,' ',subjects.parent_slug) LIKE :subject";
        $joins['subject'] = "INNER JOIN avid___user_subjects subjects on subjects.email = user.email";
    }
    if(isset($zipcode) && strlen($zipcode)==5){
        $cachedZipcodeKey = "searchingcachedzipcode-".$zipcode;
        $cachedZipcode = $app->connect->cache->get($cachedZipcodeKey);
        if($cachedZipcode == null) {
            $cachedZipcode = get_zipcode_data($app->connect,$zipcode);
            $app->connect->cache->set($cachedZipcodeKey, $cachedZipcode, 3600);
        }

        if(empty($distance)){
            $distance = 15;
        }

        if(isset($cachedZipcode->id)){

            $getDistance = "round(((acos(sin((" . $cachedZipcode->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $cachedZipcode->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$cachedZipcode->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) ";
            $asDistance = ' as distance ';
            $select[] = $getDistance.$asDistance;
            $having = "HAVING distance <= :distance";
            $preparedStatement[':distance'] = $distance;
            //notify($select);
        }
    }

    if(isset($name)){
        $preparedStatement[':name'] = "%$name%";
        $select[] = "CONCAT(user.first_name,' ',user.last_name) as name";
        $where[] = "CONCAT(user.first_name,' ',user.last_name) LIKE :name";
    }
    if(isset($gender)){
        $select[] = 'profile.gender';
        $preparedStatement[':gender'] = $gender;
        $where[] = "profile.gender = :gender";
    }

    if(empty($pricelow) && isset($pricehigh)){
        $pricelow = 0;
    }
    if(isset($pricelow) && isset($pricehigh)){
        $preparedStatement[':pricelow'] = $pricelow;
        $preparedStatement[':pricehigh'] = $pricehigh;
        $select[] = 'profile.hourly_rate';
        $where[] = "profile.hourly_rate BETWEEN :pricelow and :pricehigh";
    }

    function makeNow($array,$addon){
        $string = '';
        foreach($array as $item){
            $string.= $addon."\n\t".$item."\n";
        }
        return $string;
    }

    //printer($preparedStatement);
    $select = makeNow($select,",");
    $where = makeNow($where,"AND");
    $joins = makeNow($joins,NULL);

    //notify($select);


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

            profile.my_avatar,
            profile.my_avatar_status,
            profile.my_upload,
            profile.my_upload_status,
            profile.short_description_verified,
            profile.personal_statement_verified

        $select

        FROM
            avid___user user

        INNER JOIN avid___user_profile profile on profile.email = user.email

        $joins

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

        $where

        GROUP BY user.email

        $having

        ORDER BY $sortType

        $limitOffset
    ";

    #notify($sql);

    $results = $app->connect->executeQuery($sql,$preparedStatement)->fetchAll();
    $count = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
    if(isset($results[0])){
        $app->searching = $results;
        $app->count = $count->count;
    }
    // printer($count);
    // notify($results);
