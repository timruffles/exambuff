</div><?php //end #page here ?>
<div class="footer">
		<ul class="seo">
			<?php 
			$i=0;			
			foreach($this->config->item('footer_pages') as $page => $link) :
				$i++;
				if($i==1):
					$spacer = '';
				else:
					$spacer = '&nbsp;::&nbsp;';
				endif;
			?>
			<li><?=$spacer?><a class="menuitem" href="<?=site_url($link)?>"><?=$page?></a></li>
			<?php endforeach; ?>
		</ul>
		<div class="copyright">exambuff, copyright 2008</div>
	</div>
</div>
<?php if(base_url()==='http://exambuff.co.uk'):?> 
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7092302-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<?php endif;?>
</body>
</html>