
<?php if(isset($app->history)): ?>
    <table class="bordered striped hoverable responsive-table history-table">
        <tr class="blue white-text">
            <td>
                Type
            </td>
            <td>
                Amount + Service Fee
            </td>
            <td>
                Date
            </td>
            <td>
                Notes
            </td>
            <td>
                User Info
            </td>
        </tr>
	<?php foreach($app->history as $history): ?>
        <?php
            if(!empty($history->discount) && $app->user->usertype=='student'){

                $sql = "SELECT value as discount FROM avid___promotions_active WHERE id = :id";
                $prepare = array(':id'=>$history->discount);
                $results = $app->connect->executeQuery($sql,$prepare)->fetch();
                if(isset($results->discount)){
                    $history->discount = ($results->discount*100);
                    $history->amount = $history->amount-$history->discount;
                }
            }
        ?>
		<tr>
            <td>
                <?php echo $history->type; ?>
            </td>
            <td>
                $<?php echo numbers(($history->amount/100)); ?>
            </td>

            <td>
                <?php echo formatdate($history->date,'M. jS, Y @ g:i a'); ?>
            </td>
            <td>
                <?php if(isset($history->session_subject)){ echo $history->session_subject.'<br>'; } ?>
                <?php echo $history->notes; ?>
            </td>
            <td>
                <a href="<?php echo $history->url; ?>" target="_blank"><?php echo the_users_name($history); ?></a>
            </td>
        </tr>
	<?php endforeach; ?>
    </table>
<?php endif; ?>
