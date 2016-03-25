<div class="single-question-short">
    <h2>
        <a href="<?=$this->url->create('questions/single/'.$question['id'])?>">
            <?=$question['headline']?>
        </a>
    </h2>
    <p>
        <?=$this->textFilter->doFilter($question['content'], 'shortcode, markdown')?>
    </p>
    <?php // TODO: Add tags listed for question. ?>
</div>
