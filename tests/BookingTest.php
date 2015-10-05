<?php

namespace BBC\TrainBooking\Tests;

use BBC\TrainBooking\Booking;
use PHPUnit_Framework_TestCase;

class BookingTest extends PHPUnit_Framework_TestCase
{
    public function testGetBookingID()
    {
        $b = new Booking(json_decode('{"id": "9", "seatNumbers": [0, 1]}'));

        $this->assertEquals("9", $b->getBookingID());
    }

    public function testGetSeatNumbers()
    {
        $b = new Booking(json_decode('{"id": "9", "seatNumbers": [0, 1]}'));

        $this->assertEquals(array(0, 1), $b->getSeatNumbers());
    }
}
