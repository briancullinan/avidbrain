<?php if(isset($question->extra)){ echo $question->extra; } ?>

<input type="hidden" class="anything" name="<?php echo $this->formname; ?>[<?php echo $question->name; ?>]" value="<?php if(isset($question->value)){ echo $question->value; } ?>" />
