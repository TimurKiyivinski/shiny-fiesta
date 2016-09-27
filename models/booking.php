<?php

class Booking extends Model {
    public static function create($customer_id, $name, $phone, $address, $pickup) {
        $booking = new Booking();

        // Check if unit number is valid
        if (! filter_var($address['unit_number'], FILTER_VALIDATE_INT)) {
            throw new Exception("Invalid unit number");
        }

        // Check if street number is valid
        if (! filter_var($address['street_number'], FILTER_VALIDATE_INT)) {
            throw new Exception("Invalid street number");
        }

        // Validate date & time
        $date_time = DateTime::createFromFormat('Y-m-d', $pickup['date']);

        // Check if date is valid
        if (date("Y-m-d", strtotime($data)) === $data) {
            throw new Exception("Invalid date format");
        }

        // Check if time is valid
        if (strtotime($pickup['time']) == false) {
            throw new Exception("Invalid time format");
        }
        
        // Check time difference
        $now = new DateTime();
        $pickup_time = new DateTime($pickup['date'] . " " . $pickup['time']);
        $time_diff = $pickup_time->diff($now);
        if ($time_diff->h < 1) {
            throw new Exception("Time needs to be at least 1 hour in advance");
        }

        // Set booking data
        $booking->customer_id = $customer_id; // Foreign key
        $booking->name = $name;
        $booking->phone = $phone;
        $booking->unit_number = $address['unit_number'];
        $booking->street_number = $address['street_number'];
        $booking->street_name = $address['street_name'];
        $booking->suburb = $address['suburb'];
        $booking->destination_suburb = $pickup['destination_suburb'];
        $booking->date = $pickup['date'];
        $booking->time = $pickup['time'];
        $booking->assigned = "unassigned";
        //$booking->save();

        return $booking;
    }

    public static function assign($id) {
        $booking = Booking::find($id);
        if (! is_object($booking)) {
            throw new Exception("No booking with id $id found");
        }

        $booking->assigned = "assigned";
        $booking->update();
    }
}
