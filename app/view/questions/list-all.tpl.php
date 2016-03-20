<h1><?=$title?></h1>
<div class="all-questions">
<?php foreach ($questions as $question) : ?>
    <?php //$properties = $question->getProperties()?>
    <?php $properties = $question?>
<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";dump($properties); ?>
<div class="question">
    <a href="<?=$this->url->create('questions/single/'.$properties['question']['id'])?>"><h2>
        <?=$properties['question']['headline']?>
    </h2></a>
    <p>
        <?=$properties['question']['content']?>
    </p>
    <div class="question-author">
        User: <?=$properties['question']['user_id']?>
        <?php // TODO: display user card ?>
    </div>

</div>
<?php endforeach; ?>
</div>
