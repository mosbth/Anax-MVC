<?php
$asked_notice = str_replace('$username', ucfirst($user->acronym), 
$text['questions']['asked']['notice']);
$quest_notice = str_replace('$username', ucfirst($user->acronym), $text['questions']['anwsers']['notice']);
?>
<div id="profile">
    <div id="profile-info">
        <label><?=$text['username']?></label>
        <p><?=$user->acronym?></p>
        <label><?=$text['name']?></label>
        <p><?=$user->name?></p>
        <label><?=$text['email']?></label>
        <p><?=$user->email?></p>
        <label><?=$text['user_level']?></label>
        <p><?=$this->auth->getAuth($user->level);?></p>
    </div>
    <div id="profile-questions">
        <p><label><?=$text['questions']['asked']['label']?></label></p>
        <?php 
        if (isset($questions)) : 
            foreach ($questions as $question) : ?>
                <div class="question">

                </div>
            <?php endforeach; 
        else : ?>
            <div class="noticeMessage">
                <i class='fa fa-info'></i><?=$asked_notice?>
            </div>
        <?php endif; ?>
    </div>
    <div id="profile-anwsers">
        <p><label><?=$text['questions']['anwsers']['label']?></label></p>
        <?php 
        if (isset($awnsers)) : 
            foreach ($awnsers as $awnser) : ?>
                <div class="anwsers">
                </div>
            <?php endforeach; 
        else : ?>
            <div class="noticeMessage">
                <i class='fa fa-info'></i><?=$quest_notice?>
            </div>
        <?php endif; ?>
    </div>
</div>
