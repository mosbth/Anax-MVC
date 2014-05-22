<?php if (isset($content)) : 
foreach ($content as $question) :
    $slug = $this->url->create('questions/title/'. $question->id . '/' . $question->slug);
    if ($question->created > $question->updated) :
        $time = "{$question->created}"; 
    else :
        $time = "{$question->updated}";
    endif;
    ?>
    <div class="sidebar-question">
        <h5><a href="<?=$slug?>"><?=$question->title?></a></h5>
        <p class="by">Frågad av: <?=$question->acronym?> för <?=$this->time->getRelativeTime($time)?></p> 
    </div>
<?php endforeach; endif;


