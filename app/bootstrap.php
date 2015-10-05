<?php

use Silex\Provider\TwigServiceProvider;

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../views'
]);

$app['bookings.service'] = new \BBC\TrainBooking\BookingsService();
