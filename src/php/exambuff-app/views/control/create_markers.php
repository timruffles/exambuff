<?php $this->load->helper('form');?>
<h2>Create new markers</h2>
<?php $this->load->view('chunks/messages',array('messages'=>@$messages,'checkpoints'=>@$checkpoints,'errors'=>@$errors))?>
<form action="<?=site_url('control/control/createmarkers');?>" method="post">
	<?=eb_input_textarea('emails','Emails of markers, seperated by commas')?>
	<?=eb_hidden('token',$token)?>
	<?=eb_submit('submit','',array('value'=>'Create markers'))?>
</form>
