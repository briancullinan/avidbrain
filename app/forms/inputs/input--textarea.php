<div class="textearea-fix">
	<textarea
		id="<?php echo $this->formname.'_'.$question->name; ?>"
		name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]"
		class="validate <?php if(isset($question->required)){ echo '  validate-required ';} ?> materialize-textarea"
		<?php if(isset($question->maxlength)){ echo 'maxlength="'.$question->maxlength.'"';} ?>
	><?php if(isset($question->value)){ echo $question->value; } ?></textarea>
	<label <?php if(isset($question->value)){ echo ' class="active" '; } ?> for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>
</div>