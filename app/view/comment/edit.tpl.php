<div class='comment-form'>
    <?=$content?>
    <?php if (isset($links)) {?>
        <?php foreach ($links as $link) : ?>
            <a href="<?=$link['href']?>"><button><?=$link['text']?></button></a>
        <?php endforeach; ?>
    <?php } ?>
</div>