<?php


    //

    //

    //

    //

    //
    //
    // if(isset($action)){
    //
    //     $file = APP_PATH.'uploads/resumes/'.$app->thetutor->my_resume;
    //     header('Content-type:'. mime_content_type($file));
    //     header('Content-Disposition: inline; filename="thefile.'.getfiletype($file).'"');
    //     @readfile($file);
    //     exit;
    // }

    function subinfo($connect,$id){
        $sql = "SELECT * FROM avid___available_subjects WHERE id = :id";
        $prepare = array(':id'=>$id);
        return $connect->executeQuery($sql,$prepare)->fetch();
    }

    if(isset($id)){
        $sql = "SELECT temps.*,user.url,comp.id as comper FROM avid___new_temps temps

        LEFT JOIN

        avid___user user on user.email = temps.email

        LEFT JOIN

        avid___compedbgcheck comp on comp.email = temps.email

        WHERE temps.id = :id ";



        $prepare = array(':id'=>$id);
        $app->thetutor = $app->connect->executeQuery($sql,$prepare)->fetch();
    }

    if(isset($action)){

        if($action=='haventfinished'){
            $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NULL ORDER BY ID DESC ";
            $prepare = array();
            $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            if(isset($results[0])){
                $app->haventfinished = $results;
            }
        }
        elseif($action=='newtutors'){
            $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NOT NULL AND  activated IS NULL AND approval_status IS NULL  ORDER BY ID DESC ";
            $prepare = array();
            $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            if(isset($results[0])){
                $app->newtutors = $results;
            }
        }
        elseif($action=='rejectedtutors'){
            $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE complete IS NOT NULL AND  activated IS NULL AND approval_status = 'rejected'  ORDER BY ID DESC ";
            $prepare = array();
            $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            if(isset($results[0])){
                $app->rejectedtutors = $results;
            }
        }
        elseif($action=='approvedtutors'){
            $sql = "SELECT first_name,last_name,email,id FROM avid___new_temps WHERE  approval_status = 'approved'  ORDER BY ID DESC ";
            $prepare = array();
            $results = $app->connect->executeQuery($sql,$prepare)->fetchAll();
            if(isset($results[0])){
                $app->approvedtutors = $results;
            }
        }

    }
