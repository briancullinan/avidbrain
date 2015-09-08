<p>Oh, it looks like you found one of our missing pages. Here is a picture of a cat. </p>

<?php
	$kitties = array(
		'http://avidbrane.com/images/kitty.gif',
		'http://avidbrane.com/images/kitty2.gif'
	);
	shuffle($kitties);
	$kitties = $kitties[0];
?>

<img class="responsive-img" src="<?php echo $kitties; ?>" />


<?php
	/*
		<video autoplay loop poster="placeholder.jpg" id="backgroundgif">
			<source src="http://i.imgur.com/wusYXgK.webm" type="video/webm">
		</video>
	*/
?>