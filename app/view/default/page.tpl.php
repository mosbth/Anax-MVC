<?php if (isset($title)) : ?>
<h1><?=$title?></h1>
<?php endif; ?>

<?=$content?>

<?php if (isset($links)) : ?>
<ul>
<?php foreach ($links as $link) : ?>
<li><a href="<?=$link['href']?>"><?=$link['text']?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
