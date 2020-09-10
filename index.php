<?php
date_default_timezone_set('Europe/Bucharest');
include_once "includes/dbh.inc.php";
require "header.php";
?>

<main>

    <head>
        <link rel="stylesheet" href="stylesheet_index.css">
        <link rel="stylesheet" href="stylesheetComments.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <title>Home</title>
    </head>

    <body>

        <?php

        if (isset($_SESSION["userId"])) { /*Checking if the user is loged in and if so, a box that allows you to post on the website is displayed*/
            echo "
        <div class='addComment'>
            <form action='includes/uploadComment.inc.php' method='POST' enctype='multipart/form-data'>
                <div class='top-row'>
                    <div class='addPost'>Add post</div>
                    <label for='uploadComPic'>
                        <img src='images/othericons/clip.png' alt='Add file'>
                    </label>
                    <input type='file' name='postPicture' id='uploadComPic'>
                </div>
                <input type='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
                <div class='middle-row'>
                    <textarea class='postText' name='postText'></textarea>
                </div> 
                <div class='bottom-row'>
                    <button name='submitPost' type='submit'>Upload post!</button>
                </div>
            </form>
        </div>
        ";

            /*DISPLAYING ERRORS IF NECESSARY*/
            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (strpos($fullUrl, "error:noTextIntroduced") == true) {
                echo "<p class='error'>No text inserted!</p>";
            } elseif (strpos($fullUrl, "error:invalidcharactersinPost") == true) {
                echo "<p class='error'>Invalid characters!</p>";
            } elseif (strpos($fullUrl, "error:over400characters") == true) {
                echo "<p class='error'>Too many characters!</p>";
            } elseif (strpos($fullUrl, "error:filetypenotallowed") == true) {
                echo "<p class='error'>The selected file is not allowed!</p>";
            } elseif (strpos($fullUrl, "error:sqlProPic") == true || strpos($fullUrl, "error:tryagain") == true) {
                echo "<p class='error'>The image couldn't be uploaded!</p>";
            } elseif (strpos($fullUrl, "error:fileistoolarge") == true) {
                echo "<p class='error'>The image size is too big!</p>";
            }
        }

        ?>

        <!--ORDER BY(Section)-->

        <form action='includes/sorting.inc.php' method='POST'>
            <?php
                if (isset($_SESSION["userId"])) {
                    echo "
                        <div class='sorting'>
                    ";
                } else {
                    echo "
                        <div class='sorting2'>
                    ";
                }
            ?>
                <label class='textSort' for='toggleSortDropdown'>
                    Order by
                </label>
                <input type='checkbox' id='toggleSortDropdown' class='visually-hidden'>
                <?php
                $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                echo "
                    <input type='hidden' name='url' value='" . $fullUrl . "'>
                ";
                ?>
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

        <?php

        /*Checking if the user applied any kind of sorting*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($fullUrl, "sortby:latest") == true) {
            $sqlComment = "SELECT * FROM posts ORDER BY date DESC";
        } else if (strpos($fullUrl, "sortby:oldest") == true) {
            $sqlComment = "SELECT * FROM posts";
        } else {
            $sqlComment = "SELECT * FROM posts ORDER BY date DESC";
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
                $sqlPower = "SELECT rankUsers FROM users WHERE idUsers='$id'";
                $resultPower = mysqli_query($conn, $sqlPower);
                $rowPower = mysqli_fetch_assoc($resultPower);
                if ($rowComment['userId'] == $id || $rowPower['rankUsers'] == 'admin' || $rowPower['rankUsers'] == 'mod') {
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

<?php

?>