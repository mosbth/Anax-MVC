<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($comments); ?>
<div class="comments">
    <?php if (isset($comments)) :?>
        <?php foreach ($comments as $comment) : ?>
            <div class="comment">
                <?=$this->textFilter->doFilter($comment['comment']['content'], 'shortcode, markdown')?>
                <p>
                    - <a href='<?=$this->url->create('users/id/'.$comment['user']['id'])?>'>
                        <?=$comment['user']['name']?>
                    </a>
                    <?=\Anax\CommentDb\CommentsInDb::humanTiming($comment['comment']['created'])?> sedan.
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
