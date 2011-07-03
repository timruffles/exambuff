<?php $this->load->helper('form');?>
<h2>Exambuff referral scheme</h2>
<p>Refer your friends and we'll pay you <b>£2.00</b> for everyone who signs up and makes a purchase.</p>
<?php $this->load->view('chunks/messages',array('messages'=>@$messages,'checkpoints'=>@$checkpoints,'errors'=>@$errors))?>
<form action="<?=site_url('user/refer');?>" method="post">
	<?=eb_input_textarea('emails','Emails to refer, seperated by commas')?>
	<?=eb_hidden('token',$token)?>
	<?=eb_submit('submit','',array('value'=>'Refer friends'))?>
</form>
<p class="minor">Please ensure you only refer your friends - if you refer strangers and they complain we will take action, and you won't be paid.</p>