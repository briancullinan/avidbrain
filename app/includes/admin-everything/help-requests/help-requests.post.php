<?php
	if(isset($app->helprequests)){
		
		if($app->helprequests->status=='markread'){
			
			$update = array('`replied_from`'=>$app->user->email,'`read`'=>1);
			$where = array('id'=>(int)$app->helprequests->id);
			$app->connect->update('avid___help_contactus',$update,$where);
			
			$app->redirect('/admin-everything/help-requests');
			
		}
		elseif($app->helprequests->status=='closehelp'){
			
			$where = array('id'=>(int)$app->helprequests->id);
			$app->connect->delete('avid___help_contactus',$where);
			
			$app->redirect('/admin-everything/help-requests');
			
		}
	}
