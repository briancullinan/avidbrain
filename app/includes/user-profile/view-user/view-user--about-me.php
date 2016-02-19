<?php if(isset($app->adminnow)): ?>
    <div class="row">
    	<div class="col s12 m6 l6">
            <h4>Non-Verified</h4>
            <div class="aboutme">
                <textarea class="materialize-textarea"><?php echo $app->actualuser->personal_statement; ?></textarea>
            </div>
    	</div>
    	<div class="col s12 m6 l6">
            <h4>Verified</h4>
            <div class="aboutme">
                <?php echo nl2br($app->actualuser->personal_statement_verified); ?>
            </div>
    	</div>
    </div>
<?php else: ?>
    <div class="aboutme">
        <?php if(isset($app->actualuser->statementflag)){ echo ' <span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-warning yellow-text fa-stack-1x fa-inverse tooltipped" data-position="top" data-delay="50" data-tooltip="Needs Verified"></i></span> ';} ?><?php echo nl2br($app->actualuser->statement); ?>
    </div>
<?php endif; ?>
