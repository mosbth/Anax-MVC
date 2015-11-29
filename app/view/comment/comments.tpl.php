<h1>Senaste Snackisarna</h1>

<hr>

<?php if (is_array($comments)) : ?>
    
    <?php foreach ($comments as $id => $comment) : ?>

    <div id="comment">
            <a href="<?=$this->url->create('comment/viewComment/' . $comment->id )?>"><?=$comment->subject?></a> 
        
            <p><?=$comment->content?> </p>

            <p>Skrivet av <?=$comment->name?> <span class="timestamp"><?=$comment->timestamp?></span></p>

            <p><a href="<?=$comment->web?>"><?=!empty($comment->web) ? "Webbsida" : ""?></a>
            
            <a href="mailto:<?=$comment->email?>"?><?=$comment->email?></a></p>
    
    </div>

    
    <?php endforeach; ?>


<?php endif; ?>


