<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php $flow = $this->request->getRoute() ?>
<?php foreach ($comments as $id => $comment) : ?>
    <?php if ($comment['comment-flow']==$flow) : ?>
<h4><a href="<?=$this->url->create('comment/edit')?><?='?id='.$id?>">Comment #<?=$id?></a></h4>
<a href="<?=$this->url->create('comment/delete')?><?='?id='.$id?>">Delete</a>
<p><?=dump($comment)?></p>
<?php endif ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
