<hr>

<h2>Messages</h2>

<?php if (is_array($messages)) : ?>
<div class='cf-message-list'>
<?php foreach ($messages as $id => $comment) : ?>
<div class="cf-message-single">
<h4>Message #<?=$comment->id?></h4>
<p class="cf-message-received">Received: <?=$comment->created?></p>
<p class="cf-message-from">From: <?=$comment->name?></p>
<p class="cf-message-email">Email:
    <a href="mailto:<?=$comment->mail?>"  title="Send e-mail to <?=$comment->mail?>"><?=$comment->mail?>
    </a>
</p>
<p class="cf-message-webb">Web:
    <a href="http://<?=$comment->web?>" title="Visit <?=$comment->web?>"><?=$comment->web?>
    </a>
</p>
<p class="cf-message-subject">Subject: <?=$comment->subject?></p>
<p class="cf-message-content"><?=$comment->message?></p>
<hr>

<a href="<?=$this->url->create('contactformadmin/delete')?><?='/'.$comment->id?>" title="Delete">
    <span class="cf-message-delete">Delete</span>
</a>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
