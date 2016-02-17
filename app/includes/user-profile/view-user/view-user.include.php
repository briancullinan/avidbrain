<div class="new-hero">
    <div class="new-hero-left">
        <img src="<?php echo userphotographs($app->user,$app->actualuser); ?>" />
    </div>
    <div class="new-hero-right">

        <div class="my-tagline">
            <span><?php echo $app->actualuser->mytagline; ?><?php if(isset($app->actualuser->mytaglineflag)){ echo ' <i class="yellow-text fa fa-warning tooltipped" data-position="top" data-delay="50" data-tooltip="Needs Verified"></i> ';} ?></span>
        </div>

        <div class="user-hero-items">
            <?php
                if(empty($pagename)){
                    $pagename = 'about-me';
                }
            ?>
            <div class="my-tabs">
                <ul>
                    <?php foreach($app->mypages as $key => $page): ?>
                        <li <?php if(isset($pagename) && $pagename==$key){ echo 'class="active"';} ?>>
                            <a href="<?php echo $app->actualuser->url; ?>/<?php echo $key; ?>">
                                <?php echo $page; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

    </div>
</div>


<div class="row fixed-rows">
    <div class="col s12 m4 l3">
        <div class="user-info">

            <?php
                $staticBadges = [];
                $staticBadges[] = (object)array('class'=>'my-name','icon'=>'fa fa-rocket','results'=>short($app->actualuser));
                if(!empty($app->actualuser->hourly_rate)){
                    $staticBadges[] = (object)array('class'=>'hourlyrate','icon'=>'fa fa-dollar','results'=>'$'.numbers($app->actualuser->hourly_rate).'/<span>Hour</span>');
                }
                $staticBadges[] = (object)array('class'=>'location','icon'=>'fa fa-map-marker','results'=>'<a href="/searching/---/'.$app->actualuser->zipcode.'">'.$app->actualuser->city.', '.ucwords($app->actualuser->state_long).'</a>');
                if(!empty($app->actualuser->gender) && $app->actualuser->gender!='_empty_'){
                    $staticBadges[] = (object)array('class'=>'gender','icon'=>'fa fa-'.$app->actualuser->gender,'results'=>"I'm ".ucwords($app->actualuser->gender));
                }
                if(!empty($app->actualuser->travel_distance)){
                    $staticBadges[] = (object)array('class'=>'travel-distance','icon'=>'fa fa-car','results'=>'I Will Travel '.numbers($app->actualuser->travel_distance,1).' Miles');
                }
                if(!empty($app->actualuser->cancellation_policy)){
                    $staticBadges[] = (object)array('class'=>'cancellation-policy','icon'=>'fa fa-clock-o','results'=>$app->actualuser->cancellation_policy.' Hour Cancelation Policy');
                }
                if(!empty($app->actualuser->cancellation_rate)){
                    $staticBadges[] = (object)array('class'=>'cancellation-rate','icon'=>'fa fa-times-circle-o ','results'=>'$'.numbers($app->actualuser->cancellation_rate).' Cancelation Rate');
                }
                if(!empty($app->actualuser->online_tutor)){
                    $staticBadges[] = (object)array('class'=>'tutortype-rate','icon'=>'fa fa-bookmark ','results'=>'I Tutor '.online_tutor($app->actualuser->online_tutor));
                }

                $staticBadges[] = (object)array('class'=>'signup-date','icon'=>'fa fa-calendar','results'=>'Joined '.formatdate($app->actualuser->signup_date));

            ?>
            <?php foreach($staticBadges as $ajaxBadge): ?>
                    <div class="newest-badge <?php echo $ajaxBadge->class; ?>">
                        <span class="newest-badge-icon"><i class="<?php echo $ajaxBadge->icon; ?>"></i></span> <?php echo $ajaxBadge->results; ?>
                    </div>
            <?php endforeach; ?>

            <div class="ajax-badges" id="<?php echo str_replace('/','',$app->actualuser->url); ?>" data-url="<?php echo $app->actualuser->url; ?>"></div>


        </div>
        <div class="right-nav hide-on-large-only" id="copyme">
            <div class="new-user-prompt">

                <div class="new-user-prompt-title">New to AvidBrain?</div>
                <div class="new-user-prompt-copy">Sign up now and start learning in no time!</div>
                <div>
                    <a href="/signup" class="btn blue btn-block">Signup Now</a>
                </div>

            </div>

            <?php if(isset($app->recommendations)): ?>
                <div class="recommendations-container hide-on-small-only">
                    <div class="recommendations-title">Recommendations</div>
                    <?php foreach($app->recommendations as $recommendations): ?>
                        <div class="recommendations">
                            <div class="row">
                            	<div class="col s12 m4 l4">
                                    <a href="<?php echo $recommendations->url; ?>"><img class="responsive-img" src="<?php echo userphotographs($app->user,$recommendations); ?>" /></a>
                            	</div>
                            	<div class="col s12 m8 l8">
                                    <div class="username"><a href="<?php echo $recommendations->url; ?>"><?php echo short($recommendations); ?></a></div>
                                    <div>$<?php echo numbers($recommendations->hourly_rate); ?>/Hour</div>
                                    <div><?php echo $recommendations->distance; ?> Miles Away</div>
                            	</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col s12 m8 l6">
        <div class="tab-content">
            <?php
                if(isset($app->user->email) && $app->user->email == $app->actualuser->email && $pagename=='my-subjects'){
                    $pagename = $pagename.'-edit-subjects';
                }
                include('view-user--'.$pagename.'.php');
            ?>
        </div>
    </div>
    <div class="col s12 m3 l3 hide-on-med-and-down">
        <div class="copy-that"></div>
    </div>
</div>

<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>

<style type="text/css">
.make-changes{
    background: #efefef;
    color: #666;
    position: absolute;
    right: 1px;
    top:1px;
    padding:5px 10px;
    font-size: 18px;
    cursor: pointer;
}
.make-changes i{
    color: #666;
}
.make-changes:hover{
    background: #ccc;
    color: #333;
}
</style>


<?php if($app->actualuser->email==$app->user->email): ?>
<form method="post" id="makethechanges" action="<?php echo $app->request->getPath(); ?>">

	<input type="hidden" name="makechanges[target]" value="makechanges"  />
	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

</form>



<script type="text/javascript">

	$(document).ready(function() {

        var makeclicks = {
            '.aboutme':'aboutme',
            '.my-tagline':'mytagline',
            '.newest-badge.my-name':'changemyname',
            '.newest-badge.hourlyrate':'changerate',
            '.newest-badge.location':'changelocation',
            '.newest-badge.gender':'changemygender',
            '.newest-badge.travel-distance':'changetraveldistance',
            '.newest-badge.cancellation-policy':'changecancellationpolicy',
            '.newest-badge.cancellation-rate':'changecancellationrate',
            '.new-hero-left':'changephoto',
            '.newest-badge.tutortype-rate':'changetutortype'
        };
        $.each(makeclicks,function(index,value){
            $(index).append('<div data-target="'+value+'" class="make-changes"><i class="fa fa-pencil"></i></div>');
        });


        var makechanges = $('#makechanges').detach();
        $('footer').parent().append(makechanges);

        $('.make-changes').on('click',function(){
            var target = $(this).attr('data-target');
            $('.makechangescontainer').addClass('hide');
            $('#makechanges').openModal({
                ready:function(){
                    $('.'+target+'-container').removeClass('hide').hide().fadeIn();
                }
            });

            $('.savecahnges').on('click',function(){
                var savetarget = $(this).attr('data-target');
                var savevalue = $('#'+savetarget);
                $('#makethechanges').append(savevalue).submit();;
            });
        });

	});

</script>

<?php endif; ?>


<?php if($app->actualuser->email==$app->user->email): ?>
<div id="makechanges" class="modal">
    <div class="makechangescontainer aboutme-container hide">
        <div class="modal-content">
    	    <h4>About Me</h4>
			<div class="modal-inputs">
				<textarea class="materialize-textarea" rows="10" id="personal_statement" name="makechanges[statement]"><?php echo $app->actualuser->statement; ?></textarea>
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="personal_statement" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changemygender-container hide">
        <div class="modal-content">
    	    <h4>My Gender</h4>
			<div class="modal-inputs">
                <select class="browser-default" id="changemygender" name="makechanges[gender]">
                    <?php foreach(array('male'=>'Male','female'=>'Female') as $key=>$types): ?>
                        <option value="<?php echo $key; ?>" <?php if(isset($app->actualuser->gender) && $app->actualuser->gender==$key){ echo 'selected="selected"';} ?>>
                            <?php echo $types; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changemygender" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changetraveldistance-container hide">
        <div class="modal-content">
    	    <h4>Travel Distance</h4>
			<div class="modal-inputs">
				<input type="number" min="1" max="1000" id="changetraveldistance" name="makechanges[travel_distance]" value="<?php echo $app->actualuser->travel_distance; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changetraveldistance" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changecancellationpolicy-container hide">
        <div class="modal-content">
    	    <h4>Cancelation Policy</h4>
            <div class="modal-help">How much time do you need for a student to cancel, without getting charged?</div>
			<div class="modal-inputs">
				<input type="number" min="0" max="48" id="changecancellationpolicy" name="makechanges[cancellation_policy]" value="<?php echo $app->actualuser->cancellation_policy; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changecancellationpolicy" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changecancellationrate-container hide">
        <div class="modal-content">
    	    <h4>Cancelation Rage</h4>
            <div class="modal-help">How much do you chage for a canceled session?</div>
			<div class="modal-inputs">
				<input type="number" min="0" max="100" id="changecancellationrate" name="makechanges[cancellation_rate]" value="<?php echo $app->actualuser->cancellation_rate; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changecancellationrate" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changephoto-container hide">
        <div class="modal-content">
    	    <h4>My Photo</h4>
			<div class="modal-inputs">
                <img src="<?php echo userphotographs($app->user,$app->actualuser); ?>" />
				crop,delete,rotate-left,rotate-right

                AVATARS
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changephoto" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changetutortype-container hide">
        <div class="modal-content">
    	    <h4>My Tutoring Location Preference</h4>
			<div class="modal-inputs">
				<select class="browser-default" id="changetutortype" name="makechanges[online_tutor]">
                    <?php foreach(array('online'=>online_tutor('online'),'offline'=>online_tutor('offline'),'both'=>online_tutor('both')) as $key=>$types): ?>
                        <option value="<?php echo $key; ?>" <?php if(isset($app->actualuser->online_tutor) && $app->actualuser->online_tutor==$key){ echo 'selected="selected"';} ?>>
                            <?php echo $types; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changetutortype" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <?php
    /*
    <div class="makechangescontainer xxxxxx-container hide">
        <div class="modal-content">
    	    <h4>xxxxxx</h4>
			<div class="modal-inputs">
				<input type="text" id="xxxxxx" name="makechanges[xxxxxx]" value="<?php echo $app->actualuser->xxxxxx; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="xxxxxx" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>
    */
    ?>

    <div class="makechangescontainer mytagline-container hide">
        <div class="modal-content">
    	    <h4>My Tagline</h4>
			<div class="modal-inputs">
				<input type="text" id="mytagline" maxlength="40" name="makechanges[mytagline]" value="<?php echo $app->actualuser->mytagline; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="mytagline" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changerate-container hide">
        <div class="modal-content">
    	    <h4>Hourly Rate</h4>
			<div class="modal-inputs">
				<input type="number" min="20" max="500" id="changerate" name="makechanges[hourly_rate]" value="<?php echo $app->actualuser->hourly_rate; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changerate" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changelocation-container hide">
        <div class="modal-content">
    	    <h4>My Location</h4>
			<div class="modal-inputs" id="changelocation">
                <input type="text" id="userlocationinfo" name="makechanges[locationinfo]" value="<?php echo $app->actualuser->city.', '.ucwords($app->actualuser->state_long); ?>"  />
                <input type="hidden" id="userlocationinfo-zipcode" name="makechanges[zipcode]" value="<?php echo $app->actualuser->zipcode; ?>"  />
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="changelocation" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

    <div class="makechangescontainer changemyname-container hide">
        <div class="modal-content">
    	    <h4>My Name</h4>
			<div class="modal-inputs" id="myname">
                <div class="row">
                	<div class="col s12 m6 l6">
                        <input type="text" name="makechanges[first_name]" value="<?php echo $app->actualuser->first_name; ?>"  />
                	</div>
                	<div class="col s12 m6 l6">
                		<input type="text" name="makechanges[last_name]" value="<?php echo $app->actualuser->last_name; ?>"  />
                	</div>
                </div>
			</div>
    	</div>
        <div class="modal-footer">
    		<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Dismiss</a>
    		<a href="#!" data-target="myname" class="savecahnges modal-action modal-close waves-effect waves-green btn-flat">Save Changes</a>
        </div>
    </div>

</div>
<?php endif; ?>
