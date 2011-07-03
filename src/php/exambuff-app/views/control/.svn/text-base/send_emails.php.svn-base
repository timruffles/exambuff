<?php $this->load->helper('form')?>
<table>
<tr>
	<th>ID</th>
	<th>Sender</th>
	<th>Receiver</th>
	<th>Subject</th>
	<th>Message</th>
</tr>
<?php $i = 0;?>
<?php foreach($emails as $email):?>
<?php $i++ % 2 == 0 ? $color = '#eee' : $color = '#fff';?>
<tr style="background:<?=$color?>">
	<td><?=$email['ID']?></td>
	<td><?=$email['sender']?></td>
	<td><?=$email['receiver']?></td>
	<td><?=$email['subject']?></td>
	<td><?=$email['message']?></td>
</tr>
<?php endforeach;?>
</table>
<form method="POST" action="<?=site_url('control/control/sendemails')?>">
	<?= eb_submit('submit',null,array('value'=>'Send emails'))?>
</form>