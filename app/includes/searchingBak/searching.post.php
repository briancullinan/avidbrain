<?php

    if(isset($app->searching)){

        $string = [];


        if(empty($app->searching->subjectauto) && isset($app->searching->subject)){
            $string['subject'] = $app->searching->subject;
        }
        elseif(isset($app->searching->subjectauto)){
            $string['subject'] = $app->searching->subjectauto;
        }

        if(!empty($app->searching->zipcode)){
            $string['zipcode'] = $app->searching->zipcode;
        }
        else{
            $string['zipcode'] = '---';
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
            $string['page'] = '---';
        }

        $jump = '/searching/'.$string['subject'].'/'.$string['zipcode'].'/'.$string['distance'].'/'.$string['name'].'/'.$string['gender'].'/'.$string['pricelow'].'/'.$string['pricehigh'].'/'.$string['page'].'/'.$string['sort'];
        // urljump+= '/'+subject+'/'+newurl.zipcode+'/'+newurl.distance+'/'+newurl.name+'/'+newurl.gender+'/'+newurl.pricelow+'/'+newurl.pricehigh+'/'+newurl.page+'/'+newurl.sort;

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
