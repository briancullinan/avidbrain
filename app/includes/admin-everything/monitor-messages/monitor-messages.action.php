<?php
	$data	=	$app->connect->createQueryBuilder();
	$data	=	$data->select('messages.id')->from('avid___messages','messages');
	$data	=	$data->orderBy('id','DESC');
	$count	=	$data->execute()->rowCount();
	$offsets = new offsets((isset($number) ? $number : NULL),PERPAGE);
	$count	=	$data->execute()->rowCount();
	$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);
	$data	=	$data->addSelect('messages.*');
	$data	=	$data->execute()->fetchAll();
	
	$app->allmessages = $data;
	
	$pagify = new Pagify();
	$config = array(
		'total'    => $count,
		'url'      => '/admin-everything/monitor-messages/page/',
		'page'     => $offsets->number,
		'per_page' => $offsets->perpage
	);
	$pagify->initialize($config);
	$app->pagination = $pagify->get_links();
