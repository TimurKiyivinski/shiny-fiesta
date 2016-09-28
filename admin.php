<?php

include('index.php');
include('models/customer.php');
include('models/booking.php');

// Check if customer is logged in
session_start();
if (! isset($_SESSION['customer_id'])) {
    header("Location: login.php");
}

$customer = Customer::find($_SESSION['customer_id']);
if ($customer->role !== "admin") {
    header("Location: login.php");
}

if (isset($_POST['reference'])) {
    try {
        Booking::assign($_POST['reference']);
    } catch (Exception $e) {
        $admin_error = $e->getMessage();
    }
}

function nearby_bookings() {
    $bookings = [];
    $get_bookings =  (new Booking)->where('assigned', 'unassigned')->get();
    // Sort bookings into an array based on what the model returns
    if (count($get_bookings) == 1) {
        if (! is_object($get_bookings)) {
            return [];
        }
        $bookings[] = $get_bookings;
    } else if (count($get_bookings) > 1) {
        $bookings = $get_bookings;
    } else {
        return [];
    }

    // Create array for nearby bookings
    $near_bookings = [];
    foreach ($bookings as $booking) {
        $now = new DateTime();
        $pickup_time = new DateTime($booking->date . " " . $booking->time);
        $time_diff = $pickup_time->diff($now);
        // Only add pickups in under 3 hours from now
        if ($time_diff->h < 3) {
            $booking->customer = Customer::find($booking->customer_id);
            // Format address
            if (empty($booking->unit_number)) {
                $booking->address = $booking->unit_number . "/" . $booking->street_number;
            } else {
                $booking->address = $booking->unit_number;
            }
            $booking->address .= " " . $booking->street_name . ", " . $booking->suburb;

            $near_bookings[] = $booking;
        }
    }
    return $near_bookings;
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
    </head>
    <body>
        <a href="booking.php" class="admin">Book</a>
        <a href="logout.php" class="logout">Log Out</a>
        <h1>CabsOnline Admin Page</h1>
        <h3>1. Click button to search for all unassigned booking requests in the next 2 hours</h3>
        <?php if (isset($_POST['list'])) { ?>
        <table>
            <tr>
                <td>Reference</td>
                <td>Customer Name</td>
                <td>Passenger Name</td>
                <td>Passenger Phone</td>
                <td>Pick up Address</td>
                <td>Destination Suburb</td>
                <td>Pick time</td>
            </tr>
            <?php foreach (nearby_bookings() as $booking) { ?>
            <tr>
                <td><?php echo $booking->id ?></td>
                <td><?php echo $booking->customer->name ?></td>
                <td><?php echo $booking->name ?></td>
                <td><?php echo $booking->phone ?></td>
                <td><?php echo $booking->address ?></td>
                <td><?php echo $booking->destination_suburb ?></td>
                <td><?php echo $booking->time ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
        <form method="post">
            <input type="hidden" name="list"></input>
            <button class="nofloat" type="submit">List all</button>
        </form>
        <h3>2. Input reference number below and click "update" button to assign taxi</h3>
        <?php if (isset($admin_error)) { ?>
        <p class="error"><?php echo $admin_error ?></p>
        <?php } ?>
        <form method="post">
            <label for="reference">Reference number:</label>
            <input type="text" name="reference"></input>
            <button type="submit">Update</button>
        </form>
    </body>
</html>
