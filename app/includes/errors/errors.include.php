<?php if(isset($_SESSION['slim.flash']['error'])): ?>
    <h1 class="custom-error"><?php echo $_SESSION['slim.flash']['error']; ?></h1>
<?php else: ?>
    <h1>MindSpree Error</h1>
<?php endif; ?>

<p>
    There was an error. Sorry about that, an admistrator has been notified of the issue and will fix the problem as soon as possible.
</p>

<p>Here are some possible temporary fixes: </p>

<ul class="collection">
	<li class="collection-item">
		Clear Your Cache
	</li>
	<li class="collection-item">
		Delete Your Cookies
	</li>
	<li class="collection-item">
		Close Your Browser
	</li>
	<li class="collection-item">
		Open a New Browser
	</li>
	<li class="collection-item">
		If none of this works, please <a href="/help/contact">email support</a>.
	</li>
</ul>
