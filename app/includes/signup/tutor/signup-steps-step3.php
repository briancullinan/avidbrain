<div class="signup-title-text">
    Step 4 <span>Tutoring Information</span>
</div>

<div class="box">
    <div class="row">
    	<div class="col s12 m6 l6">
            <form method="post" class="form-post " action="/signup/tutor" id="tutoringinfo">

                <div class="new-inputs">
                    <label>What is your hourly rate? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper" id="tutoringinfo_hourly_rate"><input type="text" name="tutoringinfo[hourly_rate]" placeholder="What is your hourly rate?" <?php echo 'value="'.isitset($app->newtutor->hourly_rate).'"'; ?> /></div>
                </div>

                <div class="new-inputs">
                    <label>Please provide 3 References (Emails, or Phone Numbers) <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper" id="tutoringinfo_references"><textarea class="materialize-textarea" name="tutoringinfo[references]" placeholder="Please provide 3 References"><?php echo isitset($app->newtutor->references); ?></textarea></div>
                </div>

                <div class="new-inputs">
                    <label>How far are you willing to travel? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper-select" id="tutoringinfo_travel_distance">
                        <?php
                            $travel_distance = isitset($app->newtutor->travel_distance);

                        ?>
                        <select name="tutoringinfo[travel_distance]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                foreach(array(0,5,10,20,25,50,100) as $value){
                                    $activate = NULL;
                                    if(isset($travel_distance) && $travel_distance==$value){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$value.'">'.$value.' Miles</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>Do you tutor: online, in-person or both? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper-select" id="tutoringinfo_online_tutor">
                        <select name="tutoringinfo[online_tutor]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                $online_tutor = isitset($app->newtutor->online_tutor);
                                foreach(array('online'=>'Online','offline'=>'In-Person','both'=>'Both') as $key => $value){
                                    $activate = NULL;
                                    if(isset($online_tutor) && $online_tutor==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>How long is your cancelation policy? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper-select" id="tutoringinfo_cancellation_policy">
                        <select name="tutoringinfo[cancellation_policy]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                $cancellation_policy = isitset($app->newtutor->cancellation_policy);
                                foreach(array(0=>'No Cancelation Policy',1=>'1 Hour',2=>'2 Hours',6=>'6 Hours',12=>'12 Hours',24=>'24 Hours') as $key => $value){
                                    $activate = NULL;
                                    if(isset($cancellation_policy) && $cancellation_policy==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="new-inputs">
                    <label>What is your cancelation fee? <span class="signup-required"><i class="fa fa-asterisk"></i></span></label>
                    <div class="input-wrapper-select" id="tutoringinfo_cancellation_rate">
                        <select name="tutoringinfo[cancellation_rate]" class="browser-default">
                            <option value="--"> -- </option>
                            <?php
                                $cancellation_rate = isitset($app->newtutor->cancellation_rate);
                                foreach(array(0=>'No Cancelation Rate',10=>'$10.00',20=>'$20.00',30=>'$30.00',40=>'$40.00',50=>'$50.00') as $key => $value){
                                    $activate = NULL;
                                    if(isset($cancellation_rate) && $cancellation_rate==$key){
                                        $activate = ' selected="selected" ';
                                    }
                                    echo '<option '.$activate.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn success">Save</button>

                <input type="hidden" name="tutoringinfo[target]" value="tutoringinfo"  />
                <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
            </form>
    	</div>
    	<div class="col s12 m6 l6">
            <div class="help-info">
                <div class="title">Help</div>

                <p>The average <span class="blue-text">hourly rate</span> for tutoring is $40.00, but it can range widly from $15.00/Hour all the way up to $300.00/Hour.</p>
                <p>We require that you provide <span class="blue-text">3 references</span>, to ensure the highest quality tutors. If you don't have any references, please explain why.</p>
                <p>How far are you  <span class="blue-text">willing to travel</span> to meetup with a student?</p>
                <p>You can tutor <span class="blue-text">Online, In-Person or Both.</span> We provide an online Whiteboard solution you can use to tutor students online. Or if you prefer you can setup an in-person meeting with them at your desired location.</p>
                <p>You can provide a <span class="blue-text">cancellation policy</span> if you would like to require a student to notify you that they have to cancel.</p>
                <p>If a student cancels without letting you know you can charge them a  <span class="blue-text">cancellation fee.</span></p>


            </div>
    	</div>
    </div>
</div>
