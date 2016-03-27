<h1><?=$title?></h1>

<div class="users">
<?php foreach ($users as $user) : ?>
<?php $properties = $user->getProperties()?>
<div class="users-profile-card">
    <a href='<?=$this->url->create('users/profile/'.$properties['acronym'])?>'>
        <img src="<?=$properties['gravatar']?>" alt="gravatar" />
        <?=$user->name?>
    </a>
</div>

<?php endforeach; ?>

</div>
