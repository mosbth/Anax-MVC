<?php if(is_array($content)) :
$count = 1;
foreach ($content as $value) :
// Support for special styling of every element.
$count++;

?>
<article class="article<?=$count?>">
<?=$value?>

</article>
<?php endforeach; ?>

<?php else : ?>
<article class="article1">
<?=$content?>
</article>
<?php endif; ?>

<?php if(isset($byline)) : ?>
<footer class="byline">
<?=$byline?>
</footer>
<?php endif; ?>
