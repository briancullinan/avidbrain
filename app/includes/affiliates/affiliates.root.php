<?php

	if(isset($app->user->email)){
		$app->usersettings = $app->user->settings();
		if(isset($app->usersettings->affiliateprogram) && $app->usersettings->affiliateprogram=='yes'){
			$sql = "SELECT * FROM avid___affiliates WHERE email = :email";
			$prepare = array(':email'=>$app->user->email);
			$results = $app->connect->executeQuery($sql,$prepare)->fetch();
			if(empty($results)){

				$insert = array(
					'email'=>$app->user->email,
					'mycode'=>randomaffiliate($app->connect,3),
					'active'=>1,
					'password'=>$app->user->password,
					'first_name'=>$app->user->first_name,
					'last_name'=>$app->user->last_name
				);

				if(!empty($app->user->getpaid)){
					$insert['getpaid'] = $app->user->getpaid;
				}
				if(!empty($app->user->account_id)){
					$insert['account_id'] = $app->user->account_id;
				}
				if(!empty($app->user->managed_id)){
					$insert['managed_id'] = $app->user->managed_id;
				}

				$app->connect->insert('avid___affiliates',$insert);
			}
			else{

				$update = array();
				$update['password'] = $app->user->password;
				$update['first_name'] = $app->user->first_name;
				$update['last_name'] = $app->user->last_name;
				$update['getpaid'] = $app->user->getpaid;
				$update['account_id'] = $app->user->account_id;
				$update['managed_id'] = $app->user->managed_id;

				$app->connect->update('avid___affiliates',$update,array('email'=>$app->user->email));
			}

			$app->affiliate = $results;
		}
		elseif($app->usersettings->affiliateprogram=='no'){

		}
	}
	elseif(isset($app->affiliate->email)){

	}
	else{
		$app->redirect('/signup/affiliate');
	}

	function get_affiliate($connect,$email){
		$sql = "SELECT * FROM avid___affiliates WHERE email = :email";
		$prepare = array(':email'=>$email);
		return $connect->executeQuery($sql,$prepare)->fetch();
	}

	function total_affiliate($count){
        return ($count*20);
    }

	if(isset($app->user->email)){
		$theaffiliate = get_affiliate($app->connect,$app->user->email);
	}
	elseif(isset($app->affiliate->email)){
		$theaffiliate = $app->affiliate;
	}

	//notify($theaffiliate);

	if(isset($theaffiliate->mycode)){

		function studentsiwthsessions($connect,$mycode){
			$sql = "
		        SELECT
		            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
		            sessions.id
		        FROM
		            avid___user user

		        INNER JOIN

		            avid___sessions sessions on user.email = sessions.to_user

		        WHERE
		            promocode = :promocode
		                AND
		            sessions.session_status = :status
		                AND
		            user.usertype = 'student'

		        GROUP BY user.email
		    ";

		    $prepare = array(
		        ':promocode'=>$mycode,
		        ':status'=>'complete'
		    );

		    $results = $connect->executeQuery($sql,$prepare)->fetchAll();
		    if(isset($results[0])){
		        return $results;
		    }
		}

		function tutorswithsessions($connect,$mycode){
			$sql = "
		        SELECT
		            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
		            sessions.id
		        FROM
		            avid___user user

		        INNER JOIN

		            avid___sessions sessions on user.email = sessions.from_user

		        WHERE
		            promocode = :promocode
		                AND
		            sessions.session_status = :status
		                AND
		            user.usertype = 'tutor'

		        GROUP BY user.email
		    ";

		    $prepare = array(
		        ':promocode'=>$mycode,
		        ':status'=>'complete'
		    );

		    $results = $connect->executeQuery($sql,$prepare)->fetchAll();
		    if(isset($results[0])){
		        return $results;
		    }
		}

		function signups($connect,$mycode){
			$sql = "
		        SELECT
		            user.email,user.promocode,user.usertype,user.first_name,user.signup_date,
		            payments.id
		        FROM
		            avid___user user

		        LEFT JOIN
		            avid___affiliates_payments payments on user.email = payments.paid_email

		        WHERE
		            promocode = :promocode

		        ORDER BY user.id DESC
		    ";

		    $prepare = array(
		        ':promocode'=>$mycode
		    );

		    $results = $connect->executeQuery($sql,$prepare)->fetchAll();

		    if(isset($results[0])){
		        return $results;
		    }
		}

		$studentsiwthsessions = studentsiwthsessions($app->connect,$theaffiliate->mycode);
		$tutorswithsessions = tutorswithsessions($app->connect,$theaffiliate->mycode);
		$signups = signups($app->connect,$theaffiliate->mycode);

		$one = array();
	    if(!empty($studentsiwthsessions)){
			$one = $studentsiwthsessions;
	        $app->studentsiwthsessions = $studentsiwthsessions;
	    }

		$two = array();
	    if(!empty($tutorswithsessions)){
			$two = $tutorswithsessions;
	        $app->tutorswithsessions = $tutorswithsessions;
	    }

		if(!empty($signups)){
	        $app->signups = $signups;
	    }

	    $three = array_merge($one,$two);
	    $app->affiliatecount = count($three);

	}
