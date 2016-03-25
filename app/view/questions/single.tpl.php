<?php $properties = $question->getProperties()?>
<?php //echo "<br>" . __FILE__ . " : " . __LINE__ . "<br>";var_dump($properties); ?>
<div class="single-question">
    <h1>
        <a href="<?=$this->url->create('questions/single/'.$properties['id'])?>">
            <?=$properties['headline']?>
        </a>
    </h1>
    <?=$properties['content']?>
    <?php // TODO: Add tags listed for question. ?>
</div>
