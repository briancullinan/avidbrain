<?php // printer($app->actualuser->subjects);

    $sql = "
        SELECT
            subjects.*
        FROM
            avid___available_subjects subjects
        GROUP BY subjects.parent_slug
        ORDER BY parent_slug ASC
    ";
    $prepare = array(

    );
    $availableCategories = $app->connect->executeQuery($sql,$prepare)->fetchAll();

    if(isset($category)){
        $sql = "
			SELECT
				subjects.*
			FROM
				avid___available_subjects subjects
			WHERE
				subjects.parent_slug = :category
                    AND
                subject_slug IS NOT NULL
		";
		$prepare = array(
			':category'=>$category
		);
		$availableSubjects = $app->connect->executeQuery($sql,$prepare)->fetchAll();
    }

    if(isset($category) && isset($subject)){
        $sql = "
			SELECT
				subjects.*
			FROM
				avid___user_subjects subjects
			WHERE
                email = :myemail
                    AND
				parent_slug = :parent_slug
                    AND
    			subject_slug = :subject_slug
		";
		$prepare = array(
			':myemail'=>$app->actualuser->email,
    		':parent_slug'=>$category,
    		':subject_slug'=>$subject
		);
		$ihavethissubject = $app->connect->executeQuery($sql,$prepare)->fetch();
        if(empty($ihavethissubject)){
            $sql = "
    			SELECT
    				subjects.*
    			FROM
    				avid___available_subjects subjects
    			WHERE
    				subjects.parent_slug = :parent_slug
                        AND
                    subjects.subject_slug = :subject_slug
    		";
    		$prepare = array(
        		':parent_slug'=>$category,
        		':subject_slug'=>$subject
    		);
    		$thesubjectidonthave = $app->connect->executeQuery($sql,$prepare)->fetch();
        }
    }

?>
<select class="browser-default selectcategories">
    <option value="">Select A Category</option>
    <?php foreach($availableCategories as $categories): ?>
        <option <?php if(isset($category) && $categories->parent_slug==$category){ echo 'selected="selected"';} ?> data-value="<?php echo $app->actualuser->url.'/my-subjects/'.$categories->parent_slug; ?>" value="<?php echo $categories->parent_slug; ?>">
            <?php echo $categories->subject_parent; ?>
        </option>
    <?php endforeach; ?>
</select>
<?php if(!empty($availableSubjects)): ?>

    <select class="browser-default selectcategories">
        <option value="">Select A Subject</option>
        <?php foreach($availableSubjects as $subjects): ?>
            <option <?php if(isset($subject) && $subjects->subject_slug==$subject){ echo 'selected="selected"';} ?> data-value="<?php echo $app->actualuser->url.'/my-subjects/'.$category.'/'.$subjects->subject_slug.''; ?>" value="<?php echo $subjects->subject_slug; ?>">
                <?php echo $subjects->subject_name; ?>
            </option>
        <?php endforeach; ?>
    </select>

<?php endif; ?>


<?php if(isset($app->actualuser->subjects->approved)): ?>
    <div class="the-divider"></div>
    <h3>Approved Subjects</h3>
    <div class="new-alert blue white-text"> <i class="fa fa-warning"></i> If you modify an approved subject it will have to be re-verified before it's public.</div>
    <?php foreach($app->actualuser->subjects->approved as $key=> $approved): ?>
        <div class="my-content-block <?php if(isset($subject) && $subject==$approved->subject_slug){ echo ' active-subject-block ';} ?>" data-id="<?php echo $approved->parent_slug.$approved->subject_slug; ?>" id="<?php echo $approved->parent_slug.$approved->subject_slug; ?>">
            <div class="my-content-block-title">
                <i class="mdi-maps-beenhere tooltipped verified-by" data-position="top" data-delay="50" data-tooltip="Verified By AvidBrain"></i>
                <?php echo $approved->subject_name; ?>
            </div>

            <form method="post" action="<?php echo $app->actualuser->url; ?>">
                <input type="hidden" name="mysubjects[target]" value="mysubjects"  />
                <input type="hidden" name="mysubjects[subject_name]" value="<?php echo $approved->subject_name; ?>"  />
                <input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $approved->parent_slug; ?>"  />
                <input type="hidden" name="mysubjects[subject_slug]" value="<?php echo $approved->subject_slug; ?>"  />
                <input type="hidden" name="mysubjects[sortorder]" value="<?php echo $approved->sortorder; ?>"  />

                <input type="hidden" name="mysubjects[id]" value="<?php echo $approved->id; ?>"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

                <div class="my-content-block-copy"><textarea name="mysubjects[description_verified]" class="materialize-textarea"><?php echo $approved->description_verified; ?></textarea></div>
                <button class="btn btn-s confirm-submit" type="button" data-name="mysubjects" data-value="save">
                    Save
                </button>
                <button class="btn btn-s red confirm-submit" type="button" data-name="mysubjects" data-value="delete">
                    Delete <i class="fa fa-trash"></i>
                </button>
                <?php if(isset($app->adminnow)): ?>
                    <button type="button" class="btn btn-s blue confirm-submit" data-name="mysubjects" data-value="approve">
                        Approve <i class="fa fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-s orange confirm-submit" data-name="mysubjects" data-value="reject">
                        Reject <i class="fa fa-ban"></i>
                    </button>
                <?php endif; ?>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(!empty($thesubjectidonthave)): ?>
    <div class="the-divider"></div>
    <h3>Non-Approved Subjects</h3>
    <div class="my-content-block active-subject-block" data-id="<?php echo $thesubjectidonthave->parent_slug.$thesubjectidonthave->subject_slug; ?>" id="<?php echo $thesubjectidonthave->parent_slug.$thesubjectidonthave->subject_slug; ?>">
        <div class="my-content-block-title">
            <?php echo $thesubjectidonthave->subject_name; ?>
        </div>

        <form method="post" action="<?php echo $app->actualuser->url; ?>">
            <input type="hidden" name="mysubjects[target]" value="mysubjects"  />
            <input type="hidden" name="mysubjects[subject_name]" value="<?php echo $thesubjectidonthave->subject_name; ?>"  />
            <input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $thesubjectidonthave->parent_slug; ?>"  />
            <input type="hidden" name="mysubjects[newitem]" value="1"  />
            <input type="hidden" name="mysubjects[subject_slug]" value="<?php echo $thesubjectidonthave->subject_slug; ?>"  />
            <input type="hidden" name="mysubjects[id]" value="<?php echo $thesubjectidonthave->id; ?>"  />
            <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

            <div class="my-content-block-copy"><textarea name="mysubjects[description]" class="materialize-textarea"></textarea></div>
            <button class="btn btn-s confirm-submit" type="button" data-name="mysubjects" data-value="save">
                Save
            </button>
        </form>
    </div>
<?php endif; ?>

<?php if(isset($app->actualuser->subjects->notApproved)): ?>
    <div class="the-divider"></div>
    <h3>Non-Approved Subjects</h3>
    <?php foreach($app->actualuser->subjects->notApproved as $key=> $notApproved): ?>
        <div class="my-content-block <?php if(isset($subject) && $subject==$notApproved->subject_slug){ echo ' active-subject-block ';} ?>" data-id="<?php echo $notApproved->parent_slug.$notApproved->subject_slug; ?>" id="<?php echo $notApproved->parent_slug.$notApproved->subject_slug; ?>">
            <div class="my-content-block-title">
                <?php echo $notApproved->subject_name; ?>
            </div>

            <form method="post" action="<?php echo $app->actualuser->url; ?>">
                <input type="hidden" name="mysubjects[target]" value="mysubjects"  />
                <input type="hidden" name="mysubjects[subject_name]" value="<?php echo $notApproved->subject_name; ?>"  />
                <input type="hidden" name="mysubjects[parent_slug]" value="<?php echo $notApproved->parent_slug; ?>"  />
                <input type="hidden" name="mysubjects[subject_slug]" value="<?php echo $notApproved->subject_slug; ?>"  />
                <input type="hidden" name="mysubjects[id]" value="<?php echo $notApproved->id; ?>"  />
                <input type="hidden" name="mysubjects[sortorder]" value="<?php echo $notApproved->sortorder; ?>"  />
            	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

                <div class="my-content-block-copy"><textarea name="mysubjects[description]" class="materialize-textarea"><?php echo $notApproved->description; ?></textarea></div>
                <button class="btn btn-s confirm-submit" type="button" data-name="mysubjects" data-value="save">
                    Save <i class="fa fa-save"></i>
                </button>
                <button class="btn btn-s red confirm-submit" type="button" data-name="mysubjects" data-value="delete">
                    Delete <i class="fa fa-trash"></i>
                </button>

                <?php if(isset($app->adminnow)): ?>
                    <button type="button" class="btn btn-s blue confirm-submit" data-name="mysubjects" data-value="approve">
                        Approve <i class="fa fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-s orange confirm-submit" data-name="mysubjects" data-value="reject">
                        Reject <i class="fa fa-ban"></i>
                    </button>
                <?php endif; ?>

            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<style type="text/css">
.new-alert{
    padding: 10px;
    display: block;
    text-align: center;
}
.the-divider{
    margin: 15px 0px;
    height: 20px;
    width: 100%;
}
.my-content-block.active-subject{
	border: solid 5px #2196F3;
}
</style>

<script type="text/javascript">

	$(document).ready(function() {


        $('.selectcategories').on('change',function(){
			var activeattr = $('option:selected', this).attr('data-value');
			window.location = activeattr;
		});
	});

</script>
