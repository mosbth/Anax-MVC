<div class="answer">
    <p><?=$this->textFilter->doFilter($answer['content'], 'shortcode, markdown')?></p>
    <div class="user-card-answer">
        <p>
            svarade <a href='<?=$this->url->create('users/profid/'.$user['id'])?>'>
                <?=$user['name']?>
            </a> <?=\Anax\CommentDb\CommentsInDb::humanTiming($answer['created'])?> sedan.
        </p>
    </div>
</div>
<div class="clear"></div>
