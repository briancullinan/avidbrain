<?php

    $sql = "
        SELECT
            spam.id as spam_id,
            spam.who_flagged as spam_who_flagged,
            spam.date as spam_date,
            messages.id,
            messages.subject,
            messages.message,
            messages.send_date,
            messages.from_user,
            messages.to_user
        FROM
            avid___messages_spam spam

        INNER JOIN

            avid___messages messages
                on messages.id = spam.message_id


        WHERE
            spam.resolved IS NULL

        GROUP BY spam.id
    ";
    $prepare = array();
    $spammessages = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    if(isset($spammessages[0])){
        $app->spammessages = $spammessages;
    }


    $app->meta = new stdClass();
    $app->meta->title = 'Spam Messages';
