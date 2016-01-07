<?php

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

	if(isset($theaffiliate)){

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
