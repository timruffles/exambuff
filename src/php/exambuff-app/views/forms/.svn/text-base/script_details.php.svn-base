<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * View to collect details about user's script
 *
 *
 */
$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('language');
$this->load->helper('progressor');
?>
<h2>Submit essay</h2>
<?= eb_progress_bar($progressSteps,'details') ?>
<h3>Enter details of your essay</h3>
<?php 
if($this->validation->error_string!='')$errors[] = $this->validation->error_string;
$this->load->view('chunks/messages_ajax',array('errors'=>@$errors));?>
<form action="<?=$formAction;?>" method="POST">
<?= eb_select('subject','Subject area of essay',$this->config->item('subjects'),array('value'=>$extantData['subject'])) ?>
<?= eb_input_textarea('question','Question',array('value'=>$extantData['question'])) ?>
<?= eb_submit(); ?>
</form>
<?php
/*

<form action="<?=$formAction;?>" method="POST">
	<span class="field">
		<label for="question"><?=lang('question');?>:</label>
		<textarea rows="3" cols="40" name="question">
			<?php if(!empty($extantData['question'])) { echo $extantData['question']; }else { echo $this->validation->question; }?>
		</textarea>
	</span>
	<span class="field">
		<label for="subject"><?=lang('subject');?>:</label>
		<input type="text" name="subject" value="<?php if(!empty($extantData['subject'])) { echo $extantData['subject']; }else { echo $this->validation->subject; }?>"/>
	</span>
	<div class="rightButtons"><input type="submit" value="<?=lang('submit');?>" /></span></div>
</form>
*/
?>
