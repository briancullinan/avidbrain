<input
	id="<?php echo $this->formname.'_'.$question->name; ?>"
	type="hidden"
	name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]"
	class="the-star-score"
	<?php if(isset($question->maxlength)){ echo 'maxlength="'.$question->maxlength.'"';} ?>
	value="<?php if(isset($question->value)){ echo $question->value; } ?>"
/>
<div class="star-ranks-text"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></div>

<div class="star-ranks">
	
	<?php foreach(range(1,5) as $key=> $stars): ?>
		<i data-value="<?php echo ($key+1); ?>" class="fa fa-star-o star-<?php echo $key; ?>"></i>
	<?php endforeach; ?>
	
</div>