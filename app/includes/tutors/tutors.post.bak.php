<?php
	

	
	// Fix search types
	if(!empty($app->search->zipcode) && empty($app->search->distance)){
		$app->search->distance = 15;
	}
	
	if(empty($app->search->zipcode) && isset($app->search->zipcode)){
		if(isset($app->search->zipcode)){unset($app->search->zipcode);}
	}
	
	if(empty($app->search->advanced)){
		if(isset($app->search->agerangeUpper)){unset($app->search->agerangeUpper);}
		if(isset($app->search->agerangeLower)){unset($app->search->agerangeLower);}
		if(isset($app->search->pricerangeUpper)){unset($app->search->pricerangeUpper);}
		if(isset($app->search->pricerangeLower)){unset($app->search->pricerangeLower);}
	}
	
	if(empty($app->search->zipcode) && !empty($app->search->distance)){
		if(isset($app->search->distance)){unset($app->search->distance);}
	}
	
	$jsonSearch = json_encode($app->search);
	
	$app->setCookie('searching',$jsonSearch, '2 days');
	
	
	if(isset($app->search)){
		
		$search = $app->connect->createQueryBuilder()
				      ->select("user.*, profile.*, ".account_settings()."")
					  ->from("avid___user","user")
					  ->where('user.usertype = :usertype')
					  ->setParameter(":usertype","tutor")
					  ->andWhere('user.status IS NULL')
					  ->andWhere('user.hidden IS NULL')
					  ->andWhere('user.lock IS NULL')
					  ->innerJoin('user', 'avid___user_profile', 'profile', 'user.email = profile.email')
					  ->innerJoin('user', 'avid___user_account_settings', 'settings', 'user.email = settings.email')
					  ->groupBy('user.email');
		
		if(!empty($app->search->search)){
			$search->addSelect('subjects.subject_name')->
						innerJoin('user', 'avid___user_subjects', 'subjects', 'user.email = subjects.email')->
						andWhere("subject_name LIKE :subject_name")->setParameter(':subject_name',"%".$app->search->search."%");
		}
		
		if(isset($app->search->zipcode)){
			
			$zipcodedata = get_zipcode_data($app->connect,$app->search->zipcode);
			
			if(empty($zipcodedata)){
				
				notify('invalid zipcode');
				
			}
			
			if(isset($zipcodedata->lat) && isset($app->search->distance)){
				$getDistance = " ((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515  as distance ";
				//$getDistance = " round( (3959 * acos(cos(radians(".$zipcodedata->lat.")) * cos(radians(user.lat)) * cos(radians(user.lon) - radians(".$zipcodedata->long.")) + sin(radians(".$zipcodedata->lat.")) * sin(radians(user.lat))))) as distance ";
				$search->addSelect($getDistance)->setParameter(':distance',$app->search->distance)->having("distance <= :distance");
			}
		}
		
		if(isset($app->search->name)){
			
			$search->andWhere('first_name LIKE :first_name')->setParameter(':first_name',"%".$app->search->name."%");
			
			//notify($search);
			
		}
			
		if(isset($app->search->advanced)){
			
			if(!empty($app->search->gender)){
				$search->addSelect('profile.gender')->andWhere("profile.gender = :gender")->setParameter(':gender',$app->search->gender);
			}
			
			if(!empty($app->search->agerangeLower) && !empty($app->search->agerangeUpper)){

				$search->addSelect("IFNULL(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(birthday)), '%Y')+0,99) AS age");
				$search->andWhere("IFNULL(DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(birthday)), '%Y')+0,99) BETWEEN :agerangeLower and :agerangeUpper");
				$search->setParameter(':agerangeLower',$app->search->agerangeLower);
				$search->setParameter(':agerangeUpper',$app->search->agerangeUpper);

			}
			
			if(!empty($app->search->pricerangeLower) && !empty($app->search->pricerangeUpper)){
				$search->addSelect("hourly_rate")
					   ->andWhere("profile.hourly_rate BETWEEN :pricerangeLower and :pricerangeUpper")
					   ->setParameter(':pricerangeLower',$app->search->pricerangeLower)
					   ->setParameter(':pricerangeUpper',$app->search->pricerangeUpper);
			}
			
		}
		
		if(isset($app->search->distance)){
			$search->orderBy("distance","ASC");
		}
		
		if(empty($app->search->search) && empty($app->search->zipcode) && empty($app->search->distance) && empty($app->search->name) && empty($app->search->gender) && empty($app->search->agerangeLower) && empty($app->search->agerangeUpper) && empty($app->search->pricerangeLower) && empty($app->search->pricerangeUpper)){
			$search->orderBy("last_active",'DESC');//->setMaxResults($app->dependents->pagination->items_per_page);
		}
		
		$count = $search->execute()->rowCount();
		$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
		$results = $search->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
		
		$pagify = new Pagify();
		$config = array(
			'total'    => $count,
			'url'      => $app->target->pagebase,
			'page'     => $offsets->number,
			'per_page' => $offsets->perpage
		);
		$pagify->initialize($config);
		$app->pagination = $pagify->get_links();
		
		$app->searchResults = $results;
		

	}
	
