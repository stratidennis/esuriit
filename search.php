<?php
require 'header.php';
?>

<main>

    <head>
        <link rel='stylesheet' href='stylesheet_search.css'>
        <link rel="stylesheet" href="stylesheetComments.css">
        <link href="https://fonts.googleapis.com/css?family=Coda&display=swap" rel="stylesheet">
    </head>

    <body>

        <form action='search.php' method='POST'>
            <div class='searchbar'>
                <input type='text' name='searchinput'>
                <button type='submit' name='submit'>
                    <img src='images/othericons/search.png' alt='search button'>
                </button>
            </div>
            <div class='options'>
                <input type='radio' name='searchby' id='byusername' class='visually-hidden' value='byusername' checked='checked'>
                <div class='eachoption byusername'>
                    <label for='byusername'>By username</label>
                </div>
                <input type='radio' name='searchby' id='bycontent' class='visually-hidden' value='bycontent'>
                <div class='eachoption bycontent'>
                    <label for='bycontent'>By post content</label>
                </div>
            </div>
        </form>

        <?php
        /*Displaying comments regarding the search effectuated*/
        require "includes/dbh.inc.php";

        if (isset($_POST['submit'])) {

            $numberofresults = 0;
            $search = $_POST['searchinput'];
            $searchBY = $_POST['searchby'];

            if ($searchBY == 'byusername') { /*Displaying the search if the search was done by username*/
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $username = $row['uidUsers'];
                    if (strpos($username, $search) !== false) {
                        $numberofresults = $numberofresults + 1;
                        $idUser = $row['idUsers'];
                        $sqlPost = "SELECT * FROM posts WHERE userId='$idUser' ORDER BY date DESC";
                        $resultPost = mysqli_query($conn, $sqlPost);
                        while ($rowPost = mysqli_fetch_assoc($resultPost)) {
                            /*STARTING COMMENT SECTION*/
                            echo "
                                <div class='Comment'>
                            ";
                            /*TOP SECTION*/
                            $userCommentId = $idUser;
                            $sqlCheckProPic = "SELECT status FROM profilepictures WHERE userid='$userCommentId'";
                            $resultCheckProPic = mysqli_query($conn, $sqlCheckProPic);
                            $rowCheckProPic = mysqli_fetch_assoc($resultCheckProPic);
                            if ($rowCheckProPic['status'] == 1) {
                                echo "
                                    <div class='top'>
                                        <img src='uploads/profilepicDEFAULT.jpg' alt='Profile picture'> <!--PROFILE IMAGE-->
                                ";
                            } else {
                                echo "
                                    <div class='top'>
                                        <img src='uploads/profile" . $idUser . ".jpg' alt='Profile picture'> <!--PROFILE IMAGE-->
                                ";
                            }
                            echo "
                                <p class='username'>" . $row['uidUsers'] . "</p> <!--PROFILE Username-->
                            ";
                            include_once 'includes/timeagoFunction.inc.php';
                            echo "
                                    <p class='date'>" . time_elapsed_string($rowPost['date']) . "</p>
                                </div>
                            ";
                            /*MIDDLE SECTION*/
                            echo "
                                <div class='middle'>
                                    <div class='text'>
                                        " . make_links_clickable(nl2br($rowPost['postText'])) . "
                                    </div>
                            ";
                            if ($rowPost['status'] == 0) {
                                echo "
                                    <div class='image'>
                                        <img src='uploadImagesPosts/post" . $rowPost['id'] . ".jpg' alt='Uploaded picture'>
                                    </div>
                                ";
                            }
                            echo "
                                </div>
                            ";
                            /*BOTTOM SECTION - Is shown only if the user posted the comment or the user is admin/moderator*/
                            if (isset($_SESSION["userId"])) {
                                $id = $_SESSION["userId"];
                                $sqlPower = "SELECT rankUsers FROM users WHERE idUsers='$id'";
                                $resultPower = mysqli_query($conn, $sqlPower);
                                $rowPower = mysqli_fetch_assoc($resultPower);
                                if ($rowPost['userId'] == $id || $rowPower['rankUsers'] == 'admin' || $rowPower['rankUsers'] == 'mod') {
                                    echo "
                                        <div class='bottom'>
                                            <form action='includes/deletePost.inc.php' method='POST'>
                                                <label for='deletePost" . $rowPost['id'] . "'>
                                                    <img src='images/othericons/waste.png' alt='trash can' class='waste'>
                                                </label>
                                                <button id='deletePost" . $rowPost['id'] . "' name='deletePost' class='visually-hidden'></button>
                                                <input type='hidden' value='" . $rowPost['id'] . "' name='idOFpost'>
                                            </form>
                                        </div>
                                    ";
                                }
                            }
                            /*CLOSING COMMENT SECTION*/
                            echo "
                                </div>
                            ";
                        }
                    }
                }
            } else if ($searchBY == 'bycontent') { /*Displaying the search if the search was done by post content*/
                $sql = "SELECT * FROM posts";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $content = $row['postText'];
                    if (strpos($content, $search) !== false) {
                        $numberofresults = $numberofresults + 1;
                        $USERID = $row['userId'];
                        $sqlUser = "SELECT * FROM users WHERE idUsers='$USERID'";
                        $resultUser = mysqli_query($conn, $sqlUser);
                        $rowUser = mysqli_fetch_assoc($resultUser);
                        /*STARTING COMMENT SECTION*/
                        echo "
                            <div class='Comment'>
                        ";
                        /*TOP SECTION*/
                        $userCommentId = $rowUser['idUsers'];
                        $sqlCheckProPic = "SELECT status FROM profilepictures WHERE userid='$userCommentId'";
                        $resultCheckProPic = mysqli_query($conn, $sqlCheckProPic);
                        $rowCheckProPic = mysqli_fetch_assoc($resultCheckProPic);
                        if ($rowCheckProPic['status'] == 1) {
                            echo "
                                <div class='top'>
                                    <img src='uploads/profilepicDEFAULT.jpg' alt='Profile picture'> <!--PROFILE IMAGE-->
                            ";
                        } else {
                            echo "
                                <div class='top'>
                                    <img src='uploads/profile" . $rowUser['idUsers'] . ".jpg' alt='Profile picture'> <!--PROFILE IMAGE-->
                            ";
                        }
                        echo "
                            <p class='username'>" . $rowUser['uidUsers'] . "</p> <!--PROFILE Username-->
                        ";
                        include_once 'includes/timeagoFunction.inc.php';
                        echo "
                                <p class='date'>" . time_elapsed_string($row['date']) . "</p>
                            </div>
                        ";
                        /*MIDDLE SECTION*/
                        echo "
                            <div class='middle'>
                                <div class='text'>
                                    " . make_links_clickable(nl2br($row['postText'])) . "
                                </div>
                        ";
                        if ($row['status'] == 0) {
                            echo "
                                <div class='image'>
                                    <img src='uploadImagesPosts/post" . $row['id'] . ".jpg' alt='Uploaded picture'>
                                </div>
                            ";
                        }
                        echo "
                            </div>
                        ";
                        /*BOTTOM SECTION - Is shown only if the user posted the comment or the user is admin/moderator*/
                        if (isset($_SESSION["userId"])) {
                            $id = $_SESSION["userId"];
                            $sqlPower = "SELECT rankUsers FROM users WHERE idUsers='$id'";
                            $resultPower = mysqli_query($conn, $sqlPower);
                            $rowPower = mysqli_fetch_assoc($resultPower);
                            if ($row['userId'] == $id || $rowPower['rankUsers'] == 'admin' || $rowPower['rankUsers'] == 'mod') {
                                echo "
                                    <div class='bottom'>
                                        <form action='includes/deletePost.inc.php' method='POST'>
                                            <label for='deletePost" . $row['id'] . "'>
                                                <img src='images/othericons/waste.png' alt='trash can' class='waste'>
                                            </label>
                                            <button id='deletePost" . $row['id'] . "' name='deletePost' class='visually-hidden'></button>
                                            <input type='hidden' value='" . $row['id'] . "' name='idOFpost'>
                                        </form>
                                    </div>
                                ";
                            }
                        }
                        /*CLOSING COMMENT SECTION*/
                        echo "
                            </div>
                        ";
                    }
                }
            }

            if ($numberofresults == 0) {
                echo "
                    <p class='sorry'>No results have been found...</p>
                ";
            }
        }

        /*This is a function that makes links from the posts clickable*/
        function make_links_clickable($text)
        {
            return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $text);
        }

        ?>

    </body>

</main>