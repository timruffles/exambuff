<?php $this->load->helper('form')?>
<h2>Forgotten password - reset your password</h2>
<p>Please enter your account email. An email will be sent to your account with a link you can visit to have a new password emailed to you.</p>
<p>Once you've got your new password, use the change password feature in your 'my account' page to change it to something more memorable.</p>
<?php 
is_array(@$errors) ? $errors : $errors = array();
$errors = $errors + $this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));?>
<form action="<?=site_url($formAction)?>" method="POST">
	<?php eb_input_text('email','Your email',array('class'=>'required'))?>
	<?php eb_hidden('token',$token) ?>
	<?php eb_submit('resetPass',false,array('value'=>'Send reset request'))?>
</form>