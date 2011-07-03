<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->lang->load('usermanagment');
$this->load->helper('language');
$this->load->helper('form');
?>
<h2>Welcome to Exambuff</h2>
<?php if(@$signedUp):?>
<div class="message checkpoint">
	<p>Hi <?=$name?>, thanks for signing up. We thought you might like some pointers to get you ready to buff up your exam technique.</p>
	<p>Across the top of the page you can see various tabs. Clicking the tabs will allow you to:</p>
	<ul>
		<li>Home – navigate to the front page</li>
		<li>Upload – upload an exam essay for our tutors to review and use to provide you with a improvement plan</li>
		<li>View feedback – view the comments our tutors leave on your uploaded text, and read your improvement plans and targets</li>
		<li>Logout – logs out of Exambuff</li>
		<li>My account – change your password</li>
	</ul>
<p>Our PhD student tutors are ready to help you buff up your exam skills. Just click 'upload' when you're ready to begin</p>
</div>
<?php else:?>
<?php 
if(!@$errors) $errors = array();
$errors = $errors + $this->validation->_error_array;
$this->load->view('chunks/messages',array('errors'=>@$errors,'messages'=>@$messages,'checkpoints'=>@$checkpoints));?>
<?php endif;?>
<div class="left split">
	<table class="info">
<thead>
	<tr><th>About you</th></tr>
</thead>
<tbody>
		<tr>
			<th>Name:</th>
			<td>
				<?=$name?>
			</td>
		</tr>
		<tr>
			<th>Email:</th>
			<td>
			<?php if($email):?>
			<?=$email?>
			<?php else:?>
			Facebook email <?=$fbEmail? 'enabled' : 'disabled'?>
			<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>Institution:</th>
			<td><?=@$institution ? $institution : 'You haven\'t told us'?></td>
		</tr>
		<tr>
		<th>Subject of study:</th>
			<td><?=@$subject;?></td>
		</tr>
	</tbody>
	</table>
</div>

<div class="right split">
	<?php $this->load->view('forms/change_password',array('formAction'=>'user','token'=>$token))?>
</div>
<p id="referral"><a href="<?=site_url('user/refer')?>">Refer your friends and get £2 for each that signs up</a></p>
<p class="nextStep">Do you want to: <a href="<?=site_url('user/upload')?>">Upload an essay?</a><?php 
								  ?></p>