<?php
require "header.php";
include_once "includes/dbh.inc.php";
?>

<main>

    <head>
        <link rel="stylesheet" href="stylesheet_powerusersproper.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
        <title>Power users</title>
    </head>

    <body>

        <?php
        if (!isset($_SESSION["userId"])) { /*Sending the user back to home page if not loged in*/
            header("Location: index.php");
            exit();
        } else {
            $id = $_SESSION["userId"];
            $sqlCheckRank = "SELECT rankUsers FROM users WHERE idUsers='$id'";
            $resultCheckRank = mysqli_query($conn, $sqlCheckRank);
            $rowCheckRank = mysqli_fetch_assoc($resultCheckRank);
            if ($rowCheckRank['rankUsers'] == 'peasant') {
                header("Location: powerusers.php?nopeasantsallowed");
                exit();
            }
        }
        ?>

        <div class='addComment'>
            <form action='includes/uploadPowerPost.inc.php' method='POST' enctype='multipart/form-data'>
                <div class='top-row'>
                    <div class='addPost'>Enter message</div>
                </div>
                <?php
                echo "<input type='hidden' name='date' value='" . date(' Y-m-d H:i:s') . "'>";
                ?>
                <div class='middle-row'>
                    <textarea class='postText' name='postText'></textarea>
                </div>
                <div class='bottom-row'>
                    <button name='submitPost' type='submit'>Upload message!</button>
                </div>
            </form>
        </div>

        <?php
        /*DISPLAYING ERRORS IF NECESSARY*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if (strpos($fullUrl, "error:noTextIntroduced") == true) {
            echo "<p class='error'>No text inserted!</p>";
        } elseif (strpos($fullUrl, "error:invalidcharactersinPost") == true) {
            echo "<p class='error'>Invalid characters!</p>";
        } elseif (strpos($fullUrl, "error:over1000characters") == true) {
            echo "<p class='error'>Too many characters!</p>";
        } elseif (strpos($fullUrl, "error:filetypenotallowed") == true) {
            echo "<p class='error'>The selected file is not allowed!</p>";
        } elseif (strpos($fullUrl, "error:sqlProPic") == true || strpos($fullUrl, "error:tryagain") == true) {
            echo "<p class='error'>The image couldn't be uploaded!</p>";
        } elseif (strpos($fullUrl, "error:fileistoolarge") == true) {
            echo "<p class='error'>The image size is too big!</p>";
        }

        $sqlComment = "SELECT * FROM powerposts ORDER BY date DESC";
        $resultComment = mysqli_query($conn, $sqlComment);

        /*Displaying all posts from the database called "powerposts"*/
        $id = $_SESSION["userId"];
        while ($rowComment = mysqli_fetch_assoc($resultComment)) {
            if ($rowComment['userId'] == $id) {
                /*STARTING COMMENT SECTION*/
                echo "
                    <div class='CommentOwn'>
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
                    </div>
                ";
                /*CLOSING COMMENT SECTION*/
                echo "
                    </div>
                ";
            } else {
                /*STARTING COMMENT SECTION*/
                echo "
                    <div class='CommentOther'>
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
                    </div>
                ";
                /*CLOSING COMMENT SECTION*/
                echo "
                    </div>
                ";
            }
        }

        /*This is a function that makes links from the posts clickable*/
        function make_links_clickable($text)
        {
            return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
        }

        ?>

    </body>

</main>