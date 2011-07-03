<?php
$this->load->helper('form');
$marker->isPhD() ? $phd = true : $phd = false;
?>
<?php if($phd):?>
<h2>You have confirmed your PhD status</h2>
<div class="messages">
	<p>You have already confirmed your PhD status</p>
</div>
<?php else:?>
<h2>Confirm your PhD status</h2>
<p>To being tutoring you will need to state your current PhD status and give us permission to contact your university to confirm your study there.</p>
<p>You will be able to being marking as soon as you submit one of these forms of identity and accept the statement confirming that you are a current PhD student.</p>
<?php
if(@!$errors) $errors = array();
@$errors = $errors +$this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));?>
	<form method="POST">
		<fieldset>
			<?php eb_input_text('studentNum','Student number');?>
			<?php eb_input_text('uniPermission','Type your name here to give Exambuff permission to contact your university to confirm your PhD status');?>
		</fieldset>
		<?php eb_checkbox('accept','I accept the statment below, which confirms my PhD status',false,array('value'=>'accepted'));?>
		<span class="field">
			<p style="font-size:0.8em;padding:2em">I am a current PhD student at a British university, or I hold a PhD or equivalent from a British university.</p>
		</span>
		<?php eb_submit();?>
	</form>
<?php endif;?>
