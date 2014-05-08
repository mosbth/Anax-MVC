<div id="comment-section">
	<h3>Kommentarer</h3>
	<div class="comments">
		<?php foreach ($comments as $comment) :
		$comment = $comment->getProperties();

		$id = isset($comment['id']) && !is_null($comment['id']) ? $comment['id'] : null;
		$name = isset($comment['name']) && !is_null($comment['name']) ? $comment['name'] : null;
		$web = isset($comment['web']) && !is_null($comment['web']) ? $comment['web'] : null;
		$content = isset($comment['content']) && !is_null($comment['content']) ? $comment['content'] : null;
		$mail = isset($comment['email']) && !is_null($comment['email']) ? $comment['email'] : null;
		?>
			<h3>#<?=$id?></h4>
			<p><label>Name: </label><?=$name?></p>
			<p><label>Homepage: </label><?=$web?></p>
			<p><label>Comment: </label><?=$content?></p>
			<p><label>Email: </label><?=$mail?></p>
			<form method="post" class="comment" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
				<input type="hidden" name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
				<input type="hidden" name="id" value="<?=$id?>">
				<input type="submit" name="doRemove" value="Delete" onclick="this.form.action = '<?= $this->url->create('comments/remove')  . '/' . $comment['id']  ?>'">
                <input class="btn" type='submit' name='doEdit' value='Edit' onclick="this.form.action = '<?= $this->url->create('comments/edit') . '/' . $comment['id'] ?>'">
			</form>
		<?php endforeach; ?>
	</div>
</div>
