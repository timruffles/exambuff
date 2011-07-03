<?php
function withCaption($imgFile,$caption) {
$imgFile = $imgFile;
$imgInfo = getimagesize($imgFile);

?>
<img src="<?php echo $imgFile?>" <?php echo $imgInfo[3]?> />
<p style="width:<?php echo $imgInfo[0]-4?>px"><?php echo $caption?></p> 
<?php 
}
function captionLink($imgFile,$caption,$link) {
$imgFile = $imgFile;
$imgInfo = getimagesize($imgFile);
?>
<div class="img" style="width:<?php echo $imgInfo[0]?>px;">
<a href="<?php echo $link?>"><img src="<?php echo $imgFile?>" <?php echo $imgInfo[3]?> /></a>
<p style="width:<?php echo $imgInfo[0]-4?>px"><?php echo $caption?></p> 
</div>
<?php 
}