<div id="comment-section">
	<h3>Kommentarer</h3>
	<div class="comments">
	<?php if (is_array($comments)) : ?>
		<?php  foreach ($comments as $id => $comment) : ?>
			<h5>#<?=$id?></h5>
			<p><label>Name: </label><?=$comment['name']?></p>
			<p><label>Homepage: </label><?=$comment['web']?></p>
			<p><label>Comment: </label><?=$comment['content']?></p>
			<p><label>Email: </label><?=$comment['mail']?></p>

			<form method="post" class="comment" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
				<input type="hidden" name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="submit" name="doRemove" value="Delete" onclick="this.form.action = '<?= $this->url->create('comment/remove') ?>'">
                <input class="btn" type='submit' name='doEdit' value='Edit' onclick="this.form.action = '<?= $this->url->create('comment/edit') ?>'">
			</form>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>
