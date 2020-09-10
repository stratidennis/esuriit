<?php
require "header.php";
?>

<main>

    <head>
        <link rel="stylesheet" href="stylesheet_powerusers.css">
        <link href="https://fonts.googleapis.com/css?family=Coda&display=swap" rel="stylesheet">
    </head>

    <body>

        <?php
        if (isset($_SESSION["userId"])) {
            echo "
                    <h1>Welcome to the power users page!</h1>
                    <div class='password'>
                        <p class='info'>You must first enter the password to acces this page.</p>
                        <!-- THE PASSWORD IS 'Copilul1' !!!-->
                        <form action='includes/checkpoweruserspassword.inc.php' method='POST'>
                            <input type='password' name='password'>
                            <button type='submit' name='submit'>
                                Submit
                            </button>
                        </form>
                    </div>
                ";
        } else {
            echo "
                    <p class='notlogedin'>It appears that you are not loged in. </br> Please <a href='login.php'>log in</a> and come back afterwards.</p>
                ";
        }

        /*Displaying errors if necessary*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (strpos($fullUrl, "incorrectpassword") == true) {
            echo "<p class='error'>Incorrect password!</p>";
        } elseif (strpos($fullUrl, "nopeasantsallowed") == true) {
            echo "<p class='error'>Sorry, no peasants allowed!</p>";
        }
        ?>

    </body>

</main>