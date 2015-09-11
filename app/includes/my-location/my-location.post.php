<?php
	
	$mylocation = makepost(json_decode(json_encode($_POST),FALSE));
	$sessionid = $_COOKIE['PHPSESSID'];
	
	$sessionid_geolocation = $app->connect->cache->get($sessionid);
	if($sessionid_geolocation == null){
		
		$getzipfromGEO = "round(((acos(sin((" . $mylocation->latitude . "*pi()/180)) * sin((zdata.lat*pi()/180))+cos((" . $mylocation->latitude . "*pi()/180)) * cos((zdata.lat*pi()/180)) * cos(((" .$mylocation->longitude. "- zdata.long)* pi()/180))))*180/pi())*60*1.1515)";
		
			$data	=	$app->connect->createQueryBuilder();
			$data	=	$data->select('zdata.*,'.$getzipfromGEO.' as distance')->from('avid___location_data','zdata')->setParameter(':distance',100)->having("distance <= :distance");
			$data	=	$data->orderBy($getzipfromGEO,'ASC');
			$data	=	$data->setMaxResults(1);
			$returnedData	=	$data->execute()->fetch();
			
			if(isset($returnedData->id)){
				$mylocationData = json_encode($returnedData);
				$app->setCookie('mylocation',$mylocationData, '2 days');
			}
			
			
	    $sessionid_geolocation = $returnedData;
	    $app->connect->cache->set($sessionid, $returnedData, 36000);
	}
	unset($sessionid_geolocation->id);
	echo json_encode($sessionid_geolocation);
	exit;