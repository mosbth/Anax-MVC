<h1>Throw a dice</h1>

<p>This is a sample pagecontroller showing how to use <i>application specific modules</i> in a pagecontroller.</p>

<p>How many rolls do you want to do, <a href='?roll=1'>1 roll</a>, <a href='?roll=3'>3 rolls</a> or <a href='?roll=6'>6 rolls</a>? </p>

<?php if(isset($roll)) : ?>
<p>You made <?=$roll?> roll(s) and you got this serie.</p>

<ul class='dice'>
<?php foreach($results as $val) : ?>
<li class='dice-<?=$val?>'></li>
<?php endforeach; ?>
</ul>

<p>You got <?=$total?> as a total.</p>
<?php endif; ?>
