<h1><?=$title?></h1>

<?php foreach ($users as $user) : ?>

<pre><?=var_dump($user->getProperties())?></pre>

<?php endforeach; ?>

<p><a href='<?=$this->url->create('users/list')?>'>List users</a></p>
