<h5><?=$comment->subject?></h5> 
<p><?=$comment->content?></p> 

<p class="timestamp"><?=$comment->timestamp?></p>
<p><?=$comment->name?></p>

<p><a href="<?=$comment->web?>"><?=!empty($comment->web) ? "Webbsida" : ""?></a>
            
<a href="mailto:<?=$comment->email?>"?><?=$comment->email?></a></p>

<p><a href='<?=$this->url->create('comment')?>'>Tillbaka</a></p> 