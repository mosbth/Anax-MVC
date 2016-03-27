<div class="all-tags">
<?php foreach ($tags as $tag) : ?>
<div class="tag">
    <a href="<?=$this->url->create('questions/list/tags/'.$tag['id'])?>">
        <?=$tag['name']?>
    </a>
</div>
<?php endforeach; ?>

</div>
<div class="clear"></div>
