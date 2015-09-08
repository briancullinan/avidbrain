<input
	id="<?php echo $this->formname.'_'.$question->name; ?>"
	type="password"
	name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]"
	class="validate <?php if(isset($question->required)){ echo '  validate-required ';} ?>"
	<?php if(isset($question->maxlength)){ echo 'maxlength="'.$question->maxlength.'"';} ?>
/>
<label for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>
