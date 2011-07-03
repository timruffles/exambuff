<?php
/**
 * Takes a number of arrays, in array(array($label, $url),arra...) format
 */
function eb_progress_bar($steps,$current = 'none') {
	$stepNum = count($steps);
	$i = 0;
	?>
	<table class="progressBar"><tr>
	<?php foreach($steps as $stepName => $step):		
			@$status = $step[2];			
			// use status for both the class of the element, and the switch statement below
			if($stepName == $current) {
				$oldStat = $status;
				$status .= ' current';
			}			
			$i++;?>
		<td style="width:<?php echo round(98.5/$stepNum,1)?>%" <?php if($status!='') {echo "class=\"$status\" ";}?>>
		<?php  switch($status):
				case 'complete':
				case 'active';
				case '':?>				
					<a href="<?php echo $step[1]?>" <?php if($status!='') { echo "class=\"$status\" ";}?>>
						<?php echo $i.' '.$step[0]?>
					</a>
				<?php 
				break;
				case @$oldStat.' current':?>
					<span class="current"><?php echo $i.' '.$step[0]?></span>
				<?php 
				break;
				case 'disabled':
				default:?>
					<span class="url"><?php echo $step[1]?></span><span><?php echo $i.' '.$step[0]?></span>
				<?php 
				break;	?>		
		<?php endswitch;?>	
		</td>
	<?php endforeach;?>
	</tr></table>
	<?php 
}