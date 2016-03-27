<?php $properties = $question->getProperties()?>
<div class="single-question">
    <h1>
        <a href="<?=$this->url->create('questions/single/'.$properties['id'])?>">
            <?=$properties['headline']?>
        </a>
    </h1>
    <?=$this->textFilter->doFilter($properties['content'], 'shortcode, markdown')?>
</div>
