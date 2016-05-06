<?php

    $prepare = [];
    $additionalSelect='';
    $additionalWhere='';
    $having = '';
    $additionalOrder = '';

    if(empty($app->searchingforjobs)){
        $app->searchingforjobs = json_decode($app->getCookie('searchingforjobs'));
    }

    //notify($app->searchingforjobs);

    if(!empty($app->searchingforjobs)){
        if(!empty($app->searchingforjobs->search)){
            $additionalWhere = 'WHERE CONCAT(jobs.subject_name," ",jobs.subject_slug," ",jobs.parent_slug) LIKE :subject_name';
            $prepare[':subject_name'] = "%".$app->searchingforjobs->search."%";
        }

        if(!empty($app->searchingforjobs->zipcode)){

            if(empty($app->searchingforjobs->distance)){
                $app->searchingforjobs->distance = 15;
            }

            $zipcodedata = get_zipcode_data($app->connect,$app->searchingforjobs->zipcode);
            if(isset($zipcodedata->id)){
                $getDistance = ", round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515)";
                $asDistance = ' as distance ';
                $additionalSelect.= $getDistance.$asDistance;
                $having = "HAVING distance <= :distance";
                $prepare[':distance'] = $app->searchingforjobs->distance;
                $additionalOrder = "distance ASC, ";    
            }


            //notify($additionalWhere);
        }

        $app->setCookie('searchingforjobs',json_encode($app->searchingforjobs), '2 days');
    }



    // ACTION CALLS
    $offsets = new offsets((isset($number) ? $number : 1),PERPAGE);

	$limitOffset = "
		LIMIT
			".$offsets->perpage."
		OFFSET
			".$offsets->offsetStart."
	";

    $sql = "
        SELECT
            SQL_CALC_FOUND_ROWS
            jobs.*,
            user.first_name,
            user.url,
            user.zipcode,
            user.city,
            user.state,
            user.state_long,
            user.lat,
            user.long,
            IFNULL(user.first_name,'Student') as first_name,
            (
                SELECT count(applicants.id) FROM avid___jobs_applicants applicants WHERE applicants.jobid = jobs.id
            ) as applicants
            $additionalSelect

        FROM
            avid___jobs jobs

        INNER JOIN

            avid___user user
                on user.email = jobs.email

            $additionalWhere


        GROUP BY jobs.id

            $having

        ORDER BY  $additionalOrder jobs.open DESC, jobs.date DESC

            $limitOffset
    ";

    //notify($prepare);
    $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    //notify($results);

    $howmany = $app->connect->executeQuery("SELECT FOUND_ROWS() as count",array())->fetch();
    $app->howmanyCount = $howmany->count;
    if($app->howmanyCount>0){

        $app->meta = new stdClass();
        $app->meta->title = 'MindSpree Jobs';
        $app->meta->h1 = 'Find A Tutoring Job ';

        if(!empty($app->searchingforjobs->search)){
            $app->meta->h1 = '<span class="blue-text">'.$app->howmanyCount.'</span> '.ucwords($app->searchingforjobs->search).' Jobs Found';
        }

        $app->jobposts = $results;

        $pagify = new Pagify();
        $config = array(
            'total'    => $howmany->count,
            'url'      => $app->target->pagebase,
            'page'     => $offsets->number,
            'per_page' => $offsets->perpage
        );

        $pagify->initialize($config);
        $app->pagination = $pagify->get_links();


    }
