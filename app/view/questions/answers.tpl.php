<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($answers); ?>
<div class="answers">
<?php foreach ($answers as $answer) : ?>
    <div class="answer">
        <?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($answer); ?>
        <?=$answer['answer']['content']  ?>
        <div class="user-card answer">
            <p>
                svarade <a href='<?=$this->url->create('users/id/'.$answer['user']['id'])?>'>
                    <?=$answer['user']['name']?>
                </a> <?=\Anax\CommentDb\CommentsInDb::humanTiming($answer['answer']['created'])?> sedan.
            </p>
        </div>
        <?php if (isset($answer['comments'])) :?>
        <?php foreach ($answer['comments'] as $comment) : ?>
            <div class="answer-comment">
                <p><?=$comment['comment']['content']?> -
                    <a href='<?=$this->url->create('users/id/'.$comment['user']['id'])?>'>
                        <?=$comment['user']['name']?>
                    </a>
                    <?=\Anax\CommentDb\CommentsInDb::humanTiming($comment['comment']['created'])?> sedan.
                </p>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>
