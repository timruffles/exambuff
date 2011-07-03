<?php 
if(@!isset($ssl)) $ssl = false;
$ssl ? $baseURL = base_url_ssl() : $baseURL = base_url() ;
$ssl ? $style = $baseURL.'css/sslStyle.css?v='.$this->config->item('cssVer') : $style = $baseURL.'css/style.css?v='.$this->config->item('cssVer');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
<title><?=@$title? $title.' - Exambuff' : 'Exambuff - Polish up your skills. Polish off your exams';?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link type="text/css" rel="stylesheet" href="<?=$style?>" />
<?php if(isset($js)): ?>
<?php foreach($this->config->item('autoload_js') as $script): ?>
	<script type="text/javascript" src="<?=$baseURL."js/$script.js"?>"></script>
<?php endforeach; ?>
<?php is_array($js) ? $js : $js = array($js); ?>
<?php foreach($js as $script): ?>
	<script type="text/javascript" src="<?=$baseURL?>js/<?=$script?>.js?v=<?=$this->config->item('js_version');?>"></script>
<?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript" >var base_url = '<?=app_base();?>'</script>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<!--[if lte IE 6]>
<style type="text/css">@import "<?=$baseURL?>css/ie-fix.css?v=<?=$this->config->item('cssVer')?>";</style> 
<![endif]-->
</head>