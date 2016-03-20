<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($question); ?>
<div class="single-question-short">
    <h1>
        <a href="<?=$this->url->create('questions/single/'.$question['id'])?>">
            <?=$question['headline']?>
        </a>
    </h1>
    <p>
        <?=$question['content']?>
    </p>
    <?php // TODO: Add tags listed for question. ?>
</div>
