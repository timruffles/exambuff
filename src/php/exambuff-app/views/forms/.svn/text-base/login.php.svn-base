<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->lang->load('loginform');
$this->load->helper('form');
?>
<h2>Login</h2>
<?php 
is_array(@$errors) ? $errors : $errors = array();
$errors = $errors + $this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));
$forgottenSublabel = "<a href=\"$forgottenPassword\">Forgotten password?</a>";
?>
<form method="post" action="<?=$formAction?>">
	<?php eb_input_text('email','Email',array('value'=>@$this->validation->email,'class'=>'required')) ?>
	<?php eb_input_password('password','Password',array('class'=>'required','sublabel'=>$forgottenSublabel)) ?>
	<?php eb_hidden('token',$token) ?>
	<?php eb_submit(); ?>
</form>