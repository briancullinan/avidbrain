<?php

    $map = [
        0=>'subject',
        1=>'location',
        2=>'distance',
        3=>'name',
        4=>'gender',
        5=>'pricelow',
        6=>'pricehigh'
    ];

    if(!empty($query)){
        foreach($query as $key=> $assignMap){
            if(strpos($assignMap, "(") !== false || strpos($assignMap, ")") !== false) {
                $sort = str_replace(array('(',')'),'',$assignMap);
            }
            elseif(strpos($assignMap, "[") !== false || strpos($assignMap, "]") !== false) {
                $page = str_replace(array('[',']'),'',$assignMap);
            }
            elseif(!empty($assignMap) && $assignMap!='---'){
                $$map[$key] = $assignMap;
            }
        }
    }

    if(empty($sort)){
        $sort = 'lastactive';
    }
    if(empty($page)){
        $page = 1;
    }

    if(isset($subject)){
        printer($subject);
    }
    if(isset($location)){
        printer($location);
    }
    if(isset($distance)){
        printer($distance);
    }
    if(isset($name)){
        printer($name);
    }
    if(isset($gender)){
        printer($gender);
    }
    if(isset($pricelow)){
        printer($pricelow);
    }
    if(isset($pricehigh)){
        printer($pricehigh);
    }
    if(isset($sort)){
        printer($sort);
    }
    if(isset($page)){
        printer($page);
    }
    exit;
