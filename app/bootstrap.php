<?php

use Silex\Provider\TwigServiceProvider;

// Register Twig

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../views'
]);

// Register Bookings Service

$app['bookings.service'] = new \BBC\TrainBooking\BookingsService();
