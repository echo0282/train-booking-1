<?php

use Symfony\Component\HttpFoundation\Request;

// Defining Routes

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

$app->get('/delete/{id}', function (\Silex\Application $app, $id) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->deleteAction($id);
});

$app->get('/config', function (\Silex\Application $app) {
    $tb = new BBC\TrainBooking\TrainBooking($app);
    return $tb->configAction();
});

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->redirect('/', 302);
});
