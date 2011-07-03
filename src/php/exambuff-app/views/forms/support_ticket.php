<?php
$this->load->helper('form');
?>

<h2>Submit a support ticket</h2>
<p>Required fields are <b>bold</b>.</p>
<?php
is_array(@$errors) ? $errors : $errors = array();
$errors = $errors + $this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));?>
<form method="POST" action="<?=$formAction?>">
	<?=eb_input_text('subject','What\'s up?',array('class'=>'required'))?>
	<?=eb_input_textarea('message','Detail the situation',array('class'=>'required'))?>
	<?=eb_hidden('token',$token)?>
	<?=eb_submit('submit')?>
</form>