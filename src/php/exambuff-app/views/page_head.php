<body <?php if(@$bodyId) echo 'id="body-'.str_replace(" ","-",$bodyId).'"';?>>
<div id="main">
	<div id="header">
		<h1 ><a id="site-title" href="http://www.exambuff.co.uk">Exambuff Exam Skills Tuition</a></h1>
		<div class="tabs">
			<ul>
			<?php
			// 
			if(!@$userAuth && !@$markerAuth) {
				$pages = $this->config->item('site_pages');
			} else 
			if(@$userAuth) {
				$pages = $this->config->item('user_pages'); 		
			} else 
			if(@$markerAuth) {
				$pages = $this->config->item('marker_pages'); 				
			}
			$i=0;
			foreach($pages as $page => $link) :
				$i++;
				$page =='your account' ? $id =  'id="account"' : $id = 'id="'.str_replace(array(' ','/'),"-",$page).'-tab"';
			?>
	<li><a class="menuitem <?php if($i==1) echo 'account';?>" <?=$id?> href="<?=site_url($link)?>"><?=$page?></a></li>
			<?php endforeach; ?>
</ul>
		</div>
	</div>
	<div id="page">