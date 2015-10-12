<?php

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('review.email,review.type, CONCAT(user.first_name," ",user.last_name) as name, user.url')->from('avid___user_needsprofilereview','review');
	$data	=	$data->where('review.usertype = :usertype AND user.url IS NOT NULL AND user.status IS NOT NULL')->setParameter(':usertype','tutor');
	$data	=	$data->innerJoin('review','avid___user','user','review.email = user.email');
	$data	=	$data->orderBy('review.id','DESC');
	$data	=	$data->groupBy('review.email');
	$data	=	$data->execute()->fetchAll();
	$app->tutorrequests = $data;

	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('review.email,review.type, CONCAT(user.first_name," ",user.last_name) as name, user.url')->from('avid___user_needsprofilereview','review');
	$data	=	$data->where('review.usertype = :usertype AND user.url IS NOT NULL AND user.status IS NOT NULL')->setParameter(':usertype','student');
	$data	=	$data->innerJoin('review','avid___user','user','review.email = user.email');
	$data	=	$data->orderBy('review.id','DESC');
	$data	=	$data->groupBy('review.email');
	$data	=	$data->execute()->fetchAll();
	$app->studentrequests = $data;
