<div class="users">
    <?php foreach ($users as $user) : ?>
        <div class="users-profile-card">
            <a href='<?=$this->url->create('users/profile/'.$user['acronym'])?>'>
                <img src="<?=$user['gravatar']?>" alt="gravatar" />
                <p><?=$user['name']?></p>
            </a>
        </div>
        <div class="clear"></div>
    <?php endforeach; ?>
</div>
