<div class="answer">
    <?php if ($answer['accepted']) :?>
        <img src='<?=$this->url->asset("img/chk-mark-home-64px.png")?>' alt="Bra" />
    <?php endif;?>
    <?=$this->textFilter->doFilter($answer['content'], 'shortcode, markdown')?>
    <div class="user-card-answer">
        <p>
            svarade <a href='<?=$this->url->create('users/profid/'.$user['id'])?>'>
                <?=$user['name']?>
            </a> <?=\Anax\CommentDb\CommentsInDb::humanTiming($answer['created'])?> sedan.
        </p>
    </div>
</div>
<div class="clear"></div>
