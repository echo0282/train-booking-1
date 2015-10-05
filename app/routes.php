<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function (\Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->indexAction();
});

$app->get('/get', function (\Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->getAction();
});

$app->post('/post', function (Request $request, \Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->putAction($request->get('choices'));
});

$app->get('/delete', function (Request $request, \Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->deleteAction($request->get('id'));
});

$app->get('/config', function (\Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->configAction();
});



