<?php

    function linkify_tweet($tweet) {

      //Convert urls to <a> links
      $tweet = preg_replace("/([\w]+\:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/", "<a target=\"_blank\" href=\"$1\">$1</a>", $tweet);

      //Convert hashtags to twitter searches in <a> links
      $tweet = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a target=\"_new\" href=\"http://twitter.com/search?q=$1\">#$1</a>", $tweet);

      //Convert attags to twitter profiles in <a> links
      $tweet = preg_replace("/@([A-Za-z0-9\/\.]*)/", "<a href=\"http://www.twitter.com/$1\">@$1</a>", $tweet);

      return $tweet;

    }

    function page_views($app){

        //return 'GOOGLE NOT WORKING';

        $googleAPIcachename = $app->user->email.'-googleAPI';

        $cacheapianalytics = $app->connect->cache->get($googleAPIcachename);
        if($cacheapianalytics == null) {

            $cacheapianalytics = NULL;

            try{
                $starting = explode(' ',$app->user->signup_date);
                $starting = $starting[0];
                $p12FilePath = APP_PATH.'dependents/google-api.p12';
                $serviceClientId = '572852330695-0hbkh6fr4okvdvqk6tncit8154aqbtne.apps.googleusercontent.com';
                $serviceAccountName = '572852330695-0hbkh6fr4okvdvqk6tncit8154aqbtne@developer.gserviceaccount.com';
                $scopes = array('https://www.googleapis.com/auth/analytics.readonly');
                $googleAssertionCredentials = new Google_Auth_AssertionCredentials($serviceAccountName,$scopes,file_get_contents($p12FilePath));
                $client = new Google_Client();
                $client->setAssertionCredentials($googleAssertionCredentials);
                $client->setClientId($serviceClientId);
                $client->setApplicationName("Project");
                $analytics = new Google_Service_Analytics($client);
                $analyticsViewId    = 'ga:101662413';
                $startDate          = $starting;
                $endDate            = date('Y-m-d');
                $metrics            = 'ga:pageviews';
                $data = $analytics->data_ga->get($analyticsViewId, $startDate, $endDate, $metrics, array(
                    'dimensions'    => 'ga:pagePath',
                    'filters'       => 'ga:pagePath=='.$app->user->url,
                    'sort'          => '-ga:pageviews',
                ));
                $pageviews = $data->totalsForAllResults;
                $returnedData = $pageviews['ga:pageviews'];
                $cacheapianalytics = $returnedData;
                $app->connect->cache->set($googleAPIcachename, $returnedData, 3600);
            }
            catch(Exception $e){
                // Do Nothing
            }


        }

        return $cacheapianalytics;
    }

    function uniquepromocode($connect){
        $random = random_all(8);
        $sql = "SELECT promocode FROM avid___promotions WHERE promocode = :promocode";
        $prepare = array(':promocode'=>$random);
        $results = $connect->executeQuery($sql,$prepare)->rowCount();

        if($results==0){
            return $random;
        }
        else{
            return uniquepromocode($connect);
        }

    }
    function signupcode($connect,$email){

        $promocodevalues = new stdClass();
        $sql = "SELECT * FROM avid___promotions WHERE email = :email";
        $prepare = array(':email'=>$email);
        $results = $connect->executeQuery($sql,$prepare)->fetch();

        if(isset($results->id)){
            $promocodevalues->promocode = $results->promocode;
            $promocodevalues->value = $results->value;
        }
        else{

            $random = uniquepromocode($connect);
            $value = 30;
            $connect->insert('avid___promotions',array('promocode'=>$random,'value'=>$value,'email'=>$email));
            $promocode = $random;
            $promocodevalues->promocode = $random;
            $promocodevalues->value = $value;
        }

        return $promocodevalues;
    }
