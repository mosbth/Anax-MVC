<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<div class="comment-single card card-1">
<h4>Comment #<?=$id?></h4>
<p>
    <a href="http://<?=$comment['web']?>"><?=$comment['name']?></a>
    för <?=$comment['since-time']?> sedan.
    <a href="http://<?=$comment['web']?>">
        <span class="fa fa-globe "></span>
        <span class="screen-reader-text">webbplats</span>
    </a>
    <a href="mailto:<?=$comment['mail']?>">
        <span class="fa fa-envelope-o"></span>
        <span class="screen-reader-text">e-post</span>
    </a>
</p>
<p><?=$comment['content']?></p>


<a href="<?=$this->url->create('comment/delete')?><?='?id='.$id?>">
    <span class="fa fa-trash"></span>
    <span class="screen-reader-text">radera</span>
</a>
<a href="<?=$this->url->create('comment/edit')?><?='?id='.$id?>">
    <span class="fa fa-pencil"></span>
    <span class="screen-reader-text">redigera</span>
</a>
<?php //dump($comment); ?>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
