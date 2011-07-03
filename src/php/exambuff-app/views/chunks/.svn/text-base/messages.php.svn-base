<?php
if(@$messages && !is_array($messages)) $messages = array($messages);
if(@$checkpoints && !is_array($checkpoints)) $checkpoints = array($checkpoints);
if(@$errors && !is_array($errors)) $errors = array($errors);
if(!function_exists('outputMsg')) {
	function outputMsg($msgString) {
		if(substr($msgString,0,3)=='<p>') $hasP = true;
		if(!@$hasP) echo '<p>';
		echo $msgString;
		if(!@$hasP) echo '</p>';
	}
}
if(!empty($messages)): ?>
<div class="message info">
<?php foreach($messages as $message) :?>
<?php 	outputMsg($message);?>
<?php endforeach;?>
</div>
<?php endif; ?>

<?php if(!empty($errors)): ?>
<div class="message error">
<?php foreach($errors as $error): ?>
<?php 	outputMsg($error);?>
<?php endforeach;?>
</div>
<?php endif; ?>

<?php if(!empty($checkpoints)): ?>
<div class="message checkpoint">
<?php foreach($checkpoints as $checkpoint): ?>
<?php 	outputMsg($checkpoint);?>
<?php endforeach; ?>
</div>
<?php endif; ?>