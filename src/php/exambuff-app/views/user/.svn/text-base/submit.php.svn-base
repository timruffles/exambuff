<?php
$this->load->helper('progressor');
$this->load->helper('form'); ?>
<h2>Submit Answer</h2>
<?= eb_progress_bar($progressSteps) ?>
<h3>Confirm Answer & Submit</h3>
<h4>Pages</h4>
<ol id="pagesAdded">
	<?php
	if(@is_array($pagesPresent)) :

		$i= 0;
		foreach($pagesPresent as $page) :
			if($page) {
			?>
		<li><?=$page?></li>
	<?php
			}
	endforeach; ?>
	<?php endif; ?>
</ol>
<h4>Answer Details</h4>
<dl>
	<dt>Subject</dt>
	<dd><?=$extantData['subject']?></dd>
  <dt>Question</dt>
  <dd><?=$extantData['question']?></dd>
</dl>
<form method="POST">
	<?= eb_submit() ?>
</form>
