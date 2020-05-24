<?php

// Contains Login/Register Form
// Checks for valid session
// Reauthenticates if session variable is active
include 'connection.php';
$CONN = dbConnection();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>UCF Contacts Login</title>
        <link rel="stylesheet" type="text/css" href="CSS/normalize.css">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <body>
        <div class="login-background">
            <div class="login-box">
                <img src="CSS/Logo.png" class="logo">
				<h1>Sign In</h1>
                <form action="register.php" method="post">
                    <div class="input-box">
                        <label>Username</label>
                        <input type="text" name="Username" required="">

                    </div>
					 <div class="input-box">
                        <label>Email</label>
                        <input type="text" name="Email" required="">

                    </div>
                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" name="Password" required="">

                    </div>
                    <input type="submit" name="" value="Submit">
                </form>
            </div>
        </div>
    </body>
    </head>
</html>
