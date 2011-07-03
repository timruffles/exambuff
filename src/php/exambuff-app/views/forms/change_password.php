<form method="post" action="<?=$formAction?>">
	<?php eb_input_password('currentPassword','Current password',array('class'=>'required'))?>
	<?php eb_input_password('newPassword','New password',array('class'=>'required'))?>
	<?php eb_input_password('newPasswordRepeat','Repeat new password',array('class'=>'required'))?>
	<?php eb_hidden('token',$token) ?>
	<?php eb_submit('changePassword',false,array('value'=>'Change password')); ?>
</form>