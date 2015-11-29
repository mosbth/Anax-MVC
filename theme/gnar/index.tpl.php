<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?=$title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>

<!--WRAPPER-->

<div class='container-fluid' id='wrapper'>
   


   <!--NAVBAR-->
   <div class="container">
    <?php if ($this->views->hasContent('navbar')) : ?>
        <nav class="navbar navbar-default">
          
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=$this->di->get('url')->create('index')?>"><img id="logomenu" src="<?=$this->url->asset($logomenu)?>"></a>
        </div><!--Navbarheader-->
       
        <?php $this->views->render('navbar')?>
        
            </div><!--container-->
        </nav>
    <?php endif; ?>
    
    <!--NAVBAR ENDING-->
    
    
    <div class="container">
    
    <div id='main'>
       <?php $this->response->displayMessage(); ?>
        <?php if(isset($main)) echo $main?>
        <?php $this->views->render('main')?>
    </div>
    </div>

    <div class ="container-fluid" id='footer'>
        <div class="container" id="footer2">
            <div class="row">
                <div class="col-md-3 col-lg-3 gnarfooter">
                    <a href="<?=$this->di->get('url')->create('index')?>"><img id="logomenu2" src="<?=$this->url->asset($logomenu)?>"></a>
                            <br><i class="fa fa-copyright fa-lg"></i> Shreddin' the gnar

                    </div>
                    <?php if(isset($footer)) echo $footer?>
                    <?php $this->views->render('footer')?>
                </div><!--ROW-->
            </div><!--CONTAINER-->
        </div><!--CONTAINER-FLUID-->


</div><!--WRAPPER-->

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
