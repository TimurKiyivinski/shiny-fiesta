<?php

include('models/model.php');

define("DATABASE_ENV", [
    'host' => 'db',
    'database' => 'wad',
    'username' => 'root',
    'password' => 'password'
]);

define("TIMEZONE", "Asia/Kuching");

date_default_timezone_set(TIMEZONE);

function check_customer_session() {
    session_start();
    if (isset($_SESSION['customer_id'])) {
        header("Location: booking.php");
    }
}
