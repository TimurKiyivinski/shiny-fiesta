<?php

include('index.php');
include('models/booking.php');

// Check if customer is logged in
session_start();
if (! isset($_SESSION['customer_id'])) {
    header("Location: login.php");
}

// Check if user submitted form data
if (isset($_POST['name']) &&
    isset($_POST['phone']) &&
    isset($_POST['unit_number']) &&
    isset($_POST['street_number']) &&
    isset($_POST['street_name']) &&
    isset($_POST['suburb']) &&
    isset($_POST['destination_suburb']) &&
    isset($_POST['date']) &&
    isset($_POST['time'])
) {
    // Check if form data is set
    if (empty($_POST['name']) &&
        empty($_POST['phone']) &&
        empty($_POST['unit_number']) &&
        empty($_POST['street_number']) &&
        empty($_POST['street_name']) &&
        empty($_POST['suburb']) &&
        empty($_POST['destination_suburb']) &&
        empty($_POST['date']) &&
        empty($_POST['time'])
    ) {
        // Create error variable if form data is empty
        $booking_error = "Please fill in all the fields";
    } else {
        try {
            $address = [
                'unit_number' => $_POST['unit_number'],
                'street_number' => $_POST['street_number'],
                'street_name' => $_POST['street_name'],
                'suburb' => $_POST['suburb']
            ];

            $pickup = [
                'destination_suburb' => $_POST['destination_suburb'],
                'date' => $_POST['date'],
                'time' => $_POST['time']
            ];

            $booking = Booking::create($_SESSION['customer_id'], $_POST['name'], $_POST['phone'], $address, $pickup);
        } catch (Exception $e) {
            // Create error variable if Booking model catches booking issues
            $booking_error = $e->getMessage();
        }
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
    </head>
    <body>
        <a href="logout.php" class="logout">Log Out</a>
        <h1>Book a cab</h1>
        <p class="instruction">Please fill the fields to book a cab</p>
        <?php if (isset($booking_error)) { ?>
        <p class="error"><?php echo $booking_error ?></p>
        <?php } else if (isset($booking)) { ?>
        <p class="message">Thank you! Your booking reference number is <?php echo $booking->id ?></p>
        <p class="message">We will pick up the passengers in front of your provided address at <?php echo $booking->time ?> on <?php echo $booking->date ?></p>
        <?php } ?>
        <form method="post">
            <label for="name">Passenger Name:</label>
            <input type="text" name="name"></input>
            <label for="phone">Passenger Phone:</phone>
            <input type="text" name="phone"></input>
            <h3>Pick up address</h3>
            <label for="unit_number">Unit Number:</label>
            <input type="text" name="unit_number"></input>
            <label for="street_number">Street Number:</label>
            <input type="text" name="street_number"></input>
            <label for="street_name">Street Name:</label>
            <input type="text" name="street_name"></input>
            <label for="suburb">Suburb:</label>
            <input type="text" name="suburb"></input>
            <h3>Destination</h3>
            <label for="destination_suburb">Destination Suburb:</label>
            <input type="text" name="destination_suburb"></input>
            <label for="date">Pickup Date: <i>Year-Month-Date</i></label>
            <input type="text" name="date" value="<?php echo date("Y-m-d") ?>"></input>
            <label for="time">Pickup Time: <i>24 hour format</i></label>
            <input type="text" name="time" value="<?php echo date("H:i") ?>"></input>
            <button type="submit">Book</button>
        </form>
    </body>
</html>
