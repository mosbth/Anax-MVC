<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
<?php // TODO: Add below resource in a better way using the framework?>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> -->
</head>

<body id='<?='body-'.implode('-', $this->request->getRouteParts())?>'>

<div id='wrapper'>

<div id='header'>
<?php if(isset($header)) echo $header?>
<?php $this->views->render('header')?>
</div>

<?php if ($this->views->hasContent('navbar')) : ?>
<div id='navbar'>
<?php $this->views->render('navbar')?>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('flash')) : ?>
<div id='flash'><?php $this->views->render('flash')?></div>
<?php endif; ?>

<?php if ($this->views->hasContent('featured-1', 'featured-2', 'featured-3')) : ?>
<div id='wrap-featured'>
    <div id='featured-1'><div class="cont"><?php $this->views->render('featured-1')?></div></div>
    <div id='featured-2'><div class="cont"><?php $this->views->render('featured-2')?></div></div>
    <div id='featured-3'><div class="cont"><?php $this->views->render('featured-3')?></div></div>
</div>
<?php endif; ?>

<div id='wrap-main'>
    <?php if ($this->views->hasContent('main')) : ?>
    <div id='main'><div class="cont">
    <?php if(isset($main)) echo $main?>
    <?php $this->views->render('main')?>
    </div></div>
<?php endif; ?>

    <?php if ($this->views->hasContent('sidebar')) : ?>
        <div id='sidebar'><div class="cont"><?php $this->views->render('sidebar')?></div></div>
    <?php endif; ?>
</div>

<?php if ($this->views->hasContent('triptych-1', 'triptych-2', 'triptych-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptych-1'><div class="cont"><?php $this->views->render('triptych-1')?></div></div>
    <div id='triptych-2'><div class="cont"><?php $this->views->render('triptych-2')?></div></div>
    <div id='triptych-3'><div class="cont"><?php $this->views->render('triptych-3')?></div></div>
</div>
<?php endif; ?>

<?php if ($this->views->hasContent('footer-col-1', 'footer-col-2', 'footer-col-3', 'footer-col-4')) : ?>
<div id='wrap-footer-col'>
    <div id='footer-col-1'><div class="cont"><?php $this->views->render('footer-col-1')?></div></div>
    <div id='footer-col-2'><div class="cont"><?php $this->views->render('footer-col-2')?></div></div>
    <div id='footer-col-3'><div class="cont"><?php $this->views->render('footer-col-3')?></div></div>
    <div id='footer-col-4'><div class="cont"><?php $this->views->render('footer-col-4')?></div></div>
</div>
<?php endif; ?>

<div id='footer'>
<?php if(isset($footer)) echo $footer?>
<?php $this->views->render('footer')?>
</div>

</div>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

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
