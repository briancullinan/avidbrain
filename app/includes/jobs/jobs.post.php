<?php
	
	if(isset($app->user->usertype)){
		
		if(isset($app->contestform) && $app->user->usertype=='student'){
			if(isset($app->contestApplication)){
				notify($app->dependents->SITE_NAME_PROPPER.' - Costest');
			}
			else{
				
				$enterContest = array(
					'email'=>$app->user->email,
					'ipaddress'=>$_SERVER['REMOTE_ADDR'],
					'date'=>thedate(),
					'first_name'=>$app->contestform->first_name,
					'last_name'=>$app->contestform->last_name,
					'address_line1'=>$app->contestform->address_line1,
					'address_line2'=>$app->contestform->address_line2,
					'city'=>$app->contestform->city,
					'state'=>$app->contestform->state,
					'zipcode'=>$app->contestform->zipcode,
					'phone'=>$app->contestform->phone
				);
				
				$app->connect->insert('avid___contest',$enterContest);
				
				new flash(
					array('action'=>'jump-to','location'=>$app->request->getPath(),'message'=>'Contest Application Saved')
				);
				
			}
				
		}
		elseif(isset($app->postjob) && $app->user->usertype=='student'){
			
			
			
			$doesexist = NULL;
			if(isset($app->postjob->subject_slug)){
				$sql = "SELECT id FROM avid___jobs WHERE subject_slug = :subject_slug AND email = :email AND open IS NOT NULL";
				$prepeare = array(':subject_slug'=>$app->postjob->subject_slug,':email'=>$app->user->email);
				$doesexist = $app->connect->executeQuery($sql,$prepeare)->rowCount();
				//notify($doesexist);
			}
			
			if($doesexist!=0){
				new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Duplicate posting for <span>'.$app->postjob->subject_name.'</span>'));
			}
			
			if(empty($app->postjob->subject_name)){
				new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Subject Required <i class="fa fa-warning"></i>'));
			}
			elseif(empty($app->postjob->job_description)){
				new Flash(array('action'=>'required','formID'=>'findasubject','message'=>'Job Description Required <i class="fa fa-warning"></i>'));
			}
			
			if(strlen($app->postjob->job_description)>1000){
				new Flash(array('action'=>'required','formID'=>'sessionreviews','message'=>'<span>1,000</span> Characters Maximum '.strlen($app->postjob->job_description).'/1,000'));
			}
			
			if(empty($app->postjob->parent_slug)){
				$app->postjob->parent_slug = NULL;
			}
			if(empty($app->postjob->subject_slug)){
				$app->postjob->subject_slug = NULL;
			}
			if(empty($app->postjob->type)){
				$app->postjob->type = NULL;
			}
			if(empty($app->postjob->skill_level)){
				$app->postjob->skill_level = NULL;
			}
			if(empty($app->postjob->id)){
				$app->postjob->id = NULL;
			}
			
			$newjob = array(
				'email'=>$app->user->email,
				'subject_name'=>$app->postjob->subject_name,
				'subject_slug'=>$app->postjob->subject_slug,
				'parent_slug'=>$app->postjob->parent_slug,
				'subject_id'=>$app->postjob->id,
				'date'=>thedate(),
				'job_description'=>$app->postjob->job_description,
				'type'=>$app->postjob->type,
				'skill_level'=>$app->postjob->skill_level,
				'open'=>1
			);
			
			$app->connect->insert('avid___jobs',$newjob);
			$jobid = $app->connect->lastInsertId();
			
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('user.email, user.first_name, user.last_name')->from('avid___user','user');
			$data	=	$data->where('user.usertype = :usertype')->setParameter(':usertype','tutor');
			$data	=	$data->innerJoin('user','avid___user_subjects','subjects','user.email = subjects.email');
			$data	=	$data->innerJoin('user','avid___user_account_settings','settings','user.email = settings.email');
			$data	=	$data->andWhere('settings.newjobs = "yes"');
			$data	=	$data->andWhere('subjects.subject_slug = :subject_slug');
			$data	=	$data->setParameter(':subject_slug',$app->postjob->subject_slug);
			$data	=	$data->andWhere('subjects.parent_slug = :parent_slug');
			$data	=	$data->setParameter(':parent_slug',$app->postjob->parent_slug);
			$data	=	$data->execute()->fetchAll();
			
			
			if(isset($data[0]) && $app->dependents->SERVER_NAME!='amozek.dev'){
				
				//notify('ZERO XOOL');
				
				$subject = 'A student has posted a new job';
				$message = '<br><h2>'.$app->postjob->subject_name.' Student</h2>';
				
				$message.= '<p><strong>Location:</strong>   '.$app->user->city.', '.$app->user->state.'</p>';
				$message.= '<p><strong>Job Description:</strong> <br> '.$app->postjob->job_description.'</p>';
				$message.= '<p><strong>Date Posted:</strong> '.formatdate(thedate(), 'M. jS, Y @ g:i a').'</p>';
				$message.= '<p><strong>My Skill Level:</strong> '.$app->postjob->skill_level.'</p>';
				$message.= '<p><strong>Tutoring Type:</strong> '.online_tutor($app->postjob->type).'</p>';
				$message.= '<p><a href="'.$app->dependents->DOMAIN.'/jobs/apply/'.$jobid.'">View Job Posting</a></p>';
				
				
				foreach($data as $sendEmail){
					$app->mailgun->to = $sendEmail->email;
					$app->mailgun->subject = $subject;
					$app->mailgun->message = $message;
					$app->mailgun->send();
				}
			}
			
			new Flash(array('action'=>'jump-to','location'=>'/jobs/manage/'.$jobid.'','message'=>'Job Posted'));
			
		}
		else{
			//notify($app->keyname);
		}
		
		
	}
	
	$jsonSearch = json_encode($app->searchingforjobs);
	$app->setCookie('searchingforjobs',$jsonSearch, '2 days');
	if(isset($app->searchingforjobs) && !empty($app->searchingforjobs)){
		foreach($app->searchingforjobs as $key=> $unset){
			if(empty($unset)){
				unset($app->searchingforjobs->$key);
			}
		}
	}
	
	
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('jobs.*,'.everything())->from('avid___jobs','jobs');
			$data	=	$data->where('jobs.open IS NOT NULL AND user.status IS NULL');
			if(isset($app->searchingforjobs->search)){
				$data	=	$data->andWhere('jobs.subject_name LIKE :subject_name')->setParameter(':subject_name',"%".$app->searchingforjobs->search."%");
				$data	=	$data->orWhere('jobs.parent_slug LIKE :subject_name AND jobs.open IS NOT NULL AND user.status IS NULL');
			}
			$data	=	$data->innerJoin('jobs', 'avid___user', 'user', 'user.email = jobs.email');
			$data	=	$data->innerJoin('jobs', 'avid___user_profile', 'profile', 'profile.email = jobs.email');
			
				if(isset($app->searchingforjobs->zipcode)){
				if(isset($app->searchingforjobs->zipcode)){
					$zipcodedata = get_zipcode_data($app->connect,$app->searchingforjobs->zipcode);
					
					if(empty($app->searchingforjobs->distance)){
						$app->searchingforjobs->distance = 15;
					}
					
					if(empty($zipcodedata)){
						new Flash(
							array('action'=>'alert','message'=>'Invalid Zip Code')
						);
					}
					else{
						if(isset($zipcodedata->lat)){
							$getDistance = "
								round(((acos(sin((" . $zipcodedata->lat . "*pi()/180)) * sin((user.lat*pi()/180))+cos((" . $zipcodedata->lat . "*pi()/180)) * cos((user.lat*pi()/180)) * cos(((" .$zipcodedata->long. "- user.long)* pi()/180))))*180/pi())*60*1.1515) 
							";
							
							$app->getDistance = true;
							
							$asDistance = ' as distance ';
							$data	=	$data->addSelect($getDistance.$asDistance)->setParameter(':distance',$app->searchingforjobs->distance)->having("distance <= :distance");
						}
					}
				}
			}
			
			$data	=	$data->innerJoin('jobs','avid___user_account_settings','settings','settings.email = jobs.email');
			//$data	=	$data->groupBy('jobs.email');
			
			if(isset($getDistance)){
				$data	=	$data->orderBy('distance','ASC');
			}
			else{
				$data	=	$data->orderBy('date','DESC');
			}
			
			$offsets = new offsets((isset($number) ? $number : NULL),$app->dependents->pagination->items_per_page);
			$count = $data->execute()->rowCount();
			$alljobs = $data->setMaxResults($offsets->perpage)->setFirstResult($offsets->offsetStart)->execute()->fetchAll();
			$pagify = new Pagify();
			$config = array(
				'total'    => $count,
				'url'      => $app->target->pagebase,
				'page'     => $offsets->number,
				'per_page' => $offsets->perpage
			);
			$pagify->initialize($config);
			$app->pagination = $pagify->get_links();
			
			$data	=	$data->execute()->fetchAll();
			
			//notify($data);
			
			if($count>0){
				$app->alljobs = $data;
			}
			$name = NULL;
			if(isset($app->searchingforjobs->search)){
				$name = ucwords($app->searchingforjobs->search);
			}
			
			
			if(isset($app->user->usertype) && $app->user->usertype=='student'){
				$app->meta = new stdClass();
				$app->meta->title = 'Post a Tutoring Job';
				$app->meta->h1 = 'Post a Tutoring Job';
			}
			else{
				$app->meta = new stdClass();
				$app->meta->title = $count.' '.$name.'  Tutoring Jobs';
				$app->meta->h1 = '<span>'.$count.'</span> '.$name.' Tutoring Jobs';
			}