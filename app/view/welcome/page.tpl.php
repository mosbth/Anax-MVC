<article class="article1 card card-2">
    <h1><?=$title?></h1>

<?=$content?>

<?php if (isset($byline)) : ?>
<footer class="byline card card-2">
<?=$byline?>
</footer>
<?php endif; ?>

</article>
