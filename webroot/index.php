<?php 
require __DIR__.'/config_with_app.php';

//Route for Startpage

$app->router->add('', function() use ($app) {
	$app->theme->setTitle('Start');
});
    
$app->router->add('index', function() use ($app) {
	$app->theme->setTitle('Start');
	
    
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action'     => 'index',
        'params'     => [],

    ]);
});

$app->router->add('about', function() use ($app) {
	$app->theme->setTitle('About Shreddin the gnar');
    
    $content = $app->fileContent->get('about.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
		'content' => $content
		]);

});

$app->router->add('FAQ', function() use ($app) {
	$app->theme->setTitle('FAQ');
    
    $content = $app->fileContent->get('faq.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
		'content' => $content
		]);

});

$app->router->add('rules', function() use ($app) {
	$app->theme->setTitle('Regler');
    
    $content = $app->fileContent->get('rules.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
		'content' => $content
		]);

});

$app->router->add('annonsera', function() use ($app) {
	$app->theme->setTitle('About Shreddin the gnar');
    
    $content = $app->fileContent->get('annons.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
		'content' => $content
		]);

});

$app->router->add('kontakt', function() use ($app) {
	$app->theme->setTitle('About Shreddin the gnar');
    
    $content = $app->fileContent->get('kontakt.md');
	$content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	
	$app->views->add('me/page', [
		'content' => $content
		]);

});



 
$app->router->handle();

//Render the page
$app->theme->render();