<?php

namespace BBC\TrainBooking;

class Booking implements BookingInterface
{
    private $id;
    private $seatNumbers = [];

    public function __construct($content)
    {
        // Explicit assigning over magic ($this->content = $content) etc
        $this->id = $content->id;
        $this->seatNumbers = $content->seatNumbers;
    }

    public function getBookingID()
    {
        return $this->id;
    }

    public function getSeatNumbers()
    {
        return $this->seatNumbers;
    }
}

