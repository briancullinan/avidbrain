<h3>
    Resources
</h3>


<?php

    $deals = [];
    $deals[] = (object)[
        'question'=>'How to pass your SAT',
        'answer'=>'<a href="#download"> <i class="fa fa-download"></i> Download Book</a>'
    ];
    $deals[] = (object)[
        'question'=>'Caclulus Answer Book',
        'answer'=>'<a href="#download"> <i class="fa fa-book"></i> View Book</a>'
    ];

    echo itemblocks($deals);

?>
