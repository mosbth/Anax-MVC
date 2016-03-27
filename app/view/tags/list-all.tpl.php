<?php if (isset($title)) :?>
<h1><?=$title?></h1>
<?php endif; ?>
<div class="all-tags">
<?php foreach ($tags as $tag) : ?>
<?php $properties = $tag->getProperties()?>
<div class="tag">
    <a href="<?=$this->url->create('questions/list/tags/'.$properties['id'])?>">
        <?=$properties['name']?>
    </a>
</div>
<?php endforeach; ?>
</div>
