<?php if(isset($app->history)): ?>
    <table class="bordered striped hoverable responsive-table history-table">
        <tr class="blue white-text">
            <td>
                Type
            </td>
            <td>
                Amount
            </td>
            <td>
                Date
            </td>
            <td>
                Notes
            </td>
        </tr>
	<?php foreach($app->history as $history): ?>
		<tr>
            <td>
                <?php echo $history->type; ?>
            </td>
            <td>
                $<?php echo numbers(($history->amount/100)); ?>
            </td>
            <td>
                <?php echo formatdate($history->date); ?>
            </td>
            <td>
                <?php echo $history->notes; ?>
            </td>
        </tr>
	<?php endforeach; ?>
    </table>
<?php endif; ?>
