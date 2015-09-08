<?php

	if(isset($app->findatutor)){
		
		
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('user.*')->from('avid___user','user');
			$data	=	$data->where('first_name LIKE :query');
			$data	=	$data->orWhere('last_name LIKE :query');
			$data	=	$data->orWhere('email LIKE :query');
			$data	=	$data->orWhere("CONCAT(first_name,'',last_name) LIKE :query");
			$data	=	$data->setParameter(':query','%'.$app->findatutor->search.'%');
			$data	=	$data->orderBy('first_name','DESC');
			$data	=	$data->execute()->fetchAll();
			
			$app->results = $data;
		
	}