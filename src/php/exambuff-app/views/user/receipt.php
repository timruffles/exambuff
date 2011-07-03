<h2>Receipt</h2>
<p>Thanks for your order. Please print this page for your records. You can access it at any time through your account page, in the order history section.</p>
<table class="zebra">
<tr class="header"><th>Date</th><th>Description</th><th>Amount</th></tr>
<?php foreach(@$payments as $payment):?>
<tr><td><?=$order['date']?></td><td><?=$order['description']?></td><td><?=$order['amount']?></td></tr>
<?php endforeach;?>
</table>