<?php

use BBC\TrainBooking\Application;

require_once __DIR__.'/../vendor/autoload.php';
$app = new Application();
$app['debug'] = true;

include(__DIR__.'../../app/bootstrap.php');
require(__DIR__.'../../app/routes.php');

$app->run();
