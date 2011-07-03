<?php
if(!function_exists('outputMsg')) {
	function outputMsg($msgString) {
		if(substr($msgString,0,3)=='<p>') $hasP = true;
		if(!@$hasP) echo '<p>';
		echo $msgString;
		if(!@$hasP) echo '</p>';
	}
}?>
<div class="message info<?php if(empty($messages)) echo ' no-messages';?> ">
<?php if(!empty($messages)): ?>
<?php foreach($messages as $message): ?>
<?php 	outputMsg($message);?>
<?php endforeach;?>
<?php endif; ?>
</div>
<div class="message error<?php if(empty($errors)) echo ' no-messages';?>">
<?php if(!empty($errors)): ?>
<?php foreach($errors as $error): ?>
<?php 	outputMsg($error);?>
<?php endforeach;?>
<?php endif; ?>
</div>
<div class="message checkpoint<?php if(empty($checkpoints)) echo ' no-messages';?>">
<?php if(!empty($checkpoints)): ?>
<?php foreach($checkpoints as $checkpoint): ?>
<?php 	outputMsg($checkpoint);?>
<?php endforeach; ?>
<?php endif; ?>
</div>
