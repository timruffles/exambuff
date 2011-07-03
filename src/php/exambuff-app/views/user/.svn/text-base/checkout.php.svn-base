<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper('progressor');
$this->load->helper('form'); ?>
<h2>Submit essay</h2>
<?= eb_progress_bar($progressSteps,'pay') ?>
<h3>Pay for essay</h3>
<p>When you are ready to pay for your essay, click on one of the checkout methods to continue. As soon as your payment has been sent our tutors will be able to being looking over your essay.</p>
<table class="checkout">
<form method="POST" action="<?=site_url('user/pay',true)?>">
<tr class="header"><th class="description">Question</th><th class="amount">Amount</th></tr>
<?php 
// data for each row
$i=0;
$total = 0.00;
foreach($scripts as $script):

$i++;
strlen($script['question'])>36 ? $question = substr($script['question'],0,33) .'...' : $question = $script['question'];
$amount = $script['value'] ? $script['value'] : 9.99;

$total += $amount;

?>
<tr <?php if($i%2===0) echo 'class="zebra"';?> id="r<?=$script['ID']?>"></td><td><?=$question?></td><td class="rTotal">&pound;<span class="rTotal"><?=number_format($amount,2)?></td></tr>
<?php
endforeach;
?>
<tr <?php if($i+1%2===0) echo 'class="zebra"';?>><td style="text-align:right">Total tax, shipping etc:</td><td>&pound;<span>0.00</span></td></tr>
<tr class="lastRow"><td class="totalLabel">Total:</td><td>&pound;<span id="paymentTotal"><?=number_format($total,2);?></span></td></tr>
</table>
<table style="margin-top:20px">
<tr>
	<td class="checkoutOpt">
		Checkout with credit or debit card:
	</td>
	<td class="paymentOption">
		<input id="ccCheckout" type="submit" value="Checkout with Credit/Debit Card" name="payment-method"/>
	</td>
</tr>

<tr>
	<td class="checkoutOpt">
		Checkout with PayPal Express Checkout:
	</td>
	<td class="paymentOption">
		<input id="ppCheckout" type="submit" value="Checkout with Paypal" name="payment-method"/>
	</td>
</tr>
</form>
</table>
<p class="minor">All payment information is transmitted over SSL directly to our payment gateway, and at no point is stored by us.</p>