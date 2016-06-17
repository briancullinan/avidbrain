<?php

	function applicantcount($count){
		if(isset($count)){
			if($count==0){
				return '';
			}
			elseif($count>0 && $count<10){
				return 'blue';
			}
			elseif($count>10){
				return 'red';
			}
		}
		else{
			return 'grey';
		}
	}

	//
	$app->secondary = $app->target->secondary;
	if(isset($app->user->usertype) && $app->user->usertype=='student'){
		//unset($app->secondary);
		$app->jobinclude = APP_PATH.'includes/jobs/action.student';
	}
	else{
		$app->jobinclude = APP_PATH.'includes/jobs/action.everyone';
	}
