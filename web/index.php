<?php

/**
 * A dump page for testing Silex (and learning probably)....
 * @author Travis South <irvin.capagcuan@bayviewtechnology.com>
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;

$app = new Application();
$app['debug'] = true;

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello ' . $app->escape($name);
});

$blogPosts = array(
    1 => array(
        'date' => '2011-03-29',
        'author' => 'igorw',
        'title' => 'Using Silex',
        'body' => '...',
    ),
);

$app->get('/blog', function () use ($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
        $output .= '<br />';
    }

    return $output;
});

$app->get('/blog/{id}', function (Application $app, $id) use ($blogPosts) {
    if (!isset($blogPosts[$id])) {
        $app->abort(404, "Post $id does not exist.");
    }

    $post = $blogPosts[$id];

    return "<h1>{$post['title']}</h1>" . "<p>{$post['body']}</p>";
});

$app->get('/', function ($name = 'test') use ($app) {
    return 'It works! ' . $app->escape($name);
});

$app->run();
