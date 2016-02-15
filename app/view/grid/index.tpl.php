<h1>The index template for grids (wrong file, correct is theme/anax-grid/index.tpl.php)</h1>
<?php if ($this->views->hasContent('flash')) : ?>
<div id='flash'><?php $this->views->render('flash')?></div>
<?php endif; ?>

<?php if ($this->views->hasContent('triptych-1', 'triptych-2', 'triptych-3')) : ?>
<div id='wrap-triptych'>
    <div id='triptych-1'><?php $this->views->render('triptych-1')?></div>
    <div id='triptych-2'><?php $this->views->render('triptych-2')?></div>
    <div id='triptych-3'><?php $this->views->render('triptych-3')?></div>
</div>
<?php endif; ?>
<p>
    This the grid index template.
</p>
