<h2>Success!</h2>
<?php $this->load->view('chunks/messages'); ?>
	<p>
		<?php if(isset($firstName))echo $firstName; ?>
		<?php if(isset($message))echo $message; ?>
	</p>