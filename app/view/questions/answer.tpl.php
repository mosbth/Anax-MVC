<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($answers); ?>
<div class="answer">
    <?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($answer); ?>
    <?=$answer['content']  ?>
    <div class="user-card-answer">
        <p>
            svarade <a href='<?=$this->url->create('users/profid/'.$user['id'])?>'>
                <?=$user['name']?>
            </a> <?=\Anax\CommentDb\CommentsInDb::humanTiming($answer['created'])?> sedan.
        </p>
    </div>
</div>
<div class="clear"></div>
