<div class="single-question-short">
    <h2>
        <a href="<?=$this->url->create('questions/single/'.$question['id'])?>">
            <?=$question['headline']?>
        </a>
    </h2>
    <p>
        <?=$question['content']?>
    </p>
    <?php // TODO: Add tags listed for question. ?>
</div>
