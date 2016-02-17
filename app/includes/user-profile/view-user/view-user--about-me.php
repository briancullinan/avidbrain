<div class="aboutme">
    <?php if(isset($app->actualuser->statementflag)){ echo ' <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-warning yellow-text fa-stack-1x fa-inverse tooltipped" data-position="top" data-delay="50" data-tooltip="Needs Verified"></i></span> ';} ?><?php echo nl2br($app->actualuser->statement); ?>
</div>
