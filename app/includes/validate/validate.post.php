<?php
    if(isset($app->finisheasy) && isset($app->easysignup)){

        $zipData = get_zipcode_data($app->connect,$app->finisheasy->zipcode);
        if(isset($zipData->id)){
            $update = array(
                'first_name'=>$app->finisheasy->first_name,
                'last_name'=>$app->finisheasy->last_name,
                'zipcode'=>$app->finisheasy->zipcode,
                'phone'=>$app->finisheasy->phone,
                'promocode'=>'easy-signup-complete',
                'city'=>$zipData->city,
                'state'=>$zipData->state,
                'state_long'=>$zipData->state_long,
                '`lat`'=>$zipData->lat,
                '`long`'=>$zipData->long
            );

            $app->connect->update('avid___users_temp',$update,array('id'=>$app->easysignup->id));

            $app->redirect('/validate/'.$code);

        }

    }
