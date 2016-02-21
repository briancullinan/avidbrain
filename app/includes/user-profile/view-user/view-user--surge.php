<h3>
    Surge!
</h3>


<?php

    $deals = [];
    $deals[] = (object)[
        'question'=>'I need help with math',
        'answer'=>'15 + 15 = 30'
    ];
    $deals[] = (object)[
        'question'=>'I am having a hard time Sciencing, can you help me?',
        'answer'=>'Sure. Science[nb 1] is a systematic enterprise that creates, builds and organizes knowledge in the form of testable explanations and predictions about the universe.[nb 2][2]:58'
    ];
    $deals[] = (object)[
        'question'=>'Would you please take my test for me?',
        'answer'=>'Nope, that\'s quite out of character for me.'
    ];

    echo itemblocks($deals);

?>
