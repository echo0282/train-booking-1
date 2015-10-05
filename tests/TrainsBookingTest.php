<?php

namespace BBC\TrainBooking\Tests;

use Silex\Provider\TwigServiceProvider;
use BBC\TrainBooking\TrainBooking;
use PHPUnit_Framework_TestCase;

class TrainsBookingTest extends PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new \Silex\Application();
        $this->app['bookings.service'] = new Mocks\BookingsServiceMock();

        $this->app->register(new TwigServiceProvider(), [
            'twig.path' => __DIR__.'/../views'
        ]);
    }

    public function testIndexAction()
    {
        $tb = new TrainBooking($this->app);
        $this->assertNotNull($tb->indexAction());
    }

    public function testGetAction()
    {
        $tb = new TrainBooking($this->app);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\Response', $tb->getAction());
    }

    public function testPutAction()
    {
        $tb = new TrainBooking($this->app);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $tb->putAction([0,1]));
    }

    public function testPutActionNoData()
    {
        $tb = new TrainBooking($this->app);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $tb->putAction(""));
    }

    public function testDeleteAction()
    {
        $tb = new TrainBooking($this->app);
        $this->assertNotNull($tb->deleteAction(true));

    }

    public function testDeleteActionNoData()
    {
        $tb = new TrainBooking($this->app);
        $this->assertNotNull($tb->deleteAction(false));
    }

    public function testConfigAction()
    {
        $tb = new TrainBooking($this->app);
        $this->assertInstanceOf('\Symfony\Component\HttpFoundation\JsonResponse', $tb->configAction());
    }
}
