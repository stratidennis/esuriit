<?php
require "header.php";
include_once "includes/dbh.inc.php";
?>

<main>

    <head>
        <title>Your Profile</title>
        <link rel="stylesheet" href="stylesheetUserPage.css">
        <link rel="stylesheet" href="stylesheetComments.css">
        <link href="https://fonts.googleapis.com/css?family=Indie+Flower&display=swap" rel="stylesheet">
    </head>

    <body>

        <?php
        if (!isset($_SESSION["userId"])) { /*Sending the user back to home page if not loged in*/
            header("Location: index.php");
            exit();
        }
        ?>

        <div class="edit">
            <p class="editp"><a href="userpageEdit.php">Edit Profile</a></p>
        </div>
        <?php
        /*Selecting all data that is required from database in order to be displayed on the user's profile page*/
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        $id = $_SESSION["userId"];
        if (mysqli_num_rows($result) > 0) {
            $sqlImg = "SELECT * FROM profilepictures WHERE userid='$id'";
            $resultImg = mysqli_query($conn, $sqlImg);
            $rowImg = mysqli_fetch_assoc($resultImg);
            $sqlFN = "SELECT fnUsers FROM users WHERE idUsers='$id'";
            $resultFN = mysqli_query($conn, $sqlFN);
            $rowFN = mysqli_fetch_assoc($resultFN);
            $sqlLN = "SELECT lnUsers FROM users WHERE idUsers='$id'";
            $resultLN = mysqli_query($conn, $sqlLN);
            $rowLN = mysqli_fetch_assoc($resultLN);

            /*PROFILE PICTURE*/

            echo "<div id='diamond'>";
            if ($rowImg['status'] == 0) {
                echo "<div><img class='profilepic' src='uploads/profile" . $id . ".jpg?" . mt_rand() . "' alt='Profile picture'></div>";
            } else {
                echo "<div><img class='profilepic' src='uploads/profilepicDEFAULT.jpg' alt='Profile picture'></div>";
            }
            echo "</div>";
            echo "<div class='fullname'>" . $rowFN['fnUsers'] . " " . $rowLN['lnUsers'] . "</div>";
        }

        $sql = "SELECT description FROM profilepictures WHERE userid='$id'";
        $resultDCP = mysqli_query($conn, $sql);
        $rowDCP = mysqli_fetch_assoc($resultDCP);

        /*DESCRIPTION*/

        echo "<div class='description effect descriptionsaved'>";
        echo $rowDCP['description'];
        echo "</div>";

        $sqlIF = "SELECT * FROM posts WHERE userId='$id'";
        $resultIF = mysqli_query($conn, $sqlIF);
        if (mysqli_num_rows($resultIF) != 0) {
            /*ORDER BY(Section)*/
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            echo "
            <form action='includes/sorting.inc.php' method='POST'>
                <div class='sorting'>
                    <label class='textSort' for='toggleSortDropdown'>
                        Order by
                    </label>
                    <input type='checkbox' id='toggleSortDropdown' class='visually-hidden'>
                    <input type='hidden' name='url' value='" . $fullUrl . "'>
                    <ul class='sortDropdown'>
                        <li class='choices'>
                            <input type='radio' id='latest' name='sorting' value='latest' checked='checked'>
                            <label for='latest'>Latest</label>
                        </li>
                        <li class='choices'>
                            <input type='radio' id='oldest' name='sorting' value='oldest'>
                            <label for='oldest'>Oldest</label>
                        </li>
                        <li class='submitSort'>
                            <button type='input' name='sorting_input'>Apply</button>
                        </li>
                    </ul>
                </div>
            </form>
            ";
        }

        /*Here starts the posts section*/

        /*Checking if the user applied any kind of sorting*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($fullUrl, "sortby:latest") == true) {
            $sqlComment = "SELECT * FROM posts WHERE userId='$id' ORDER BY date DESC";
        } else if (strpos($fullUrl, "sortby:oldest") == true) {
            $sqlComment = "SELECT * FROM posts WHERE userId='$id'";
        } else {
            $sqlComment = "SELECT * FROM posts WHERE userId='$id' ORDER BY date DESC";
        }
        $resultComment = mysqli_query($conn, $sqlComment);

        /*Displaying all posts from the database called "posts"*/
        while ($rowComment = mysqli_fetch_assoc($resultComment)) {
            /*STARTING COMMENT SECTION*/
            echo "
            <div class='Comment'>
            ";
            /*TOP SECTION*/
            $userCommentId = $rowComment['userId'];
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
                        <img src='uploads/profile" . $rowComment['userId'] . ".jpg' alt='Profile picture'> <!--PROFILE IMAGE-->
                ";
            }
            $sqlUser = "SELECT * FROM users WHERE idUsers='$userCommentId'";
            $resultUser = mysqli_query($conn, $sqlUser);
            $rowUsers = mysqli_fetch_assoc($resultUser);
            echo "
                <p class='username'>" . $rowUsers['uidUsers'] . "</p> <!--PROFILE Username-->
            ";
            include_once 'includes/timeagoFunction.inc.php';
            echo "
                <p class='date'>" . time_elapsed_string($rowComment['date']) . "</p>
            </div>
            ";
            /*MIDDLE SECTION*/
            echo "
            <div class='middle'>
                <div class='text'>
                    " . make_links_clickable(nl2br($rowComment['postText'])) . "
                </div>
            ";
            if ($rowComment['status'] == 0) {
                echo "
                    <div class='image'>
                        <img src='uploadImagesPosts/post" . $rowComment['id'] . ".jpg' alt='Uploaded picture'>
                    </div>
                ";
            }
            echo "
            </div>
            ";
            /*BOTTOM SECTION - Is shown only if the user posted the comment or the user is admin/moderator*/
            if (isset($_SESSION["userId"])) {
                $id = $_SESSION["userId"];
                if ($rowComment['userId'] == $id) {
                    echo "
                    <div class='bottom'>
                        <form action='includes/deletePost.inc.php' method='POST'>
                            <label for='deletePost" . $rowComment['id'] . "'>
                                <img src='images/othericons/waste.png' alt='trash can' class='waste'>
                            </label>
                            <button id='deletePost" . $rowComment['id'] . "' name='deletePost' class='visually-hidden'></button>
                            <input type='hidden' value='" . $rowComment['id'] . "' name='idOFpost'>
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

        /*This is a function that makes links from the posts clickable*/
        function make_links_clickable($text)
        {
            return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $text);
        }

        ?>
    </body>
</main>