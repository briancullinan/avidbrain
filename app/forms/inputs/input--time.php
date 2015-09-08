<input
	id="<?php echo $this->formname.'_'.$question->name; ?>"
	type="text"
	name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]"
	class="time-picker time ui-timepicker-input validate <?php if(isset($question->required)){ echo '  validate-required ';} ?>"
	<?php if(isset($question->maxlength)){ echo 'maxlength="'.$question->maxlength.'"';} ?>
	value="<?php if(isset($question->value)){ echo $question->value; } ?>"
	data-scroll-default="<?php echo date('g:ia'); ?>"
	autocomplete="off"
/>

<label <?php if(isset($question->value)){ echo ' class="active" '; } ?> for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>