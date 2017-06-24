<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/../engine/models/db.php';
require __DIR__ . '/../engine/models/entity.php';
require __DIR__ . '/../engine/UploadHandler.php';

require __DIR__ . '/../engine/models/admin.php';
require __DIR__ . '/../engine/models/adminIndex.php';
require __DIR__ . '/../engine/models/adminCategories.php';
require __DIR__ . '/../engine/models/adminArticles.php';

require __DIR__ . '/../engine/MainController.php';
require __DIR__ . '/../engine/AdminController.php';
require __DIR__ . '/../engine/auth.php';


// init slim

$app = new \Slim\App($config);
$container = $app->getContainer();


// init db

db::setConfig(
    'mysql:host=' . $container['settings']['db']['host'] . ';dbname=' . $container['settings']['db']['name'] . ';charset=utf8',
    $container['settings']['db']['user'],
    $container['settings']['db']['pass']
);

// add containers

$container['logger'] = function ($c) {
    // create a log channel
    $log = new \Monolog\Logger($c['settings']['logger']['name']);
    $log->pushHandler(new \Monolog\Handler\StreamHandler($c['settings']['logger']['path'], $c['settings']['logger']['level']));
    return $log;
};


$container['db'] = function () {
    $pdo = db::getInstance();
    return $pdo->getConnection();
};

// configure twig

$twig_functions = [
    'date' => function ($arg) {
        return date('d.m.Y', $arg);
    }
];

$container['twig'] = new Twig_Environment(
    new Twig_Loader_Filesystem($container->get('settings')['twig']['template']),
    $container->get('settings')['twig']['settings']
);

foreach ($twig_functions as $name => $func){
    $container['twig']->addFunction(new Twig_SimpleFunction($name, $func));
}

// add routes
foreach ($config['routes'] as $name => $item)
    if (isset($item['needAuth']) AND $item['needAuth'])
        $app->map(['GET', 'POST'], $item['path'], $item['action'])->setName($name)->add(new AuthTest($container));
    else
        $app->map([$item['method']], $item['path'], $item['action'])->setName($name);