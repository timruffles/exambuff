<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->lang->load('usermanagment');
$this->load->helper('language');
$this->load->helper('form');
if($assessment && !$marker->isTutor()) $checkpoints[] = 'You have submitted your tutor assessment. We should have reviewed it by tomorrow.';
?>
<h2>Exambuff tutor account</h2>
<?php if(@!$errors) $errors = array();?>
<?php @$errors = $errors +$this->validation->_error_array;?>
<?php $this->load->view('chunks/messages',array('errors'=>@$errors,'checkpoints'=>@$checkpoints,'messages'=>@$messages));?>
<?php if(!$marker->isTutor() && !$assessment || !$marker->isPhD()):?>
	<h3>Things to do:</h3>
	<div class="todoLinks">
		<?php if(!$marker->isTutor()):?>
			<p><b>Take our tutor assessment (<a class="inline" href="<?=site_url('marker/info/assessment')?>">why?</a>):</b> <a href="<?=site_url('marker/assessment/takeassessment')?>">Try out our tutoring application, and submit your feedback to be assessed</a></p>
		<?php endif;?>
		<?php if(!$marker->isPhD()):?>
			
			<p><b>Confirm your PhD status (<a class="inline" href="<?=site_url('marker/info/confirmphd')?>">why?</a>):</b> <a href="<?=site_url('marker/confirmphd')?>">Confirm your PhD status</a></p>
		<?php endif;?>
	</div>
<?php endif;?>
<?php if($assessmentFix && !$assessment):?>
<div class="message info">
	<p>Have you submitted an assessment already? If so, there should not be a message asking you to 'Take our assessment', and your 'Tutor status' should either be 'Full tutor' or 'Being reviewed'.</p>
	<p><b>Have you submitted an assessment and are experiencing the problem above?</b></p>
	<form method="POST" action="">
		<?=eb_radio('requireFix','Yes','yes')?>
		<?=eb_radio('requireFix','No','no')?>
		<?=eb_hidden('token',$token)?>
		<?=eb_submit('assessmentFix')?>
	</form>
</div>
<?php endif;?>
<div class="left split">
	<table class="info">
<thead>
	<tr><th>About you</th></tr>
</thead>
<tbody>

		<tr>
			<th>Name:</th>
			<td><?=@$marker->get('name')?></td>
		</tr>
		<tr>
			<th>Email:</th>
			<td><?=@$marker->get('email')?></td>
		</tr>
		<tr>
			<th>Institution:</th>
			<td><?=@$marker->get('institution')? $marker->get('institution') : 'You haven\'t told us'?></td>
		</tr>
		<tr>
		<th>Subject of study:</th>
			<td><?=@$marker->get('subject') ? $marker->get('subject') : 'You haven\'t told us';?></td>
		</tr>
		<tr>
			<th>Tutor status:</th>
			<td><?php if($marker->isTutor()) :?>
					<p class="yes">Full tutor</p>
				<?php else:?>
					<?php if($assessment) :?>
						<p class="yes">Being reviewed</p>
					<?php else:?>
						<p class="no"><a class="inline" href="<?=site_url('marker/info/assessment')?>">Pass assessment</a></p>
					<?php endif;?>
				<?php endif;?>
			</td>
		</tr>
		<tr>
			<th>PhD status:</th>
			<td><?=$marker->isPhD()? '<p class="yes">PhD status confirmed' : '<p class="no"><a class="inline" href="'.site_url('marker/info/confirmphd').'">Confirm your PhD status</a>';?></p></outd>
		</tr>
	</tbody>
	</table>
	<table class="info">
		<thead>
			<tr>
				<th>Change password</th>
			</tr>
		</thead>
	</table>
	<?php $this->load->view('forms/change_password',array('formAction'=>'marker','token'=>$token))?>
</div>
<div class="right split">
<form action="" method="POST" class="save">
	<table class="info">
	<thead>
		<tr><th>Job update preferences</th></tr>
	</thead>
	<tbody>
	<?php 
	$alertThreshold = $this->validation->alertThreshold ? $this->validation->alertThreshold : @$markerPref->get('alertThreshold');
	$alertSubjects = $this->validation->alertSubjects ? $this->validation->alertSubjects : @$markerPref->get('alertSubjects');
	$alertMax = $this->validation->alertMax ? $this->validation->alertMax : @$markerPref->get('alertMax');
	$jobMin = $this->validation->jobMin ? $this->validation->jobMin : @$markerPref->get('jobMin');
	
	$markerHH = substr($markerPref->get('alertTime'),0,2);
	$markerMM = substr($markerPref->get('alertTime'),2,2);
	
	$alertSubjects = $this->validation->alertSubjects ? $this->validation->alertSubjects : @$markerPref->get('alertSubjects');
	
	$alertTimeHH = $this->validation->alertTimeHH ? $this->validation->alertTimeHH : $markerHH;
	$alertTimeMM = $this->validation->alertTimeMM ? $this->validation->alertTimeMM : $markerMM;
	?>
	 	<tr>
			<th>Send me an email when there are X jobs that meet my criteria:</th>
			<td><?=form_input(array('name'=>'alertThreshold','value'=>$alertThreshold,'size'=>2,'maxlength'=>2))?>&nbsp;jobs</td>
		</tr>
		<tr>
			<th>I only want to know about jobs on these subjects (ctrl for multiple):</th>
			<?php 
			// change 'Please select...' to 'Any', by removing the first value and adding any
			$subjectsOpt = $this->config->item('subjects');
			array_shift($subjectsOpt);
			$subjectsOpt = array('any'=>'Any') + $subjectsOpt;
			// if $alertSubjects is too short, pad with a empty selection to ensure CI makes a multiple select
			// if $alertSubjects is blank, then markerPref will be blank, and all subjs will be emailed, so pick any
			is_array($alertSubjects) ? $alertSubjects : $alertSubjects = array($alertSubjects);
			if(count($alertSubjects)===0) $alertSubjects = array('any','') + $alertSubjects;
			if(count($alertSubjects)===1) $alertSubjects[] = '';
			?>
			<td><?=form_dropdown('alertSubjects[]',$subjectsOpt,$alertSubjects)?></td>
		</tr>
		<tr>
			<th>Send me a maximum of X emails a week:</th>
			<td><?=form_input(array('name'=>'alertMax','value'=>$alertMax,'size'=>2,'maxlength'=>2))?>&nbsp;emails</td>
		</tr>
		<tr>
			<th>I want to be emailed with information on a minimum of X jobs a week:</th>
			<td><?=form_input(array('name'=>'jobMin','value'=>$jobMin,'size'=>2,'maxlength'=>2))?>&nbsp;emails</td>
		</tr>
		<tr>
			<th>Send me job emails at this time (24h HH MM):</th>
			<td><?=form_input(array('name'=>'alertTimeHH','value'=>@$alertTimeHH,'size'=>2,'maxlength'=>2))?><?php
				?>. <?=form_input(array('name'=>'alertTimeMM','value'=>@$alertTimeMM,'size'=>2,'maxlength'=>2))?></td>
		</tr>
		<tr>
		<?=form_submit(array('name'=>$updatePref,'value'=>'Save','class'=>'save'));?>
	</tbody>
	</table>
</form>
</div>
<div style="clear:both"></div>