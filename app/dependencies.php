<?php
// DIC configuration
$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {

    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {

    $settings = $c->get('settings')['logger'];

    $logger = new Monolog\Logger($settings['name']);

    $logger->pushProcessor(new Monolog\Processor\UidProcessor());

    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

$container['eloquent'] = function($c) {
    
    $settings = $c->get('settings');

    $capsule = new \Illuminate\Database\Capsule\Manager;

    $capsule->addConnection($settings['eloquent']['db1'], 'default');

    $capsule->addConnection($settings['eloquent']['db2'], 'db2');

    $capsule->setAsGlobal();

    $capsule->bootEloquent();

    return $capsule;
};

// csrf
$container['csrf'] = function ($c) {

    return new \Slim\Csrf\Guard;
};

// twig
$container['view'] = function ($c) {

    $settings = $c->get('settings')['twig'];

    $view = new \Slim\Views\Twig($settings['path'], [
        'charset' => 'utf8',
        'cache' => false,
        'autoescape' => true
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    $view->addExtension(new App\Extensions\CsrfExtension($c['csrf']));

    foreach ($settings['allowed_functions'] as $function) {

        if (function_exists($function)) {

            $function = new Twig_SimpleFunction($function, $function, array("is_safe" => array('html')));

            $view->getEnvironment()->addFunction($function);
        }
    }

    return $view;
};

$container['oauth2'] = function ($c) {

    return new \App\OAuth2\SlimOAuth2($c);
};

// controllers
// $container['BlogController'] = function($c) {

//     return new \App\Controllers\BlogController($c);
// };

// db
// $container['db'] = function ($c) {

//     $settings = $c->get('settings')['db'];

//     $pdo = new \PDO('mysql:host='. $settings['host'] .';dbname='. $settings['dbname'], $settings['user'], $settings['pass']);

//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

//     return $pdo;
// };