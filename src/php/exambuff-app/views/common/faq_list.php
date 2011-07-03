<h2><?php if(!@$title) echo 'Faq'; else echo $title?></h2>
<ul>
<?php foreach(@$faqArticles as $title => $link):?>
<li><a href="<?=$link?>"><?=$title?></a></li>
<?php endforeach;?>
</ul>
