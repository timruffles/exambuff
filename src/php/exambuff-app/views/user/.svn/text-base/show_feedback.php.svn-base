<?php
$types = array('STYLE'=>'Style','ARGUMENT'=>'Argument','INTRO'=>'Introduction and Conclusion','EVIDENCE'=>'Evidence','PLANNING'=>'Planning');
?>
<h2>Feedback</h2>
<table class="feedback">
	<tr>
		<th>Question:</th>
		<td><?=$question?></td>
	</tr>
	<tr>
		<th>Targets:</th>
		<td>
			<table class="data">
				<tr><th class="skill">Specific skill</th><th>Target</th></tr>
				<?php foreach($targets as $target): ?>
					<tr><td class="type"><?=$types[$target->type]?></td><td class="text lastCol"><?=$target->text?></td></tr>
				<?php endforeach; ?>
			</table>
		</td>
	</tr>
	<tr>
		<th>Improvement plan:</th>
		<td><?=$generalComment?></td>
	</tr>
</table>
<p class="nextStep">Don't forget to <a href="<?=site_url('user/scripts/viewfeedback/'.$scriptID.'/'.$pages)?>">read the inline comments</a> your tutor has made about your essay's text.</p>