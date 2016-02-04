<?php
    $homepageMap = [];
    $homepageMap['admin'] = $app->target->base.'admin.include.php';
    $homepageMap['student'] = $app->target->base.'student.include.php';
    $homepageMap['tutor'] = $app->target->base.'tutor.include.php';

    if(isset($app->user->usertype)){
        $app->target->include = $homepageMap[$app->user->usertype];

        if($app->user->usertype=='student'){
            $sql = "
        			SELECT
        				approved.tutor_email,
        				user.first_name,
        				user.last_name,
        				user.url
        			FROM
        				avid___approved_tutors approved

        			INNER JOIN
        				avid___user user on user.email = approved.tutor_email

        			WHERE
        				approved.student_email = :student_email
        		";
        		$prepare = array(':student_email'=>$app->user->email);
        		$mytutors = $app->connect->executeQuery($sql,$prepare)->fetchAll();

        		if(isset($mytutors[0])){
        			$app->mytutors = $mytutors;
        		}


        	if(isset($app->user->usertype) && $app->user->usertype=='student'){
        		$sql = "SELECT id FROM avid___jobs WHERE email = :email AND open IS NOT NULL ORDER BY applicants DESC";
        		$prepeare = array(':email'=>$app->user->email);
        		$my_jobs = $app->connect->executeQuery($sql,$prepeare)->rowCount();
        		if($my_jobs>0){
        			$app->my_jobs = $my_jobs;
        		}
        	}

        	// Check for sessions without reviews
        	$data	=	$app->connect->createQueryBuilder();
        	$data	=	$data->select('sessions.*, user.first_name,user.last_name,user.url')->from('avid___sessions','sessions');
        	$data	=	$data->where('sessions.to_user = :myemail AND sessions.session_status = "complete" AND sessions.review_name IS NULL')->setParameter(':myemail',$app->user->email);
        	$data	=	$data->innerJoin('sessions','avid___user','user','user.email = sessions.from_user');
        	$data	=	$data->execute()->fetchAll();
        	//printer($data);
        	if(isset($data[0])){
        		$app->needsreview = $data;
        	}
        }
        elseif($app->user->usertype=='tutor'){

            $sql = "
        		SELECT
        			approved.tutor_email,
        			user.first_name,
        			user.last_name,
        			user.url,
        			user.customer_id,
        			user.promocode
        		FROM
        			avid___approved_tutors approved

        		INNER JOIN
        			avid___user user on user.email = approved.student_email

        		WHERE
        			approved.tutor_email = :tutor_email
        	";
        	$prepare = array(':tutor_email'=>$app->user->email);
        	$mystudents = $app->connect->executeQuery($sql,$prepare)->fetchAll();
        	//notify($mystudents);

        	if(isset($mystudents[0])){
        		$app->mystudents = $mystudents;
        	}

        }


        //EVERYONE
        if(isset($app->user->usertype) && $app->user->usertype=='admin'){
			$app->redirect('/admin-everything');
			///$app->target->include = str_replace('.include.','.admin.',$app->target->include);
			///$app->target->css = "";
		}
		elseif(empty($app->user->zipcode)){
			unset($app->leftnav);
			$app->target->css = "hide-everything";
			$app->target->include = str_replace('loggedin','add.zipcode',$app->target->loggedin);

			if(empty($app->user->url) && isset($app->user->zipcode)){
				//$app->user->url = make_my_url($app->user,$numbers);
			}
		}
		elseif(isset($app->user->email) && empty($app->user->welcome)){
			$app->target->include = str_replace('loggedin','welcome',$app->target->loggedin);
			$app->target->css = "";

			//$numbers = unique_username($app->connect,1);
			$app->user->welcome = 1;
			//$app->user->username = $numbers;
			$app->user->save();


			if(empty($app->user->settings())){
				$sql = "INSERT INTO avid___user_account_settings SET email = :email";
				$prepare = array(':email'=>$app->user->email);
				$settings = $app->connect->executeQuery($sql,$prepare);
			}

		}
		elseif(isset($app->user->email) && isset($app->user->welcome)){
			$app->target->include = $app->target->user->include;
			$app->target->css = "";
		}


		$data	=	$app->connect->createQueryBuilder();
		$data	=	$data->select('promotions.*, user.first_name, user.last_name, user.url')->from('avid___promotions_active','promotions');
		$data	=	$data->where('promotions.email = :myemail AND promotions.used IS NULL AND promotions.activated IS NOT NULL')->setParameter(':myemail',$app->user->email);
		$data	=	$data->leftJoin('promotions','avid___user','user','user.email = promotions.sharedwith');
		$data	=	$data->orderBy('id','DESC');
		$data	=	$data->execute()->fetchAll();
		//notify($data);

		if(isset($data[0])){
			$app->myrewards = $data;
		}
        // EBERYONE

    }
    else{
        $app->target->include = $app->target->base.'loggedout.include.php';

        $limit = 15;

        $sql = "
            SELECT
                subjects.subject_slug,
                subjects.parent_slug,
                subjects.subject_name,
                count(subject_slug) as count
            FROM
                avid___user_subjects subjects

            INNER JOIN

            avid___user user on user.email = subjects.email

            WHERE
                subjects.usertype = 'tutor'
                    AND
                user.status IS NULL
                    AND
                user.hidden IS NULL
                    AND
                user.lock IS NULL

            GROUP BY subjects.subject_slug

            ORDER BY count DESC

            LIMIT $limit
        ";
        $prepare = array(

        );


        $cachedKey = "toptutoredsubjects--".$limit."limit";
        $results = $app->connect->cache->get($cachedKey);
        if($results == null) {
            $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            $app->connect->cache->set($cachedKey, $results, 3600);
        }

        if(isset($results[0])){
            $app->top = $results;
        }

    }
