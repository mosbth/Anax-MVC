<h1><?=$title?></h1>
	<?php foreach ($tags as $tag) : ?>
		<span class="label">
		    <a href="<?=$this->url->create('tags/id/' . $tag->id)?>"><?=$tag->tag?></a>
		</span>	
	<?php endforeach; ?>

