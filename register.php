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
