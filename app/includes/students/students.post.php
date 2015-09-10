<?php
	
	$jsonSearch = json_encode($app->searchingforstudents);
	$app->setCookie('searchingforstudents',$jsonSearch, '2 days');
	
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('user.id')->from('avid___user','user');
	$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
	$data	=	$data->innerJoin('user','avid___user_profile','profile','user.email = profile.email');
	
	
	$data	=	$data->where('user.usertype = :usertype');
	$data	=	$data->andWhere('settings.showmyprofile = :showmyprofile');
	$data	=	$data->andWhere('user.hidden IS NULL');
	$data	=	$data->andWhere('user.status IS NULL');
	$data	=	$data->andWhere('user.lock IS NULL');

	$data	=	$data->setParameter(':usertype','student');
	$data	=	$data->setParameter(':showmyprofile','yes');
	
	if(isset($app->searchingforstudents)){
		
		if(isset($app->searchingforstudents->studentname) && !empty($app->searchingforstudents->studentname)){
			$data	=	$data->andWhere('CONCAT(user.first_name," ",user.last_name) LIKE :searchterm');
			$data	=	$data->setParameter(':searchterm',"%".$app->searchingforstudents->studentname."%");
		}
		
		
		if(isset($app->searchingforstudents->zipcode) && !empty($app->searchingforstudents->zipcode)){
			
			$data	=	$data->andWhere('user.lat IS NOT NULL');
			$data	=	$data->andWhere('user.long IS NOT NULL');
			
			$zipcodedata = get_zipcode_data($app->connect,$app->searchingforstudents->zipcode);
			if(empty($app->searchingforstudents->distance)){
				$app->searchingforstudents->distance = 15;
			}
			
			if(empty($zipcodedata)){
				new Flash(
					array('action'=>'alert','message'=>'Invalid TOOBS')
				);
			}
			else{
				if(isset($zipcodedata->lat)){
					
					if($app->searchingforstudents->zipcode=='00000'){
						
						$data	=	$data->andWhere('user.zipcode = 00000');
						
						
					}
					else{
						
						$getDistance = "
							round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) 
						";
						
						$app->getDistance = true;
						
						$asDistance = ' as distance ';
						$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',$app->searchingforstudents->distance)->having("distance <= :distance");
						
						$data	=	$data->andWhere('user.zipcode != 00000');
						
					}
					//notify($data);
				}
			}
		}
	}
	
	$count	=	$data->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
		
	$data	=	$data->addSelect('user.*, '.account_settings().', '.profile_select());	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	if(isset($app->filterby)){
		if($app->filterby=='lastactive'){
			$data	=	$data->orderBy('user.last_active','DESC');
		}
		elseif(isset($app->getDistance) && $app->filterby=='furthestdistance'){
			$data	=	$data->orderBy('distance','DESC');
		}
		elseif(isset($app->getDistance) && $app->filterby=='closestdistance'){
			$data	=	$data->orderBy('distance','ASC');
		}
		else{
			$data	=	$data->orderBy('user.last_active','DESC');
		}
	}
	else{
		if(isset($app->getDistance)){
			$data	=	$data->orderBy('distance','ASC');	
		}
		else{
			$data	=	$data->orderBy('user.last_active','DESC');
		}
		
	}
	
	//notify('STOODENTS');
	
	$data	=	$data->execute()->fetchAll();
	
	$app->students = $data;
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => $app->target->pagebase,
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
	
	$app->meta = new stdClass();
	$app->meta->title = $app->dependents->SITE_NAME_PROPPER.' Students';