<?php

    $map = [
        0=>'subject',
        1=>'location',
        2=>'distance',
        3=>'name',
        4=>'gender',
        5=>'pricelow',
        6=>'pricehigh'
    ];

    $preparedStatement = [];

    $appget = (object)[];
    if(!empty($query)){
        foreach($query as $key=> $assignMap){
            if(strpos($assignMap, "(") !== false || strpos($assignMap, ")") !== false) {
                $sort = str_replace(array('(',')'),'',$assignMap);
                $appget->sort = $sort;
            }
            elseif(strpos($assignMap, "[") !== false || strpos($assignMap, "]") !== false) {
                $page = str_replace(array('[',']'),'',$assignMap);
                $appget->page = $page;
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

    if(!empty($subject)){

        $cachedSubjectKey = "cachedsubjectslug--".$subject;
        $cachedSubjectSlug = $app->connect->cache->get($cachedSubjectKey);
        if($cachedSubjectSlug == null) {
            $sql = "
        		SELECT
        			subjects.subject_name
        		FROM
        			avid___available_subjects subjects
        		WHERE
        			subjects.subject_slug = :subjects
        	";
        	$prepare = array(
        		':subjects'=>$subject
        	);
        	$cachedSubjectSlug = $app->connect->executeQuery($sql,$prepare)->fetch();
            $app->connect->cache->set($cachedSubjectKey, $cachedSubjectSlug, 3600);
        }

        if(isset($cachedSubjectSlug->subject_name)){
            $subjecttext = $cachedSubjectSlug->subject_name;
        }
        else{
            $subjecttext = ucwords($subject);
        }

        $cachedSubjectQuery = new stdClass();
        $cachedSubjectQuery->subject_name = $subjecttext;
        $app->cachedSubjectQuery = $cachedSubjectQuery;
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

    $offsets = new offsets((isset($page) ? $page : 1),$app->dependents->pagination->items_per_page);
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

    if(isset($location)){
        $cachedZipcodeKey = "searchingcachedzipcode-".$location;
        $cachedZipcode = $app->connect->cache->get($cachedZipcodeKey);
        if($cachedZipcode == null) {
            $cachedZipcode = get_zipcode_data($app->connect,$location);
            $app->connect->cache->set($cachedZipcodeKey, $cachedZipcode, 3600);
        }

        if(empty($distance)){
            $distance = 15;
        }

        if(isset($cachedZipcode->id)){

            $app->cachedZipcode = $cachedZipcode;

            $getDistance = "round(((acos(sin((" . $cachedZipcode->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $cachedZipcode->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$cachedZipcode->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) ";
            $asDistance = ' as distance ';
            $select[] = $getDistance.$asDistance;
            $having = "HAVING distance <= :distance";
            $preparedStatement[':distance'] = $distance;
            //notify($select);
        }
        else{
            $_SESSION['slim.flash']['error'] = 'Invalid Zipcode';
            //notify('Invalidzopcode');
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

    //$app->connect->cache->clean();


    $sql = "
        SELECT
            SQL_CALC_FOUND_ROWS
            user.email,
            user.username,
            user.usertype,
            user.last_active,
            user.url,

            user.first_name,
            user.last_name,
            CONCAT(user.city,', ',user.state_long,' ',user.zipcode) as location,

            profile.hourly_rate,
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

    $pagebase = str_replace("[$page]",'',$app->request->getPath());



    //notify($app->queries);
    #notify($sql);
    $cachedname = 'NEWCACHE---';
    foreach($app->queries as $cachekey => $buildcachename){
        $cachedname.='-'.$buildcachename;
    }
    $cachedname = str_replace(array(' '),'',$cachedname);
    $cachedname = strtolower($cachedname);

    $cachedSearchResults = $app->connect->cache->get($cachedname);
    if($cachedSearchResults == null) {
        $cachedSearchResults = new stdClass();
        $cachedSearchResults->results = $app->connect->executeQuery($sql,$preparedStatement)->fetchAll();
        $count = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
        $cachedSearchResults->count = $count->count;

        $app->connect->cache->set($cachedname, $cachedSearchResults, 3600);
    }


    foreach($cachedSearchResults->results as $key=>$build){
        $cachedSearchResults->results[$key]->personal_statement_verified = truncate($build->personal_statement_verified,400);
        $cachedSearchResults->results[$key]->img = userphotographs($app->user,$build,$app->dependents);
        $cachedSearchResults->results[$key]->short = short($build);
    }

    //notify($cachedSearchResults->results);

    if(isset($cachedSearchResults->count) && $cachedSearchResults->count > 0){
        $pagify = new Pagify();
		$config = array(
            'number_wrap'=>array('[',']'),
			'total'    => $cachedSearchResults->count,
			'url'      => $pagebase,
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);

		$pagify->initialize($config);
        if($page > $pagify->last_page_number){
            $app->redirect($pagebase.'/['.$pagify->last_page_number.']');
        }
        $app->pagination = $pagify->get_links();
    }

    if(isset($cachedSearchResults->results)){
        $app->searching = $cachedSearchResults->results;
        $app->count = $cachedSearchResults->count;
    }
