<?php

	$app->historyOptions = array(
		'tutor' => array(
			'/payment/history/my-payments'=>'My Payments',
			'/payment/history/session-history'=>'Session History'
		),
		'student' => array(
			'/payment/history/session-history'=>'Session History'
		)
	);

	if(isset($action)){

		if($app->user->usertype=='tutor'){
			if($action=='my-payments'){
				$data	=	$app->connect->createQueryBuilder();
				$data	=	$data->select('payments.*')->from('avid___user_payments','payments');
				$data	=	$data->where('payments.type = "Bi Monthly Tutor Payment" AND payments.email = :myemail')->setParameter(':myemail',$app->user->email);
				$data	=	$data->orderBy('payments.date','DESC');

				$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
				$count	=	$data->execute()->rowCount();
				$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);

				$history	=	$data->execute()->fetchAll();
				$app->history = $history;


				$app->meta = new stdClass();
				$app->meta->title = 'My Payments';
			}
			elseif($action=='session-history'){
				$data	=	$app->connect->createQueryBuilder();
				$data	=	$data->select('sessions.payrate,sessions.taxes,sessions.session_subject,sessions.session_cost,payments.*, user.first_name,user.last_name,user.url')->from('avid___user_payments','payments');
				$data	=	$data->where('payments.recipient = :myemail AND payments.type != "Bi Monthly Tutor Payment"')->setParameter(':myemail',$app->user->email);
				$data	=	$data->innerJoin('payments','avid___user','user','user.email = payments.email');
				$data	=	$data->innerJoin('payments','avid___sessions','sessions','sessions.id = payments.session_id');
				$data	=	$data->orderBy('payments.date','DESC');

				$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
				$count	=	$data->execute()->rowCount();
				$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);

				$history	=	$data->execute()->fetchAll();
				$app->history = $history;

				$pagify = new Pagify();
				$config = array(
					'total'    => $count,
					'url'      => '/payment/history/session-history/page/',
					'page'     => $offsets->number,
					'per_page' => $offsets->perpage
				);
				$pagify->initialize($config);
				$app->pagination = $pagify->get_links();

				$app->meta = new stdClass();
				$app->meta->title = 'Session History';

			}
		}
		elseif($app->user->usertype=='student'){

			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('sessions.payrate,sessions.taxes,sessions.session_subject,sessions.session_cost,payments.*, user.first_name,user.last_name,user.url')->from('avid___user_payments','payments');
			$data	=	$data->where('payments.email = :myemail')->setParameter(':myemail',$app->user->email);
			$data	=	$data->innerJoin('payments','avid___user','user','user.email = payments.recipient');
			$data	=	$data->innerJoin('payments','avid___sessions','sessions','sessions.id = payments.session_id');
			$data	=	$data->orderBy('payments.date','DESC');

			$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
			$count	=	$data->execute()->rowCount();
			$data	=	$data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart);

			$history	=	$data->execute()->fetchAll();
			$app->history = $history;

			$pagify = new Pagify();
			$config = array(
				'total'    => $count,
				'url'      => '/payment/history/session-history/page/',
				'page'     => $offsets->number,
				'per_page' => $offsets->perpage
			);
			$pagify->initialize($config);
			$app->pagination = $pagify->get_links();

			$app->meta = new stdClass();
			$app->meta->title = 'Session History';

			//notify($app->history);

		}


	}
	else{
		$app->meta = new stdClass();
		$app->meta->title = 'Payment History';
	}
