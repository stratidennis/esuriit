<?php
session_start();
include_once "includes/dbh.inc.php";
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel='stylesheet' href='stylesheet.css'>
    <link rel='shortcut icon' type='image/x-icon' href='favicon.ico'>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
</head>

<body>
    <header>
        <nav>
            <ul class='header'>
                <div>
                    <!--A LIST WITH ALL THE IMAGES IN THE HEADER-->
                    <li class='home'><a href='index.php'><img src='images/header.icons/housenew.png'></a></li>
                    <li class='search'><a href='search.php'><img src='images/header.icons/loupenew.png'></a></li>
                    <li class='network'><a href='powerusers.php'><img src='images/header.icons/networknew.png'></a></li>
                    <li class='minigames'><a href='minigames.php'><img src='images/header.icons/joystick.png'></a></li>
                    <li class='info'><a href='about.php'><img src='images/header.icons/info.png'></a></li>
                    <?php
                    /*CHECKING WHETER USER IS LOGED IN OR NOT*/
                    if (isset($_SESSION["userId"])) {
                        /*IF USER IS LOGED IN, DEPENDING ON THE GENDER, A PROFILE ICON IS DISPLAYED*/
                        $id = $_SESSION["userId"];
                        $sql = "SELECT genderUsers FROM users WHERE idUsers='$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        echo "
                            <li class='account'>
                                <label class='accountLabel' for='toggle'>
                        ";
                                    if ($row['genderUsers'] == 'male') { /*Checking the gender*/
                                        echo "
                                            <img src='images/header.icons/man.png'>
                                        ";
                                    } else {
                                        echo "
                                            <img src='images/header.icons/girl.png'>
                                        ";
                                    }
                        /*Displaying a drop-down menu that has a button that redirects the user to his profile page and a disconnect button*/
                        echo "            
                                </label>
                                <input type='checkbox' id='toggle' class='visually-hidden'>
                                <ul class='dropdown'> 
                                    <li><a href='userpage.php'>My account</a></li>
                                    <li class='logout'>
                                        <label for='logout'>Disconnect</label>
                                        <form action='includes/logout.inc.php' method='post'>
                                            <button id='logout' type='submit' name='submit-logout' class='visually-hidden'></button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        ";
                    } else { /*If user is not loged in, then a different icon is diplayed which, when pressed, redirects the user to the login page*/
                        echo "
                            <li class='login'>
                                <a href='login.php'>
                                    <img src='images/header.icons/SIGNUP.png'>
                                </a>
                            </li>
                        ";
                    }
                    ?>
                </div>
            </ul>
        </nav>
    </header>
</body>

</html>