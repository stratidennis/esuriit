<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylesheet_login_register.css">
    <link href="https://fonts.googleapis.com/css?family=Coda&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
</head>

<body>
    <header>
        <nav>
            <a href="index.php">
                <img src="images/header.icons/Esuriiit_logo.png">
            </a>
        </nav>
    </header>
    <div class="welcome">
        <h1>WELCOME TO ESURIIT!</h1>
    </div>
    <div class="login">
        <p class="plogin">Login</p>
        <form action="includes/login.inc.php" method="post">
            <ul class="log_in">
                <li><input type="text" name="mail" placeholder="Email"></li>
                <li><input class="password" type="password" name="pwd" placeholder="Password" autocomplete="off"></li>
            </ul>
            <?php

            /*Displaying errors if necessary*/
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if (strpos($fullUrl, "error=emptyfields") == true) {
                echo "<p class='error'>You did not fill in all fields!</p>";
            } elseif (strpos($fullUrl, "error=invalidinput") == true) {
                echo "<p class='error'>User does not exist!</p>";
            } elseif (strpos($fullUrl, "error=wrongpassword") == true) {
                echo "<p class='error'>Wrong password!</p>";
            } elseif (strpos($fullUrl, "error=sqlerror") == true) {
                echo "<p class='error'>Something went wrong! Please try again.</p>";
            } elseif (strpos($fullUrl, "register=succes") == true) {
                echo "<p class='succes'>You have been registered successfully!<br/>Please log in.</p>";
            }

            ?>
            <button class="submit" type="submit" name="submit-login">Submit</button>
        </form>
    </div>
    <div class="or">
        <p>or</p>
    </div>
    <div class="guest">
        <a href="index.php">
            <button>Browse as Guest</button>
        </a>
    </div>
    <div class="registeraccount">
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</body>

</html>