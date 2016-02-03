<?php

    $allowed = [
        '300x250'=>'medium-rectangle',
        '336x280'=>'large-rectangle',
        '728x90'=>'leaderboard',
        '300x600'=>'half-page',
        '320x100'=>'large-mobile-banner'
    ];

    if(isset($allowed[$download])){
        $type = $allowed[$download];

        $fileName = $type.'-'.$download.'.jpg';
        $filePath = $app->dependents->DOCUMENT_ROOT.'images/download/'.$fileName;
        $fileSize = filesize($filePath);


        // Output headers.
        header("Cache-Control: private");
        header("Content-Type: application/stream");
        header("Content-Length: ".$fileSize);
        header("Content-Disposition: attachment; filename=".$fileName);

        // Output file.
        readfile ($filePath);
        exit();
    }
