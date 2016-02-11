<code>

	mkdir <?php echo APP_PATH.'includes'.$app->target->key; ?> <br>
	touch <?php echo $app->target->action; ?><br>
	touch <?php echo $app->target->post; ?><br>
	touch <?php echo $app->target->include; ?><br><br>

	echo "&lt;?php // Empty Action" >> <?php echo $app->target->action; ?><br>
	echo "&lt;?php notify(\$app->keyname); ?&gt;" >> <?php echo $app->target->post; ?><br>
	echo "<h1><?php echo $app->request->getPath(); ?></h1>" >> <?php echo $app->target->include; ?><br>

</code>
