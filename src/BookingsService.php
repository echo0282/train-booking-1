<?php

namespace BBC\TrainBooking;

/**
 * Bookings Service class which deals with handling the endpoints
 *
 * Class BookingsService
 * @package BBC\TrainBooking
 */
class BookingsService
{
    protected $bookingJSON;

    /* @var Booking[]   $bookings */
    protected $bookings = [];

    public function __construct()
    {
        $this->read();
    }

    /**
     * Get the Bookings
     *
     * @codeCoverageIgnore
     * @return Booking[]
     */
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

    /**
     * Put a booking into the data store
     *
     * @param $seatNumbers
     * @codeCoverageIgnore
     */
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

    /**
     * Delete a booking from the data store
     *
     * @param $bookingID
     * @return bool
     * @codeCoverageIgnore
     */
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

    /**
     * Transform a booking into a string
     *
     * @return string
     */
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

    /**
     * Verify that the data is correct
     *
     * @param $data
     * @return bool
     */
    public function verify($data)
    {
        if (is_array($data)) {
            return true;
        }

        return false;
    }

    /**
     * Sanitise the data before we store it
     *
     * @param $data
     * @return mixed
     */
    public function sanitise($data)
    {
        foreach ($data as $bookingID) {
            filter_var((int) $bookingID, FILTER_SANITIZE_NUMBER_INT);
        }

        return $data;
    }

    /**
     * Read the data from the file
     *
     * @codeCoverageIgnore
     */
    protected function read()
    {
        $bookingsJSONDIR = __DIR__."/../app/data/bookings.json";

        if (file_exists($bookingsJSONDIR)) {
            $json = file_get_contents($bookingsJSONDIR);
            $this->bookingJSON = json_decode($json);
        }
    }

    /**
     * Write the data to the file
     *
     * @codeCoverageIgnore
     */
    protected function write()
    {
        $bookingsJSONDIR = __DIR__."/../app/data/bookings.json";

        if (file_exists($bookingsJSONDIR)) {
            file_put_contents($bookingsJSONDIR, $this->transform());
        }
    }
}
