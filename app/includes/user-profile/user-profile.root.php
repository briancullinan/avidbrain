<?php

	//notify($app->target);

	if(DEBUG==false){
		foreach($app->target as $key=> $changeMe){
			$app->target->$key = str_replace('/view-user/','/view-userBak/',$changeMe);
		}
	}

	$usertype = explode('/',$app->request->getPath());
	$usertype=$usertype[1];

	$app->target->action = str_replace('.action','.'.$usertype.'.action',$app->target->action);
	$app->target->include = str_replace('.include','.'.$usertype.'.include',$app->target->include);
	//notify($app->target);

	function mystars($count){
		if(!empty($count)){
			$total = 5;
			$minus = $total - $count;
			if($minus!=0){
				$rangeOne = range(1,$minus);
			}
			$stars = '';
			if(isset($rangeOne)){
				foreach($rangeOne as $brokenStars){
					$stars.=' <i class="fa fa-star-o"></i> ';
				}
			}
			if($minus===0){
				foreach(range(1,5) as $brokenStars){
					$stars.=' <i class="fa fa-star"></i> ';
				}
			}
			else{
				foreach(range(1,$count) as $brokenStars){
					$stars.=' <i class="fa fa-star"></i> ';
				}
			}
			return $stars;
		}
	}

	function getmysubjects($connect,$email){

		$select = "subjects.*";

		$mysubjects = (object)[];
		$sql = "
			SELECT
				$select
			FROM
				avid___user_subjects subjects
			WHERE
				subjects.email = :email
					AND
				subjects.status = 'verified'
					AND
				subjects.description_verified IS NOT NULL

			ORDER BY subjects.sortorder ASC
		";
		$prepare = array(
			':email'=>$email
		);
		$approved = $connect->executeQuery($sql,$prepare)->fetchAll();
		if(!empty($approved)){
			$mysubjects->approved = $approved;
		}

		$sql = "
			SELECT
				$select
			FROM
				avid___user_subjects subjects
			WHERE
				subjects.email = :email
					AND
				subjects.status = 'needs-review'

			ORDER BY subjects.sortorder ASC
		";
		$prepare = array(
			':email'=>$email
		);
		$notApproved = $connect->executeQuery($sql,$prepare)->fetchAll();
		if(!empty($notApproved)){
			$mysubjects->notApproved = $notApproved;
		}
		return $mysubjects;
	}
