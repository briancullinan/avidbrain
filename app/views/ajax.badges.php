<?php

    function cachedeals($cacheKey,$cacheLength,$connect,$sql,$preparedArray,$type){
        $cachedVar = $connect->cache->get($cacheKey);
                
        if($cachedVar == null) {
            if(isset($type) && $type=='fetch'){
                $cachedVar = $connect->executeQuery($sql,$preparedArray)->fetch();
            }
            elseif(isset($type) && $type=='fetchAll'){
                $cachedVar = $connect->executeQuery($sql,$preparedArray)->fetchAll();
            }

            $connect->cache->set($cacheKey, $cachedVar, $cacheLength);
        }
        
        return $cachedVar;
    }

    
    $return = array();

    if(isset($app->url)){

        $cacheKey = 'cached-url-string---'.str_replace('/','-',$app->url);
        $sql = "SELECT email FROM avid___user user WHERE user.url = :url AND user.usertype = :usertype ";
        $preparedArray = array(':url'=>$app->url,':usertype'=>'tutor');
        $emailFromUrl = cachedeals($cacheKey,3600,$app->connect,$sql,$preparedArray,'fetch');

        if(isset($emailFromUrl->email)){
            $email = $emailFromUrl->email;
            

            $cacheKey = 'cacheditemfromemail---badge(sum)---'.$email;
            $sql = "SELECT floor((sum(sessions.session_length)/60)) as sum FROM avid___sessions sessions WHERE sessions.from_user = :email AND sessions.session_length IS NOT NULL";
            $preparedArray = array(':email'=>$email);
            $sum = cachedeals($cacheKey,3600,$app->connect,$sql,$preparedArray,'fetch');
            

            if(empty($sum->sum)){
                $sum->sum = 0;
            }

            if(isset($sum->sum) && !empty($sum->sum)){
                $return['hourstutors'] = batter_badges('hours-tutors','mdi-action-alarm',$sum->sum.'+ Hours Tutored');
            }

            $badge_type = badge_type($sum->sum,1);
            $return['tutorrank'] = batter_badges('tutor-rank '.$badge_type->class,$badge_type->icon,$badge_type->rank);

            

            $cacheKey = 'cacheditemfromemail---badge(count)---'.$email;
            $sql = "SELECT count(sessions.review_score) as count FROM avid___sessions sessions WHERE sessions.from_user = :email AND sessions.review_score IS NOT NULL ";
            $prepare = array(':email'=>$email);
            $count = cachedeals($cacheKey,3600,$app->connect,$sql,$preparedArray,'fetch');
            

            if(isset($count->count) && !empty($count->count)){
                $plural=NULL;
                if($count->count!=1){
                    $plural = 's';
                }
                $return['totalreviews'] = batter_badges('total-reviews','mdi-action-speaker-notes',$count->count.' Review'.$plural);
            }

            $cacheKey = 'cacheditemfromemail---badge(student_count)---'.$email;
            $sql = "SELECT count(sessions.to_user) as student_count FROM avid___sessions sessions WHERE sessions.from_user = :email GROUP BY sessions.to_user";
            $prepare = array(':email'=>$email);
            $student_count = cachedeals($cacheKey,3600,$app->connect,$sql,$preparedArray,'fetch');
            
            if(isset($student_count->student_count) && !empty($student_count->student_count)){
                $plural=NULL;
                if($student_count->student_count!=1){
                    $plural = 's';
                }
                $return['totalstudents'] = batter_badges('total-students','fa fa-user',$student_count->student_count.' Student'.$plural);
            }

            notify($return);
        }

    }
