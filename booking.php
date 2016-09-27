<?php

// Check if customer is logged in
session_start();
if (! isset($_SESSION_['customer_id'])) {
    header("Location: login.php");
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
        <h1>Book a cab</h1>
        <p class="instruction">Please fill the fields to book a cab</p>
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
            <label for="destination">Destination Suburb:</label>
            <input type="text" name="destination"></input>
            <label for="date">Pickup Date:</label>
            <input type="text" name="date"></input>
            <label for="time">Pickup Time:</label>
            <input type="text" name="time"></input>
            <button type="submit">Book</button>
        </form>
    </body>
</html>
