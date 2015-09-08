<?php
	if(isset($question->extra)){
		$options = json_decode($question->extra);
	}
?>
<?php if(isset($options)): ?>
<label class="select-label" for="<?php echo $this->formname.'_'.$question->name; ?>"><?php echo $question->text; ?> <?php if(isset($question->required)){ echo '<span class="required">*</span>';} ?></label>
<select id="<?php echo $this->formname.'_'.$question->name; ?>" name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]" class="validate <?php if(isset($question->required)){ echo '  validate-required ';} ?> browser-default">
	<?php foreach($options as $key=> $value): ?>
		<option <?php if(isset($question->value) && $question->value==$value){echo 'selected="selected"';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
	<?php endforeach; ?>
</select>
<?php endif; ?>