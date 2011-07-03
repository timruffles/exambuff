<?php $this->load->helper('fb')?>
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
<?php if($this->facebook->get_loggedin_user()):?>
	<?php $this->facebook->get_loggedin_user() ? $fbPanelClass = 'in' : $fbPanelClass = 'out';?>
	<div id="fbPanel" class="<?=$fbPanelClass?>">
		<div class="pic"><img src="<?=fbProfilePic($this->facebook->get_loggedin_user())?>" /></div>
		<p class="name">Welcome to Exambuff <a href="http://www.facebook.com/profile.php?id=<?=$this->facebook->get_loggedin_user()?>" class="FB_Link"><?=fbName($this->facebook->get_loggedin_user())?></a></fb:name></p>
		<p class=""><a href="">Account Settings</a> | <a id="fbLogout" href="">Logout</a>
	</div>
<?php endif;?>
<script type="text/javascript"
src="http://www.google.com/jsapi?key=ABCDEFG"></script>
<script type="text/javascript">
google.load("jquery", "1.3.1");
</script>
<script type="text/javascript">
	function showFBStatus(string) {
		$('#fbPanel').css('display','block');
		var m = $('#front-main');
		var oldHtml = $('#front-main').html();
		m.data('oldHtml',oldHtml);
		m.html('<h3>Welcome to Exambuff</h3><p>Thanks for logging in with Facebook Connect.');
	}
	function hideFBStatus(string) {
		$('#fbPanel').css('display','none');
		var m = $('#front-main');
		$('#front-main').html(m.data("oldHtml"));
	}
	function refreshXFBML() {
		FB.XFBML.Host.refresh();
	}
$(function(){
	$('#fbLogout').click(function(){
		FB.Connect.logout();
		hideFBStatus();
		return false;
	});	
	$('#logout-tab').click(function(){
		FB.Connect.logout();
		hideFBStatus();
	});	
});
	function redirect() {
		window.location = '<?=site_url('/user')?>';
	}

//alert('fine');
</script>
<script type="text/javascript">
	FB_RequireFeatures(["XFBML"], function() { 
			FB.Facebook.init("<?=$this->config->item('fbApi')?>", "<?=base_url()?>receiver.htm",
					{"ifUserConnected" : showFBStatus});
			<?php if(!$this->facebook->get_loggedin_user()):?>
				FB.Facebook.get_sessionState().waitUntilReady(function() { 
					var s = FB.Connect.get_status();
					if(s=1) {
						showFBStatus();
					} else {
						s.add_changed(redirect());
					}
				}); 
			<?php endif;?>
		}
	);
//alert('loaded');
</script> 
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
