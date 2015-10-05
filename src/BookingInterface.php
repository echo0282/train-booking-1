<?php

namespace BBC\TrainBooking;

/**
 * Interface which is the structure for a booking
 *
 * Interface BookingInterface
 * @package BBC\TrainBooking
 */
interface BookingInterface
{
    public function getBookingID();
    public function getSeatNumbers();
}
