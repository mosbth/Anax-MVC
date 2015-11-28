
    
        <div class="col-md-3 col-lg-3 gnarfooter">
        
        <h5>Navigera</h5>
        <p><a href="<?= $this->di->get('url')->create('questions/list/timestamp') ?>">Frågor</a></p>
        <p><a href="<?= $this->di->get('url')->create('tags/list') ?>">Taggar</a></p>
        <p><a href="<?= $this->di->get('url')->create('users/all') ?>">Alla användare</a></p>
        <p><a href="<?= $this->di->get('url')->create('questions/add') ?>">Ställ en fråga</a></p>

        </div><!--COL-->
    
        <div class="col-md-3 col-lg-3 gnarfooter">
        
        <form action="search.php" method="post" id="searchform">
        <input class="form-control" type="text "placeholder="Sök..." name="searchvalue">
        <input id="validateButton" class="btn" type='submit' name='do_search' value='Sök' onClick="this.form.action = '<?=$this->url->create('questions/search')?>'">
        </form>
        
        <h4>Vi finns på</h4>
        <a href=""><i class="fa fa-facebook-square fa-4x"></i></a>
        <a href=""><i class="fa fa-instagram fa-4x"></i></a>
        <a href=""><i class="fa fa-twitter-square fa-4x"></i></a>

        </div><!--COL-->
    
        <div class="col-md-3 col-lg-3 gnarfooter">
        
        <h5>Information</h5>
        <p><a href="<?= $this->di->get('url')->create('about') ?>">Om Shreddin' the gnar</a></p>
        <p><a href="<?= $this->di->get('url')->create('FAQ') ?>">FAQ</a></p>
        <p><a href="<?= $this->di->get('url')->create('rules') ?>">Regler</a></p>
        <p><a href="<?= $this->di->get('url')->create('annonsera') ?>">Annonsera</a></p>
        <p><a href="<?= $this->di->get('url')->create('kontakt') ?>">Kontakta oss</a></p>

        </div><!--COL-->