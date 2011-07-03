<?php $this->load->helper('form');
$this->load->helper('friendly');?>
<h2>Get paid</h2>
<?php
if($this->validation->error_string!='')$errors[] = $this->validation->error_string;
$this->load->view('chunks/messages_ajax',array('errors'=>@$errors));

define('ZEBRA','zebra');	
if($assessment) $marks[] = array('question'=>'<b>Assessment essay</b>');
if($assessmentFixReq) $marks[] = array('question'=>'<b>Assessment bounty</b>');
$numScripts = count($marks);
?>

<?php if($numScripts!=0):?>

<table id="marks" class="data">
	<tr>
		<th>Question</th>
		<th>Mark submitted</th>
	</tr>
<?php for($i=0;$i<$numScripts;$i++):	
			$rowOdd = $i % 2;
			$rowOdd ? $rowClass = ZEBRA : $rowClass = '';
			?>
	<tr class="<?=$rowClass?>">
		<td class="question"><?=$marks[$i]['question'];?></td>
		<td class "changed">
			<?php if(@$marks[$i]['updated']):?>
				<?=ucfirst(friendly_date(strtotime($marks[$i]['updated'])));?>
			<?php endif;?>
		</td>
	</tr>			
<?php endfor;?>
	<tr class="pageate">
		<td colspan="2" class="back">
		<?php 
		// don't want to link back to 1, remainder created by if we click back to starting page by additional 1
			  if(@$startFrom && @$startFrom > $resultsPer): 
			  	 $startFrom == $resultsPer + 1 ? $backNum = '' : $backNum = $startFrom-$resultsPer;
			  ?>
			 
			<a href="<?=site_url("user/orders/$backNum")?>">Back</a>
		<?php endif;?>
		</td>
		<td colspan="2" class="forward">
		<?php if(@$pageate):
			  // need to start off increase by one
		      if(@$startFrom == 0) $startFrom++;
		?>
			<a href="<?=site_url("user/orders/".($startFrom+$resultsPer))?>">Forward</a>
		<?php endif;?>
		</td>
	</tr>
</table>		
<?php else:?>
<div class="message checkpoint">
	<p>You have been sent payment instructions for all essays you've marked.</p>
</div>
<?php endif;?>
<form action="" method="post">
	<?php
	$thirdVar = '';
	if($numScripts===0) $thirdVar = 'disabled="true"';?>
	<?=form_submit('getPaid','Get paid',$thirdVar);?>
</form>
<p class="minor">Click the payment request above below to get paid. We will then send a instant payment to the email address you use to sign in. The email will provide instructions on how to transfer the money into your bank account from our secure payment partner, PayPal.</p>


