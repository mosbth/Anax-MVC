
<?php $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null; ?>
   
       <?php if($userId): ?>
        <form id="logoutfirstpage" method="post">
            <input class="btn" type='submit' name='login' value='Logga ut' onClick="this.form.action = '<?=$this->url->create('users/logout')?>'"/>
        </form>
    <?php else: ?>
        <form id="loginfirstpage2" method="post">
            <div class="form-group"><label for="username"><input placeholder="Användarnamn" id="acronym" class="form-control" type='text' name='acronym' value=''></label></div>
            <div class="form-group"><label for="password"><input placeholder="Lösenord" id="password" class="form-control" type='password' name='password' value=''></label></div>
            <br>
            <input  id="buttongnar" class="btn" type='submit' name='do_login' value='Logga in' onClick="this.form.action = '<?=$this->url->create('users/login')?>'"/>
            
        </form>
        <a href="<?=$this->url->create('users/add')?>"><button id="buttongnar" class="btn">Bli medlem!</button> </a>
<?php endif ?>
