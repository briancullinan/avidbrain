<?php
    // GETIT

    //notify($app->keyname);

    if(isset($_POST['getdata'])){
        if(isset($_POST['getdata'])){
            foreach($_POST as $key=> $post){
                $_POST[$key] = clean($post);
            }
            $getdata = (object)$_POST['getdata'];
        }

        $getDistance = "round(((acos(sin((" . $getdata->ziplat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $getdata->ziplat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$getdata->ziplong. "- user.long)* pi()/180))))*180/pi())*60*1.1515) ";
        $asDistance = ' as distance ';
        $having = "HAVING distance <= :distance";
        $selectDistance = $getDistance.$asDistance;


        $sql = "
    		SELECT
                user.id,
                user.first_name,
                user.last_name,
                user.url,
    			user.email,
                user.lat,
                user.long,
                user.username,
                $selectDistance,

                profile.hourly_rate,
                profile.my_avatar,
                profile.my_avatar_status,
                profile.my_upload,
                profile.my_upload_status,
                profile.short_description_verified,
                profile.personal_statement_verified
    		FROM
    			avid___user user
            LEFT JOIN avid___user_profile profile on profile.email = user.email
    		WHERE
    			user.usertype = 'tutor'
                    AND
                user.status IS NULL
                    AND
                user.hidden IS NULL
                    and
                user.lock IS NULL

            GROUP BY user.email

            $having

            ORDER BY distance ASC

            LIMIT 50
    	";

    	$prepare = array(
    		':distance'=>$getdata->distance
    	);
    	$results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        //notify($prepare);
        if(isset($results[0])){
            foreach($results as $key=>$build){
                $short = short($build);
                $results[$key]->short = $short;

                $content = '<div class="maps-users">';
                    $content.='<div class="maps-users-img"><a target="_blank" href="'.$build->url.'"><img class="responsive-img" src="'.userphotographs($app->user,$build).'" /></a></div>';
                    $content.='<div class="maps-users-link"><a target="_blank" href="'.$build->url.'">'.$short.'</a></div>';
                    $content.='<div class="maps-users-price">$'.numbers($build->hourly_rate).'/ <span>Hour</span></div>';
                $content.='</div>';
                $results[$key]->content = $content;

            }
        }
        else{
            $results = array('message'=>'No Users Fund','zipdata'=>$getdata);
        }

        notify($results);

    }
    elseif(!empty($app->whatsyourzipcode->zipcode) && strlen($app->whatsyourzipcode->zipcode)==5){
        $getzipinfo = get_zipcode_data($app->connect,$app->whatsyourzipcode->zipcode);
        if(isset($getzipinfo->id)){
            $app->setCookie('getzipcode',$app->whatsyourzipcode->zipcode, '2 days');
            $app->redirect('/locate');
        }
    }
