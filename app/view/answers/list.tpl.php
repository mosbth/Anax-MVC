<div class="all-answers">
    <h2><?=$nrOfAnswers?> svar</h2>
<?php foreach ($answers as $answer) : ?>
<?php $properties = $answer->getProperties()?>
<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump($properties); ?>
<div class="answers">
    <p>
        <?=$properties['content']?>
    </p>
        <?php // TODO: display user card ?>

</div>
<?php endforeach; ?>
</div>
