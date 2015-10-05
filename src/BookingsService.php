<?php

namespace BBC\TrainBooking;

class BookingsService
{
    private $bookingJSON;

    /* @var Booking[]   $bookings */
    private $bookings = [];

    public function __construct()
    {
        $this->read();
    }

    public function get()
    {
        if (empty($this->bookings)) {
            if ($this->bookingJSON) {
                foreach ($this->bookingJSON->bookings as $booking) {
                    $this->bookings[] = new Booking($booking);
                }
            }
        }

        return $this->bookings;
    }

    public function put($seatNumbers)
    {
        $bookingJson = (object) array(
            "id"    => (int) time(),
            "seatNumbers" => $seatNumbers
        );

        $this->bookings = $this->get();
        $booking = new Booking($bookingJson);
        $this->bookings[] = $booking;

        $this->write();

    }

    public function delete($bookingID)
    {
        if ($this->get()) {
            foreach ($this->get() as $key => $bookings) {
                if ($bookings->getBookingID() === (int) $bookingID) {
                    unset($this->bookings[$key]);
                    $this->write();

                    return true;
                }
            }
        }

        return false;
    }

    public function transform()
    {
        $allBookings = [];

        foreach ($this->bookings as $booking) {
            $allBookings[] = (object) array(
                "id" => $booking->getBookingID(),
                "seatNumbers" => $booking->getSeatNumbers()
            );
        }

        return json_encode(array(
            "bookings" => $allBookings
        ));
    }

    public function verify($data)
    {
        if (is_array($data)) {
            return true;
        }

        return false;
    }

    public function sanitise($data)
    {
        foreach ($data as $bookingID) {
            filter_var((int) $bookingID, FILTER_SANITIZE_NUMBER_INT);
        }

        return $data;
    }

    protected function read()
    {
        $bookingsJSONDIR = __DIR__."/../app/data/bookings.json";

        if (file_exists($bookingsJSONDIR)) {
            $json = file_get_contents($bookingsJSONDIR);
            $this->bookingJSON = json_decode($json);
        }
    }

    protected function write()
    {
        $bookingsJSONDIR = __DIR__."/../app/data/bookings.json";

        if (file_exists($bookingsJSONDIR)) {
            file_put_contents($bookingsJSONDIR, $this->transform());
        }
    }
}
