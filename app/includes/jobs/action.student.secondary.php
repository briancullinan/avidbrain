<?php

    $pages = array();
    $pages['My Jobs'] = '/jobs';

?>

<div class="block">
    <?php foreach($pages as $key => $page): ?>
        <a href="<?php echo $page; ?>">
            <?php echo $key; ?>
        </a>
    <?php endforeach; ?>
</div>
