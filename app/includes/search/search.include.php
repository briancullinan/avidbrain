    <div class="results">
        <div class="row">
        	<div class="col s12 m3 l3">
        		<div class="block">
                    <form method="post" action="#" class="javascript" id="itsposttime">

        				<div class="input-container">
        					<label>Subject</label>
        					<input type="text" name="subject" class="javascript-subject" />
        				</div>

        				<div class="input-container">
        					<label>Zipcode</label>
        					<input type="text" name="subject" class="javascript-location" />
        				</div>


        				<div class="input-container">
        					<label>Distance</label>
        					<select id="javascript-distance" class="browser-default">
        						<?php foreach(array(5,20,50,100,500,1000,5000,10000) as $distance): ?>
        							<option <?php if($distance==50){ echo 'selected="selected"';} ?> value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
        						<?php endforeach; ?>
        					</select>
        				</div>



        				<div class="input-container">
        					<label>Gender</label>
        					<select id="javascript-gender" class="browser-default">
        						<?php foreach(array('No Preference'=>'','Male'=>'male','Female'=>'female',) as $key=> $gender): ?>
        							<option value="<?php echo $gender; ?>">
        								<?php echo $key; ?>
        							</option>
        						<?php endforeach; ?>
        					</select>
        				</div>



        				<div class="input-container">
        					<label>Price Range</label>
        					<select id="javascript-pricerange" class="browser-default">
        						<?php
        							$priceArray = array(
        								'0-25'=>'$0 - $20',
        								'0-50'=>'$0 - $50',
        								'0-100'=>'$0 - $100',
        								'0-125'=>'$0 - $125',
        								'0-200'=>'$0 - $200',
        								'0-500'=>'$0 - $500',
        								'0-1000'=>'$0 - $1,000',
        							);
        						?>
        						<?php foreach($priceArray as $key=> $pricerange): ?>
        							<option <?php if($key=='0-100'){ echo 'selected="selected"';} ?>  value="<?php echo $key; ?>">
        								<?php echo $pricerange; ?>
        							</option>
        						<?php endforeach; ?>
        					</select>
        				</div>


        				<input type="text" name="subject" class="javascript-name" placeholder="Name" />


        				<input type="text" name="subject" class="javascript-page" placeholder="Page" value="1" />
        				<input type="text" name="subject" class="javascript-sort" placeholder="Page" value="lastactive" />

        				<br/>
        				<button type="submit" class="submit-a-form btn" data-form = "#itsposttime" > <i class="fa fa-search"></i> Search</button>

                        <input id="csrf" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
                        <div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
                        <div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>

                        <input type="hidden" class="buildurl" />
                        <input type="hidden" class="nexturl" />

        			</form>
                </div>
        	</div>
        	<div class="col s12 m9 l9">
                <div class="xxx">
                    <span class="numbers"></span>
                </div>
                <div class="page-results"></div>

                <div class="pagination"></div>
        	</div>
        </div>
    </div>

    <div class="template hidden"></div>
