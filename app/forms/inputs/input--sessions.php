<input
	id="<?php echo $this->formname.'_'.$question->name; ?>"
	type="date"
	name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]"
	class="datepicker validate <?php if(isset($question->required)){ echo '  validate-required ';} ?>"
	<?php if(isset($question->maxlength)){ echo 'maxlength="'.$question->maxlength.'"';} ?>
	value="<?php if(isset($question->value)){ echo $question->value; } ?>"
/>
<label <?php if(isset($question->value)){ echo ' class="active" '; } ?> for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>
