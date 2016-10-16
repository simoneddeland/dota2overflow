<?php
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential settings.
require __DIR__.'/config.php'; 


// Create services and inject into the app. 
$di  = new \Anax\DI\CDIFactoryDefault();

$app = new \Anax\Kernel\CAnax($di);

// Always start the session
$app->session();

$app->theme->setTitle("Dota 2");
$app->theme->configure(ANAX_APP_PATH . 'config/theme-q.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_q.php');

$di->set('UsersController', function () use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('SetupController', function () use ($di) {
    $controller = new \Anax\Setup\SetupController();
    $controller->setDI($di);
    return $controller;
});

$di->set('PostController', function () use ($di) {
    $controller = new \Anax\Post\PostController();
    $controller->setDI($di);
    return $controller;
});

$di->set('AnswerController', function () use ($di) {
    $controller = new \Anax\Answer\AnswerController();
    $controller->setDI($di);
    return $controller;
});

$di->set('TagController', function () use ($di) {
    $controller = new \Anax\Tag\TagController();
    $controller->setDI($di);
    return $controller;
});

$di->set('AuthenticateController', function () use ($di) {
    $controller = new \Anax\Authenticator\AuthenticateController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function () use ($di) {
    $controller = new \Anax\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('VoteController', function () use ($di) {
    $controller = new \Anax\Vote\VoteController();
    $controller->setDI($di);
    return $controller;
});


// Home route
$app->router->add('', function () use ($app) {
    $app->theme->setTitle("Hem");
    $app->dispatcher->forward([
        'controller' => 'post',
        'action'     => 'viewLatest',
    ]);

});

// Home route
$app->router->add('about', function () use ($app) {

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->theme->setTitle("Om sidan");
    $app->views->add('default/page', [
        'title' => "Om sidan",
        'content' => $content,
    ]);

});


// Check for matching routes and dispatch to controller/handler of route
$app->router->handle();

// Render the page
$app->theme->render();
