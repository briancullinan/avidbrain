<?php

//	notify($app->parameters);

	    if(isset($state) && empty($city)){
	        $sql = "
				SELECT
					*,
	                COUNT(city) as count

				FROM
					avid___location_data
				WHERE
					state_long = :state
	                    OR
	                state_long = :statefix

	            GROUP BY city

	            ORDER BY count DESC

	            LIMIT 1
			";
			$prepare = array(
				':state'=>$state,
	            ':statefix'=>str_replace('-',' ',$state)
			);
			$zipcode = $app->connect->executeQuery($sql,$prepare)->fetch();
	    }

	    if(isset($city) && isset($state)){
	        $sql = "
				SELECT
					*,
	                COUNT(city) as count

				FROM
					avid___location_data
				WHERE
					state_long = :state AND city = :city
	                    OR
	                state_long = :statefix AND city = :cityfix

	            GROUP BY city

	            ORDER BY count DESC

	            LIMIT 1
			";
			$prepare = array(
				':state'=>$state,
	            ':statefix'=>str_replace('-',' ',$state),
	            ':city'=>$city,
	            ':cityfix'=>str_replace('-',' ',$city)
			);
			$zipcode = $app->connect->executeQuery($sql,$prepare)->fetch();
	    }

        if(isset($zipcode->zipcode)){


            $app->redirect('/searching/'.str_replace('-tutors','',$subject).'/'.$zipcode->zipcode.'/50/---/---/0/200/(distance_asc)/[1]');
        }
