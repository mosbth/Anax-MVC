<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<div class="comment-single card card-1">
<h4>Comment #<?=$id?></h4>
<p>
    <a href=""http://<?=$comment['web']?>""><img src="<?=$comment['gravatar']?>" alt="gravatar" /></a>
    <a href="http://<?=$comment['web']?>"><?=$comment['name']?></a>
    för <?=$comment['since-time']?> sedan.
    <a href="http://<?=$comment['web']?>" title="Besök <?=$comment['web']?>">
        <span class="fa fa-globe "></span>
        <span class="screen-reader-text">Besök webbplats <?=$comment['web']?></span>
    </a>
    <a href="mailto:<?=$comment['mail']?>"  title="Skicka e-post till <?=$comment['mail']?>">
        <span class="fa fa-envelope-o"></span>
        <span class="screen-reader-text">skicka e-post till <?=$comment['mail']?></span>
    </a>
</p>
<p><?=$comment['content']?></p>


<a href="<?=$this->url->create('comment/delete')?><?='?id='.$comment['id']?>" title="Radera">
    <span class="fa fa-trash"></span>
    <span class="screen-reader-text">radera</span>
</a>
<a href="<?=$this->url->create('comment/edit')?><?='?id='.$comment['id']?>" title="Redigera">
    <span class="fa fa-pencil"></span>
    <span class="screen-reader-text">redigera</span>
</a>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
