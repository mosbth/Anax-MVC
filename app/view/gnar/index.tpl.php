<div id="frontcol1">
        <div class="carousel slide" data-ride="carousel" id="myCarousel" data-interval="3000">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
            </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img class="frontpage" src="img/frontpage.jpg">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <img class="frontpage" src="img/snow.jpg">
            </div>
            <div class="item">
                <img class="frontpage" src="img/ski-tour.jpg">
            </div>
            <div class="item">
                <img class="frontpage" src="img/skipiste.jpg">
            </div>
            <div class="item">
                <img class="frontpage" src="img/photodune.png">
            </div>
        </div>
        </div><!--END OF CAROUSEL-->
        
        <div class="">	
            <?php foreach ($tags as $tag) : ?>
                <span class="label">
                    <a href="<?=$this->url->create('tags/id/' . $tag->id)?>"><?=$tag->tagName?></a>
                </span><!--TAG-->
            <?php endforeach; ?>
        </div><!--COL-->
        
        <div class="blogfrontpage ">

        <h4>Senaste blogginläggen</h4>
               <hr>
                <div class="blog clearfix">
                    <img src="img/winter.jpg" class="pull-right"> <h5 class="bold">Han gör det igen!</h5> <p class="bold">2015-11-27 - 2 kommentarer - <span class="link">Kommentera</span></p><br>
                    <p>Mattias Andersson har gått vidare till världscupen i snowboard, bara 18 år gammal har han kvalificerat sig vidare från tävlingarna i Sverige som höll till i Åre, där vann han flera olika deltävlingar och tog totalt 5 medaljer. <span class="link">Läs mer...</span></p>
                </div>
                <hr>
                
                <div class="blog clearfix">
                <img src="img/alps.jpg" class="pull-right"> <h5 class="bold">Snön har kommit till Alperna</h5> <p class="bold">2015-11-25 - 5 kommentarer - <span class="link">Kommentera</span></p><br>
                <p>Nu borde man önska att man befinner sig i någonstans i Alperna, snön har nämligen börjat falla och snökanonerna går för fullt. <span class="link">Läs mer...</span></p>
                </div>
                
                <hr>
                <div class="blog clearfix">
                <img src="img/dundret.jpg" class="pull-right"> <h5 class="bold">Dundret har öppnat!</h5> <p class="bold">2015-11-22 - 11 kommentarer - <span class="link">Kommentera</span></p><br>
                <p>Dags att åka till Gällivare! Nu har det kommit så pass mycket snö att en del av backarna har kunnat öppna. Och inte nog med det. Dundret har en sprillas ny sittlift med plats för 6 personer åt gången. <span class="link">Läs mer...</span></p>
                </div>
                <hr>

        </div><!--COL-12 BLOGGINLÄGG-->
</div><!--FRONT COL 1 --->



<div id="frontcol2">

<!-- ===== LOGIN FORM ===== -->
<div class="">
<?php $userId =  isset($_SESSION['userId']) ? $_SESSION['userId'] : null; ?>
<?php if($userId): ?>
    <p>Du är inloggad.</p>
        <form id="logoutfirstpage" method="post" action="login.php">
            <input class="btn" type='submit' name='login' value='Logga ut' onClick="this.form.action = '<?=$this->url->create('users/logout')?>'"/>
        </form>
<?php else: ?>

<form id="loginfirstpage" method="post">
		  <div class="form-group">
    		  <label for="username"><input placeholder="Användarnamn" id="acronym" class="form-control" type='text' name='acronym' value=''></label>
		  </div>
		  <div class="form-group">
    		  <label for="password"><input placeholder="Lösenord" id="password" class="form-control" type='password' name='password' value=''></label>
		  </div>
		  
		  <input id="validateButton" class="btn" type='submit' name='do_login' value='Logga in' onClick="this.form.action = '<?=$this->url->create('users/login')?>'">

</form>
<a href="<?=$this->url->create('users/add')?>"><input id="skipbutton" class="btn" value="Bli medlem!"></a>	  

<?php endif ?>


</div><!--END LOGIN FORM-->


<!-- ===== SENASTE FRÅGORNA ===== -->
<div class="">

	<h4>Senaste frågorna</h4>
	<?php foreach ($questions as $question) : ?>
			<p><a href="<?=$this->url->create('questions/id/' . $question->id)?>"><?=$question->questionTitle?> </a></p>
	<?php endforeach; ?>
	
</div><!--COL SENASTE FRÅGORNA-->

<!-- ===== MEST AKTIVA ANVÄNDARNA ===== -->
<div class="">
	<h4>Mest aktiva användarna</h4>
	
	<?php foreach ($activeUsers as $user) : ?>
			<a href="<?=$this->url->create('users/id/' . $user->id)?>"><?=$user->acronym?></a>
	<?php endforeach; ?>
	
</div><!--COL MEST AKTIVA-->
</div><!-- END OF FRONTCOL2-->
