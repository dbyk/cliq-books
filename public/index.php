<?php

use App\Controllers\Api\Books\Delete;
use App\Controllers\Api\Books\Get;
use App\Controllers\Api\Books\GetList;
use App\Controllers\Api\Books\Patch;
use App\Controllers\Api\Books\Post;
use Phalcon\Autoload\Loader;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

require __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->setNamespaces(
    [
        'App\Models' => __DIR__ . '/models/',
    ]
);
$loader->register();

$container = new FactoryDefault();
// todo move to .env
$container->set(
    'db',
    function () {
        return new PdoMysql(
            [
                'host' => 'mysql',
                'username' => 'root',
                'password' => 'root',
                'dbname' => 'cliq-books',
            ]
        );
    }
);

$app = new Micro($container);

// For simplicity all
$app->get(
    '/api/books',
    function () use ($app) {
        return GetList::exec($app);
    }
);

$app->get(
    '/api/books/{id:[0-9]+}',
    function ($id) use ($app) {
        return Get::exec($app, $id);
    }
);

$app->post(
    '/api/books',
    function () use ($app) {
        return Post::exec($app);
    }
);

$app->patch(
    '/api/books/{id:[0-9]+}',
    function ($id) use ($app) {
        return Patch::exec($app, $id);
    }
);

$app->delete(
    '/api/books/{id:[0-9]+}',
    function ($id) use ($app) {
        return Delete::exec($app, $id);
    }
);

$app->get(
    '/',
    function () {
        return $this
            ->response
            ->setJsonContent([
                'status' => 'Working',
                'message' => 'Please see the docs'
            ]);
    }
);

$app->handle($_SERVER["REQUEST_URI"]);