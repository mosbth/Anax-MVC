<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php $flow = $this->request->getRoute() ?>
<?php foreach ($comments as $id => $comment) : ?>
    <?php if ($comment['comment-flow']==$flow) : ?>
<h4>Comment #<?=$id?></h4>
<p><?=dump($comment)?></p>
<?php endif ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
