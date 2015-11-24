<div class="signup-title-text">
    Step 6 <span>Subjects You Teach/Tutor</span>
</div>

<div class="box" id="mysubjects">
    <div class="row">
    	<div class="col s12 m6 l6">
            <?php
                if(isset($action)){

                    $fixname = str_replace('-','',$action);
                    $name = NULL;
                    $name = 'mysubs_'.$fixname;
                    $name = $app->newtutor->$name;

                    if(!empty($name)){
                        $myvals = json_decode($name);
                    }
                }
            ?>
            <div class="row">
            	<div class="col s12 m4 l4">
                    <?php foreach($app->allsubs as $category): ?>
                        <a id="jt-<?php echo $category->parent_slug; ?>" class="btn btn-block <?php if(isset($action) && $action==$category->parent_slug){ echo ' active ';} ?>" href="/signup/tutor/category/<?php echo $category->parent_slug; ?>#mysubjects">
                            <?php echo $category->subject_parent; ?>
                        </a>
                    <?php endforeach; ?>
            	</div>
            	<div class="col s12 m8 l8">
            		<?php if(isset($app->allcats)): ?>
                        <form method="post" action="/signup/tutor/">
                            <input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $app->allcats[0]->parent_slug; ?>" />
                            <?php foreach($app->allcats as $sub):  ?>

                                <?php
                                    $description = NULL;
                                    $id = $sub->id;
                                    if(isset($myvals->$id)){
                                        if(isset($myvals->$id->description)){
                                            $description = $myvals->$id->description;
                                        }
                                    }
                                    //if(isset($myvals) && in_array($sub->id, $myvals)){ echo 'checked="checked"'; }
                                ?>

                            <div class="activate-subject new-inputs">
                                <input <?php if(isset($myvals->$id)){ echo 'checked="checked"';} ?> name="mysubjects[<?php echo $sub->id; ?>][id]" class="filled-in" type="checkbox" value="<?php echo $sub->id; ?>" id="<?php echo $sub->id; ?>" />
                                <label for="<?php echo $sub->id; ?>" <?php if(isset($myvals->$id)){ echo 'data-status="open"';}else{ echo 'data-status="closed"'; } ?>>
                                    <?php echo $sub->subject_name; ?>
                                </label>
                                <div class="input-wrapper <?php if(empty($myvals->$id)){ echo 'hide'; } ?>">
                                    <textarea name="mysubjects[<?php echo $sub->id; ?>][description]" class="materialize-textarea"><?php if(isset($description)){ echo $description; } ?></textarea>
                                </div>
                            </div>

                            <?php endforeach; ?>

                            <input type="hidden" name="mysubjects[target]" value="mysubjects"  />
                			<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                            <button class="btn blue" type="submit">Save</button>
                        </form>
                    <?php endif; ?>
            	</div>
            </div>
    	</div>
    	<div class="col s12 m5 l5">
            <div class="help-info">
                <div class="title">Help</div>
                <p class="red white-text padd5">You must list at least 1 subject before you can continue.</p>
                <p>List all the <span class="blue-text">subjects</span> that you teach or tutor.</p>

                <p>Click on a category on the left and then check off all the subjects you tutor.</p>
                <p>You can write about why you tutor each subject, but it's not required.</p>

            </div>
    	</div>
    </div>
</div>
