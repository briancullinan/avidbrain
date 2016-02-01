<?php

    if(isset($app->searching)){

        //notify($app->searching);

        $string = [];

        if(isset($app->searching->subject)){
            $app->searching->subject = str_replace('/','-',$app->searching->subject);
        }


        if(empty($app->searching->subjectauto) && !empty($app->searching->subject)){
            $string['subject'] = $app->searching->subject;
        }
        elseif(!empty($app->searching->subjectauto)){
            $string['subject'] = $app->searching->subjectauto;
        }
        elseif(!empty($app->searching->subjectauto) && empty($app->searching->subject)){
            $string['subject'] = '---';
        }
        else{
            $string['subject'] = '---';
        }

        if(!empty($app->searching->zipcodeactual)){
            $string['location'] = $app->searching->zipcodeactual;
            $app->setCookie('getzipcode',$app->searching->zipcodeactual, '2 days');
        }
        elseif(!empty($app->searching->location)){
            $string['location'] = $app->searching->location;
            $app->setCookie('getzipcode',$app->searching->location, '2 days');
        }
        else{
            $string['location'] = '---';
        }

        if(!empty($app->searching->distance)){
            $string['distance'] = $app->searching->distance;
        }
        else{
            $string['distance'] = '---';
        }

        if(!empty($app->searching->name)){
            $string['name'] = $app->searching->name;
        }
        else{
            $string['name'] = '---';
        }

        if(!empty($app->searching->gender)){
            $string['gender'] = $app->searching->gender;
        }
        else{
            $string['gender'] = '---';
        }

        if(!empty($app->searching->pricelow)){
            $string['pricelow'] = $app->searching->pricelow;
        }
        else{
            $string['pricelow'] = '0';
        }

        if(!empty($app->searching->pricehigh)){
            $string['pricehigh'] = $app->searching->pricehigh;
        }
        else{
            $string['pricehigh'] = '---';
        }

        if(!empty($app->searching->sort)){
            $string['sort'] = '('.$app->searching->sort.')';
        }
        else{
            $string['sort'] = '---';
        }

        if(!empty($app->searching->page)){
            $string['page'] = '['.$app->searching->page.']';
        }
        else{
            $string['page'] = '[1]';
        }

        $jump = '/searching/'.$string['subject'].'/'.$string['location'].'/'.$string['distance'].'/'.$string['name'].'/'.$string['gender'].'/'.$string['pricelow'].'/'.$string['pricehigh'].'/'.$string['sort'].'/'.$string['page'];
        // urljump+= '/'+subject+'/'+newurl.location+'/'+newurl.distance+'/'+newurl.name+'/'+newurl.gender+'/'+newurl.pricelow+'/'+newurl.pricehigh+'/'+newurl.page+'/'+newurl.sort;

        //notify($jump);

        if($app->request->isAjax()){
            new Flash(
            	array(
            		'action'=>'jump-to',
            		'message'=>'Searching <i class="fa fa-spinner fa-spin"></i>',
            		'location'=>$jump
            	)
            );
        }
        else{
            $app->redirect($jump);
        }

    }
