<div class="row">
	<div class="col s12 m3 l3">
		<?php if(isset($app->affiliates)): ?>
            <?php foreach($app->affiliates as $affiliates): ?>
                <div class="affiliatelinks">
                    <a href="/admin-everything/affiliates/view/<?php echo $affiliates->id; ?>" <?php if(isset($id) && $id == $affiliates->id){ echo 'class="active"';} ?>>
                        <?php echo $affiliates->email; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($app->affiliate)):  ?>

            <?php
                $show = array(
                    'email'=>'Email',
                    'first_name'=>'Firs Name',
                    'last_name'=>'Last Name',
                    'mycode'=>'Promo Code',
                    'getpaid'=>'Payment Type',
                    'userid'=>'User Id',
                    'url'=>'Profile Link'
                );

            ?>

            <?php foreach($show as $key => $term): ?>
                <?php if(!empty($app->affiliate->$key)): ?>
                <div class="row">
                    <div class="col s12 m3 l3">
                		<strong><?php echo $term; ?>: </strong>
                	</div>
                	<div class="col s12 m9 l9">
                		<?php echo $app->affiliate->$key; ?>
                	</div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>

        <?php endif; ?>
	</div>
</div>


<style type="text/css">
.affiliatelinks{
    margin-bottom: 5px;
}
.affiliatelinks a{
    background: #fff;
    color: #333;
    display: block;
    padding: 5px;
    border: solid 1px #ccc;
}
.affiliatelinks a:hover, .affiliatelinks a.active{
    background: #ccc;
    color: #fff;
}
</style>
