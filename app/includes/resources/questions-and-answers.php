<h1>Questions & Answers</h1>
	
<?php if($app->user->usertype=='tutor'): ?>
<p>Want to answer some student questions? Come on over to <?php echo $app->dependents->SITE_NAME_PROPPER; ?> Q&A</p>
<?php elseif($app->user->usertype=='student'): ?>
<p>Need an answer to a questions, come on over to <?php echo $app->dependents->SITE_NAME_PROPPER; ?> Q&A</p>
<?php endif; ?>


<?php if(empty($app->user->status)): ?>

<a href="/qa-login" class="btn "><?php echo $app->dependents->SITE_NAME_PROPPER; ?> Q&A</a>
<?php else: ?>
	<p>Before you can participate in Q&A you must have an approved profile.</p>
	<a href="/request-profile-review" class="btn red">Request Profile Review</a>
<?php endif; ?>