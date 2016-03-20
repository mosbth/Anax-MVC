<?php $properties = $user->getProperties()?>
<h1><?=$properties['name']?></h1>

<div class="users-profile-card">
    <a href='<?=$this->url->create('users/profile/'.$properties['acronym'])?>'>
        <img src="<?=$properties['gravatar']?>" alt="gravatar" />
        <p><?=$user->name?></p>
    </a>
    <p>
        <?=$nrOfQuestions?> <a href="<?=$urlQuestions?>">frågor</a> |
        <?=$nrOfAnswers?> <a href="<?=$urlAnswers?>">svar</a>
    </p>
</div>
