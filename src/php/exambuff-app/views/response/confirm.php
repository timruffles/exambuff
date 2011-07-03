<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Takes viewData['confirmationIntro'...'confirmationTitle'...'confirmURL'...'cancelURL'...'confirmLabel'...'cancelLabel'
 * 
 * Asks question of user, and displays a confirm and cancel link
 */
?>
<h2><?=$confirmationTitle;?></h2>
<p><?=$confirmationIntro;?></p>
<a href="<?=app_base();?><?=$confirmURL;?>"><?=$confirmLabel;?></a><a href="<?=app_base();?><?=$cancelURL;?>"><?=$cancelLabel;?></a>