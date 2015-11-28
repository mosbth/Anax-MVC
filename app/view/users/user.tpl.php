<div id="user">
   <h4 id="usertitle"><?=$user->acronym?></h4>
    <div class="gravatardiv">
        <img class="gravatar" src="http://www.gravatar.com/avatar/<?=md5($user->email);?>.jpg?s=100">
    </div>
    
    <div id="activity">
       <table>
           <tr><td><span class="usernumber"><?php echo count($userQuestions)?></span></td><td><span class="usernumber"><?php echo count($userAnswers)?></span></td><td><span class="usernumber"><?php echo $countcomments = count($userComments) + count($userAnswerComments)?></span></td></tr>
           <tr><td>frågor</td><td>svar</td><td>kommentarer</td></tr>
       </table>
       <br>
       <div id="points">
           <p><i class="fa fa-certificate fa-5x"></i> <span><?=$user->points?> poäng</span> </p>
       </div>
    </div>
    <hr id="userhr">
    
    <div id="usertext">
        <p><?=$user->about?></p>

        <div id="funstuff">
            <table>
                <tr><td><i class="fa fa-envelope-o"></i><td><a href='mailto:<?=$user->email?>'><?=$user->email?></a></td></td></tr>
              <?php if(!empty($user->country)):?>
               <tr><td><i class="fa fa-map-marker"></i></td><td><?php if(!empty($user->city)):?><?=$user->city?>, <? endif ?><?=$user->country?></td></tr>
               <? endif ?>
               
                <tr><td><i class="fa fa-clock-o"></i></td> <td>Senast inloggad: <?= $this->time->timeago($user->loggedIn)?></td></tr>
                <?php if(!empty($user->website)):?>
        <tr><td><i class="fa fa-link"></i></i></td><td><a target="_blank" href='<?=$user->website?>'><?=$user->website?></a></td></tr>
                <? endif ?>
                <tr><td><i class="fa fa-refresh"></i></td><td>Blev medlem för <?= $this->time->timeago($user->timestamp)?></td></tr>
           </table>
       </div>
       
        <!-- KNAPPAR SOM BARA VISAS OM DEN INLOGGADE ANVÄNDAREN ÄR SAMMA SOM ID ====== -->
        <?php $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null; ?>
        <?php if($userId == $user->id):?>
           <div id="buttonsuser">
            <a href="<?=$this->url->create('users/update/' . $user->id) ?>"><button class="btn">Uppdatera profil</button></a>
            <form id="logoutpageuser" method="post">
                <input class="btn" type='submit' name='login' value='Logga ut' onClick="this.form.action = '<?=$this->url->create('users/logout')?>'"/>
            </form>
            </div>
        <? endif ?>
        <!-- SLUT PÅ KNAPPAR SOM BARA VISAS....... -->
       
    </div><!--USERTEXT-->
</div><!--USER-->