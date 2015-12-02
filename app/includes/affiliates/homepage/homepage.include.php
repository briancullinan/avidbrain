<?php if(isset($app->signups)): ?>
    <h2>Signups</h2>
    <table>
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
                Session?
            </td>
        </tr>

        <?php foreach($app->signups as $signups): ?>
            <tr>
                <td><?php echo ucwords($signups->usertype); ?></td>
                <td><?php echo ucwords($signups->first_name); ?></td>
                <td><?php echo formatdate($signups->signup_date); ?></td>
                <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php else: ?>
    You have no Signups
<?php endif; ?>

<?php if(isset($app->signupswithsessions)): ?>
    <h2>Signups With Sessions</h2>
    <table>
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
                Session?
            </td>
        </tr>

        <?php foreach($app->signupswithsessions as $signups): ?>
            <tr>
                <td><?php echo ucwords($signups->usertype); ?></td>
                <td><?php echo ucwords($signups->first_name); ?></td>
                <td><?php echo formatdate($signups->signup_date); ?></td>
                <td><?php if(!empty($signups->id)){ echo 'Yes';}else{ echo 'No';} ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php else: ?>
    You have no Signups with Sessions
<?php endif; ?>
