<?php

namespace BBC\TrainBooking\Tests;

use BBC\TrainBooking\Booking;
use BBC\TrainBooking\BookingsService;
use PHPUnit_Framework_TestCase;

class BookingsServiceTest extends PHPUnit_Framework_TestCase
{
    public function testTransform()
    {
        $bs = new BookingsService();

        $bookings = $this->readAttribute($bs, 'bookings');
        $bookings = array(
            new Booking(json_decode('{"id": "1", "seatNumbers": [0, 1]}')),
            new Booking(json_decode('{"id": "2", "seatNumbers": [2, 3]}'))
        );

        $this->assertNotNull($bs->transform());
    }

    public function testVerifyArray()
    {
        $bs = new BookingsService();

        $this->assertTrue($bs->verify([]));
    }

    public function testVerifyNonArray()
    {
        $bs = new BookingsService();

        $this->assertFalse($bs->verify("string"));
    }

    public function testSanitise()
    {
        $bs = new BookingsService();

        $this->assertEquals([0, 2], $bs->sanitise([0, 2]));
    }
}