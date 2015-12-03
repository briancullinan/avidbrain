<div class="row">
	<div class="col s12 m3 l3">
		<div class="block">
            <div class="title">Total Pay</div>
            $<?php echo numbers(total_affiliate($app->count)); ?>
        </div>
	</div>
	<div class="col s12 m9 l9">
		<?php if(isset($app->signups)): ?>
            <h2>All Signups</h2>
            <table class="bordered striped condensed">
                <tr class="blue white-text">
                    <td>
                        Usertype
                    </td>
                    <td>
                        Name
                    </td>
                    <td>
                        Signup Date
                    </td>
                    <td>
                        Paid
                    </td>
                </tr>

                <?php foreach($app->signups as $signups): ?>
                    <tr>
                        <td><?php echo ucwords($signups->usertype); ?></td>
                        <td><?php echo ucwords($signups->first_name); ?></td>
                        <td><?php echo formatdate($signups->signup_date); ?></td>
                        <td><?php if(isset($signups->id)){ echo '<i class="fa fa-check green-text"></i>'; } ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>
            You have no Signups
        <?php endif; ?>

        <?php if(isset($app->studentsiwthsessions)): ?>
            <br>
            <h2>Students With Sessions</h2>
            <table class="bordered striped condensed">
                <tr class="blue white-text">
                    <td>
                        Name
                    </td>
                    <td>
                        Signup Date
                    </td>
                    <td>
                        Session?
                    </td>
                </tr>

                <?php foreach($app->studentsiwthsessions as $signups): ?>
                    <tr>
                        <td><?php echo ucwords($signups->first_name); ?></td>
                        <td><?php echo formatdate($signups->signup_date); ?></td>
                        <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>
            You have no Signups with Sessions
        <?php endif; ?>


        <?php if(isset($app->tutorswithsessions)): ?>
            <br>
            <h2>Tutors With Sessions</h2>
            <table class="bordered striped condensed">
                <tr class="blue white-text">
                    <td>
                        Name
                    </td>
                    <td>
                        Signup Date
                    </td>
                    <td>
                        Session?
                    </td>
                </tr>

                <?php foreach($app->tutorswithsessions as $signups): ?>
                    <tr>
                        <td><?php echo ucwords($signups->first_name); ?></td>
                        <td><?php echo formatdate($signups->signup_date); ?></td>
                        <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        <?php else: ?>
            You have no Signups with Sessions
        <?php endif; ?>

	</div>
</div>
