<h1><?=$title?></h1>
<?php foreach ($users as $user) : ?>
    <div id="users">
        <img class="gravatar" src="http://www.gravatar.com/avatar/<?=md5($user->email);?>.jpg?s=100">
        <div><a href='<?=$this->url->create('users/id/' . $user->id)?>'><?=$user->acronym?></a>
        <p><?=$user->name?></p>
        </div>
    </div><!--End of div users-->
<?php endforeach; ?> 