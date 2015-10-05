<?php

namespace BBC\TrainBooking\Tests;

use BBC\TrainBooking\BookingsService;

class BookingsServiceMock extends BookingsService
{
    protected $bookingsString;

    public function delete($success)
    {
        return $success;
    }

    public function read()
    {
        $this->bookingJSON = ($this->bookings);
    }

    public function write()
    {
        $this->bookingsString = $this->transform();
    }
}