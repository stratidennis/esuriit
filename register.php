<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="stylesheet_login_register.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Coda&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
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
    <div class="register">
        <p class="pregister">Register</p>
        <!--The form that must be completed by a user in order to be registered-->
        <form action="includes/register.inc.php" method="post">
            <ul class="register_ul">
                <li><input type="text" name="FirstName" placeholder="First Name"></li>
                <li><input type="text" name="LastName" placeholder="Last Name"></li>
                <li><input type="text" name="uid" placeholder="Username"></li>
                <li><input type="text" name="mail" placeholder="Email"></li>
                <li><input class="password" type="password" name="pwd" placeholder="Password" autocomplete="off"></li>
                <li><input class="password" type="password" name="pwd-repeat" placeholder="Repeat Password" autocomplete="off"></li>
            </ul>
            <div class="gender">
                <input type="radio" name="gender" id="male" checked="checked" value="male">
                <label for="male" class="male">
                    <div class="malediv">Male</div>
                </label>
                <input type="radio" name="gender" id="female" value="female">
                <label for="female" class="female">
                    <div>Female</div>
                </label>
            </div>
            <?php

            /*Displaying errors if necessary*/
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if (strpos($fullUrl, "error=emptyfields") == true) {
                echo "<p class='error'>You did not fill in all fields!</p>";
            } elseif (strpos($fullUrl, "error=invalidFirstName") == true) {
                echo "<p class='error'>Invalid first name!</p>";
            } elseif (strpos($fullUrl, "error=invalidLastName") == true) {
                echo "<p class='error'>Invalid last name!</p>";
            } elseif (strpos($fullUrl, "error=invalidusername") == true) {
                echo "<p class='error'>Invalid username!</p>";
            } elseif (strpos($fullUrl, "error=invalidemail") == true) {
                echo "<p class='error'>Invalind email!</p>";
            } elseif (strpos($fullUrl, "error=passwordsdonotmatch") == true) {
                echo "<p class='error'>Passwords do not match!</p>";
            } elseif (strpos($fullUrl, "error=useralredadytaken") == true) {
                echo "<p class='error'>Username already taken!</p>";
            } elseif (strpos($fullUrl, "error=emailalredadyinuse") == true) {
                echo "<p class='error'>Email already in use!</p>";
            } elseif (strpos($fullUrl, "error=sqlerror") == true) {
                echo "<p class='error'>Something went wrong! Please try again.</p>";
            }

            ?>
            <button class="submit" type="submit" name="submit-register">Submit</button>
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
    <div class="loginaccount">
        <p>Have an account? <a href="login.php">Log in</a></p>
    </div>
</body>

</html>