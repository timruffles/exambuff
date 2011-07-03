<div class="right split">
<table class="info">
<thead>
	<tr><th>Your preferences</th></tr>
</thead>
<tbody>
<form action="<?=site_url('user/userpanel/update')?>" method="POST">
 	<tr><th class="subhead">I want to receive emails about:</th></tr>
 	<tr>
		<th>Purchases I've made (receipts)?</th>
		<td><?=form_label('Yes please','receipts')?><?=form_checkbox('receipts','Yes',true,array('checked'=>TRUE))?></td>
	</tr>
	<tr>
		<th>Exambuff offers?</th>
		<td><?=form_label('Yes please','receipts')?><?=form_checkbox('receipts','Yes',true,array('checked'=>TRUE))?></td>
	</tr>
	<tr>
		<th>Recruiters?</th>
		<td><?=form_label('Yes please','receipts')?><?=form_checkbox('receipts','Yes',true,array('checked'=>TRUE))?></td>
	</tr>
	<tr>
</form>
</tbody>
</table>
</div>