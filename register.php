<?php

include('index.php');
include('models/customer.php');

check_customer_session();

// Check if user submitted form data
if (isset($_POST['name']) &&
    isset($_POST['password']) &&
    isset($_POST['confirm_password']) &&
    isset($_POST['email']) &&
    isset($_POST['phone'])
) {
    // Check if form data is set
    if (empty($_POST['name']) &&
        empty($_POST['password']) &&
        empty($_POST['confirm_password']) &&
        empty($_POST['email']) &&
        empty($_POST['phone'])
    ) {
        // Create error variable if form data is empty
        $register_error = "Please fill in all the fields";
    } else if ($_POST['password'] === $_POST['confirm_password']) {
        // Attempt to register customer
        try {
            $customer = Customer::create($_POST['email'], $_POST['name'], $_POST['password'], $_POST['phone']);

            // Attempt to create user session
            $_SESSION['customer_id'] = $customer->id;

            // Redirect to booking page
            header("Location: booking.php");
        } catch (Exception $e) {
            // Create error variable if Customer model catches registration issues
            $register_error = $e->getMessage();
        }
    } else {
        // Create error variable if passwords do not match
        $register_error = "Passwords do not match";
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
    </head>
    <body>
        <h1>Register to CabsOnline</h1>
        <p class="instruction">Please fill the fields to complete your registration</p>
        <?php if (isset($register_error)) { ?>
        <p class="error"><?php echo $register_error ?></p>
        <?php } ?>
        <form method="post">
            <label for="name">Name:</label>
            <input type="text" name="name"></input>
            <label for="password">Password:</label>
            <input type="password" name="password"></input>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password"></input>
            <label for="email">Email:</label>
            <input type="email" name="email"></input>
            <label for="phone">Phone:</phone>
            <input type="text" name="phone"></input>
            <button type="submit">Register</button>
        </form>
        <h2>Already registered?</h2>
        <a href="login.php">Login here</a>
    </body>
</html>
