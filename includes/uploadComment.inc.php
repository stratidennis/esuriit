<?php
session_start();
include_once 'dbh.inc.php';
$id = $_SESSION['userId'];


if (isset($_POST['submitPost'])) {

    $date = $_POST['date'];
    //Text introduced by the user to post
    $postText = $_POST['postText'];
    if (empty($postText)) {
        header("Location: ../index.php?error:noTextIntroduced");
        exit();
    } else if (!preg_match("/^[\r\na-zA-Z0-9, ?’.\"\/!#()_&=;:-]*$/", $postText)) {
        header("Location: ../index.php?error:invalidcharactersinPost");
        exit();
    } else if (strlen($postText) > 400) {
        header("Location: ../index.php?error:over400characters" . strlen($postText));
        exit();
    } else {
        //Uploading the text that was introduced, the current user id, the date and status=1 in database
        $sql = "INSERT INTO posts (userId, postText, date, status) VALUES ('$id', '$postText', '$date', '1')";
        mysqli_query($conn, $sql);

        include_once 'uploadCommentImage.inc.php';
    }        

} else {
    header("Location: ../index.php?error:buttonNotClicked");
    exit();
}
