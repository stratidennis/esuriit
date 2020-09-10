<?php
require "header.php";
include_once "includes/dbh.inc.php";
?>

<main>

    <head>
        <title>Your Profile</title>
        <link rel="stylesheet" href="stylesheetUserPage.css">
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
            <p class="editp"><a href="userpage.php">Save Profile</a></p>
        </div>
        <?php
        /*Selecting all data that is required from database in order to be displayed on the user's profile page*/
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $id = $_SESSION["userId"];
            $sqlImg = "SELECT * FROM profilepictures WHERE userid='$id'";
            $resultImg = mysqli_query($conn, $sqlImg);
            $rowImg = mysqli_fetch_assoc($resultImg);
            $sqlFN = "SELECT fnUsers FROM users WHERE idUsers='$id'";
            $resultFN = mysqli_query($conn, $sqlFN);
            $rowFN = mysqli_fetch_assoc($resultFN);
            $sqlLN = "SELECT lnUsers FROM users WHERE idUsers='$id'";
            $resultLN = mysqli_query($conn, $sqlLN);
            $rowLN = mysqli_fetch_assoc($resultLN);
            echo "<div id='diamond'>";
            if ($rowImg['status'] == 0) {
                echo "<div><img class='profilepic' src='uploads/profile" . $id . ".jpg?" . mt_rand() . "' alt='Profile picture'></div>";
            } else {
                echo "<div><img class='profilepic' src='uploads/profilepicDEFAULT.jpg' alt='Profile picture'></div>";
            }
            echo "</div>";
            echo "<div class='fullname'>" . $rowFN['fnUsers'] . " " . $rowLN['lnUsers'] . "</div>";
        }
        ?>
        <!--This form allows the user to change his profile picture-->
        <div class="choosefile">
            <p>Change profile picture</p>
            <form action="includes/uploadProPic.php" method="post" enctype="multipart/form-data">
                <input type="file" name="ProPic">
                <button type="submit" name="submitPhoto">Upload</button>
            </form>
        </div>
        <?php
        /*Displaying any kind of errors that may appear when uploading a profile picture*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (strpos($fullUrl, "error:fileistoolarge") == true) {
            echo "<p class='error'>The image size is too big!</p>";
        } elseif (strpos($fullUrl, "error:sqlProPic") == true) {
            echo "<p class='error'>There was an error uploading your image!</p>";
        } elseif (strpos($fullUrl, "error:filetypenotallowed") == true) {
            echo "<p class='error'>Your file's type is incompatible!</p>";
        } elseif (strpos($fullUrl, "uploadimage:success") == true) {
            echo "<p class='success'>Your image was uploaded successfully!</p>";
        }
        ?>
        <!--This form allows the user to change the description about himself-->
        <div class="descriptionedit">
            <form action="includes/uploadDescription.inc.php" method="POST">
                <input class="effect" type="text" placeholder="Short description (maximum 150 characters)..." name="properDescription">
                <br />
                <button type="submit" name="submitDescription">Submit</button>
            </form>
        </div>
        <?php
        /*Displaying any kind of errors that may appear when uploading the new description*/
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        if (strpos($fullUrl, "error:empty") == true) {
            echo "<p class='error'>You have not entered anything!</p>";
        } elseif (strpos($fullUrl, "error:invalidcharacters") == true) {
            echo "<p class='error'>You have entered invalid characters!</p>";
        } elseif (strpos($fullUrl, "error:toomanycharacters") == true) {
            echo "<p class='error'>You have entered over 150 characters!</p>";
        } elseif (strpos($fullUrl, "dupload:success") == true) {
            echo "<p class='success'>Your description was uploaded successfully!</p>";
        }
        ?>
    </body>
</main>

<?php

?>