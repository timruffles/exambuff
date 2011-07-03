<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper('form');
$forgottenPasswordURL = site_url('user/login/forgottenpassword');
$forgottenSublabel = "<a href=\"$forgottenPasswordURL\">Forgotten password?</a>";
?>
<h2>Sign up or login</h2>
<p>Sign up or login below. All required fields are <b>bold</b>.</p>
<div id="errorMessages">
<?php 
is_array(@$errors) ? $errors : $errors = array();
$errors = $errors +$this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));?>
</div>
<div class="left split content">

	<h3>New users</h3>
<form method="POST" action="<?=site_url('user/signup',true)?>">
	<fieldset>
		<?php eb_input_text('name','Your name',array('value'=>$this->validation->name,'class'=>'required')) ?>
		<?php eb_input_text('email','Your email address',array('value'=>$this->validation->email,'class'=>'required')) ?>
	</fieldset>
	<fieldset>
		<?php eb_input_password('password','Password',array('class'=>'required')) ?>
		<?php eb_input_password('repeatPassword','Repeat password',array('class'=>'required')) ?>
	</fieldset>
		<fieldset>
		<?php eb_select('subject','Subject area of study',array(''=>'Please select...','Humanities'=>'Humanities','Social Sciences'=>'Social Sciences','Business'=>'Business','Literature'=>'Literature','Languages'=>'Languages','Media'=>'Media','Law'=>'Law','Education'=>'Education','Science'=>'Science','Maths'=>'Maths','Computer Science'=>'Computer Science','Engineering'=>'Engineering'),array('value'=>$this->validation->subject)) ?>
		<?php eb_input_text('institution','Institution of study',array('value'=>$this->validation->institution)) ?>
	</fieldset>
	<fieldset>
		<?php eb_hidden('token',$token) ?>
		<?php eb_submit(); ?>
	</fieldset>
</form>
</div>
<div class="right split content">
	<h3>Existing users</h3>
	<form method="POST" action="<?=site_url('user/login',true)?>">
		<?php eb_input_text('email','Email',array('class'=>'required'));?>
		<?php eb_input_password('password','Password',array('class'=>'required','sublabel'=>$forgottenSublabel)) ?>
		<?php eb_hidden('token',$token);?>
		<?php eb_submit('submit','',array('value'=>'Login','class'=>'button'));?>
	</form>
</div>