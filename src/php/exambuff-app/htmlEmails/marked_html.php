<style>body{padding:0;margin:0}div.wrap{background-color:#FFFFF3;font-family:Tahoma,Geneva,Verdana,sans serif}table,tr,th,td{border-collapse:collapse;border-spacing:0;background-color:#fff}table.main{border:1px #9A9997 solid;margin:8px 0 0 8px}table.main a{color:#0A8FD4;text-decoration:none}table.main a:hover{color:#0A8FD4;text-decoration:underline}a img{border:0;}table.main a:visited{color:#A2427C}table.main td{padding:4px 8px;margin:0;border:0 0 0 0;border-right:1px solid #FBD3A4}table.main td.major,table.main td.rowEnd{border-right:0px}table.main th{text-align:left;padding:6px;margin:0;border-bottom:1px solid #FBD3A4;border-top:1px solid #FB9924;border-right:0px;border-left:0px;border-style:solid none}table.main tr.bigTitle th{border-bottom:0;border-top:0;padding:4px 0px 4px 0px;font-size:18px;color:#574D34}table.main td.generalComment{border-bottom:1px solid #FBD3A4;border-top:1px solid #FB9924;border-right:0px}table.main td.border{padding:30px 0px 30px 15px;border-right:0px}table.feedback{margin:8px 0px 16px 0px;width:90%}table.main p.lastLine{margin-bottom:8px}div.wrap p.legal{font-size:10px;line-height:11px;margin:4px 8px;color:#9A9997}</style><div class="wrap"><table class="main" width="600px"><tr><td class="border"><table><tr><td class="major" colspan="3"><a href="http://exambuff.co.uk"><img src="http://exambuff.co.uk/img/email_logo.gif" alt="Exambuff logo" /></a></td></tr>
			<tr>
				<td class="major">
				<p>Hi,</p>
				<p>Your essay has been read by one of our tutors, and they've provided the following feedback:</p>
				</td>
			</tr>
			<tr>
				<td class="major" align="center">
				<table class="feedback">
					<tr class="bigTitle">
						<th colspan="3">Targets</th>
					</tr>
					<tr>
						<th width="10%">&nbsp;</th>
						<th width="30%">Specific skill</th>
						<th width="60%">Target</th>
					</tr>
					<?php $i= 0;?>
					<?php foreach($targets as $target):?>
					<?php $i++;?>
					<tr>
						<td>#<?=$i?></td>
						<td><?=$target['type']?></td>
						<td class="rowEnd"><?=$target['text']?></td>
					</tr>
					<?php endforeach;?>
					<tr class="bigTitle">
						<th colspan="3" align="left">Improvement plan</th>
					</tr>
					<tr>
						<td colspan="3" class="generalComment"><?=$generalComment?></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td class="major">
				<p>Don't forget to read the <b>detailed, inline comments</b> on
				your <a href="<?=$viewURL?>">actual text</a>. You can also do this by <a href="<?=site_url('/user/login')?>">logging
				in</a> to your Exambuff account and clicking the 'feedback' tab.</p>
				<p>Warm regards,</p>
				<p class="lastLine">the Exambuff team.</p>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<p class="legal">Exambuff Ltd, UK reg. company 06743711.</p>