<p>Oh, it looks like you found one of our missing pages. Here is a picture of a cat. </p>

<?php
	$kitties = array(
		'http://avidbrane.com/images/kitty.gif',
		'http://avidbrane.com/images/kitty2.gif'
	);
	shuffle($kitties);
	$kitties = $kitties[0];
?>

<a href="/"><img class="responsive-img" src="<?php echo $kitties; ?>" /></a>