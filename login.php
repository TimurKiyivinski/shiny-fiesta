<?php

include('index.php');
include('models/customer.php');

check_customer_session();

// Check if user submitted form data
if (isset($_POST['email']) &&
    isset($_POST['password'])
) {
    // Check if form data is set
    if (empty($_POST['email']) &&
        empty($_POST['password'])
    ) {
        // Create error variable if form data is empty
        $login_error = "Please fill in all the fields";
    } else {
        // Attempt to login customer
        try {
            $customer = Customer::authenticate($_POST['email'], $_POST['password']);

            // Attempt to create user session
            session_start();
            $_SESSION['customer_id'] = $customer->id;

            // Redirect to booking page
            header("Location: booking.php");
        } catch (Exception $e) {
            // Create error variable if Customer model catches login issues
            $login_error = $e->getMessage();
        }
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
    </head>
    <body>
        <h1>Login to CabsOnline</h1>
        <?php if (isset($login_error)) { ?>
        <p class="error"><?php echo $login_error ?></p>
        <?php } ?>
        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email"></input>
            <label for="password">Password:</label>
            <input type="password" name="password"></input>
            <button type="submit">Log in</button>
        </form>
        <h2>New member?</h2>
        <a href="register.php">Register now</a>
    </body>
</html>
