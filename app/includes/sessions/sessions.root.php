<?php
	
	function calculate_payrate($connect,$sessioninfo,$userinfo){
		
		if(isset($sessioninfo->promocode) && $sessioninfo->promocode==$userinfo->email){
			return 95;
		}
		elseif(isset($userinfo->top1000)){
			return 80;
		}
		else{
			
			$final = 70;
			$rateTable = array(
				70=>range(0,50),
				75=>range(51,200),
				80=>range(201,1000),
				85=>range(1001,2000),
				90=>range(2001,9000),
				95=>range(9001,99999)
			);
			
			$sql = "SELECT
					sum(session_length) as total
				FROM
					avid___sessions
				WHERE
					from_user = :from_user
						AND
					session_length IS NOT NULL
			";
			$prepare = array(':from_user'=>$userinfo->email);
			$totalMinutes = $connect->executeQuery($sql,$prepare)->fetch();
			$totalHours = floor($totalMinutes->total / 60);
			
			foreach($rateTable as $key =>$rate){
				if(in_array($totalHours, $rate)){
					$final = $key;
					break;
				}
			}
			return $final;
			
		}
		
	}
	
	if(isset($id)){
		$app->path = str_replace($id,'',$app->request->getPath());
	}
	
	if($app->target->key!='/sessions/disputed'){
		$app->target->include = $app->target->user->include;
		$app->target->post = $app->target->user->post;
		//$app->target->actions = $app->target->user->action;	
	}
	
	
	$sql = "SELECT id FROM avid___sessions WHERE dispute IS NOT NULL AND from_user = :email OR dispute IS NOT NULL AND to_user = :email";
	$prepeare = array(':email'=>$app->user->email);
	$dispute = $app->connect->executeQuery($sql,$prepeare)->rowCount();
	
	$childen = array();
	if($app->user->usertype=='tutor'){
		$childen['/sessions/setup-new/'] = (object) array('name'=>'Setup Session','slug'=>'/sessions/setup-new');
		$childen['/sessions/jobs/'] = (object) array('name'=>'Job Sessions','slug'=>'/sessions/jobs');
	}
	elseif($app->user->usertype=='student'){
		$childen['/jobs'] = (object) array('name'=>'Request Tutoring Session','slug'=>'/jobs');
	}
	$childen['/sessions/pending/'] = (object) array('name'=>'Pending','slug'=>'/sessions/pending');
	$childen['/sessions/completed/'] = (object) array('name'=>'Completed','slug'=>'/sessions/completed');
	$childen['/sessions/canceled/'] = (object) array('name'=>'Canceled','slug'=>'/sessions/canceled');
	if($app->path=='/sessions/setup/'){
		$childen['/sessions/setup/'] = (object) array('name'=>'Modify Session','slug'=>'/sessions/setup/'.$id);
	}
	if($app->path=='/sessions/view/'){
		$childen['/sessions/view/'] = (object) array('name'=>'View Session','slug'=>'/sessions/view/'.$id);
	}
	if($dispute>0){	
		$childen['/sessions/disputed/'] = (object) array('name'=>'Disputed','slug'=>'/sessions/disputed');
	}
	
	$app->childen = $childen;
	$navtitle = (object)array('slug'=>'/sessions','text'=>'Sessions');
	$app->navtitle = $navtitle;
	
	$app->secondary = $app->target->secondaryNav;