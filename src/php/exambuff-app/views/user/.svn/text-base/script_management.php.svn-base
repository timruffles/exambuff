<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper('url');
$this->load->helper('language');
$this->lang->load('scriptmanagement');
$this->load->helper('friendly');

$statusMessages['active'] = 'Not uploaded.';
$statusMessages['paid'] = 'Awaiting marking';
$statusMessages['marked'] = 'Marked';
$statusMessages['marking'] = 'Currently being marked';

?>
<h2>Feedback for your answers</h2>
<?php 
$this->load->view('chunks/messages',array('messages'=>@$messages))?>
<?php		
	define('ZEBRA','zebra');	
	$numScripts = count($scripts);
	if($numScripts!=0):?>
<table id="scripts" class="data">
	<tr>
		<th>Question</th>
		<th>Last changed</th>
		<th>Status</th>
		<th>Action</th>
	</tr>
<?php 
		for($i=0;$i<$numScripts;$i++):	
			$rowOdd = $i % 2;
			$rowOdd ? $rowClass = ZEBRA : $rowClass = '';
			?>
	<tr class="<?=$rowClass?>">
		<td class="question"><?=$scripts[$i]['question'];?></td>
		<td class "changed"><?=ucfirst(friendly_date(strtotime($scripts[$i]['updated'])));?></td>
		<td class="status">
			<?=$statusMessages[$scripts[$i]['status']];?>
		</td>
		<td class="action">	
			<?php 
			$scriptID = $scripts[$i]['ID'];
			$pages = count(explode('|',$scripts[$i]['pageKeys']));
			?>
			<?php switch ($scripts[$i]['status']) :
				      case 'marked': ?>
						<a class="targetLink" href="<?=site_url('user/scripts/viewtargets/'.$scriptID.'/'.$pages)?>">Targets</a> <a class="viewLink" href="<?=site_url('user/scripts/viewfeedback/'.$scriptID.'/'.$pages)?>">Comments</a>
				<?php break; ?>
				<?php case 'active': ?>
						<a href="<?=site_url('user/upload')?>">Finish uploading</a>
				<?php break; ?>	
			<?php endswitch; ?>
		</td>
	</tr>				
<?php 	endfor;?>
	<tr class="pageate">
		<td colspan="2" class="back">
		<?php 
		// don't want to link back to 1, remainder created by if we click back to starting page by additional 1
			  if(@$startFrom && @$startFrom > $resultsPer): 
			  	 $startFrom == $resultsPer + 1 ? $backNum = '' : $backNum = $startFrom-$resultsPer;
			  ?>
			 
			<a href="<?=site_url("user/orders/$backNum")?>">Back</a>
		<?php endif;?>
		</td>
		<td colspan="2" class="forward">
		<?php if(@$pageate):
			  // need to start off increase by one
		      if(@$startFrom == 0) $startFrom++;
		?>
			<a href="<?=site_url("user/orders/".($startFrom+$resultsPer))?>">Forward</a>
		<?php endif;?>
		</td>
	</tr>
</table>		
<?php 
	else:?>
<div class="message info">
	<p>You have not had any scripts marked yet.</p>
</div>
<?php 
	endif;?>
<p class="nextStep">Do you want to: <a href="<?=site_url('user/upload')?>">Upload answers?</a><?php 
								  ?></p>