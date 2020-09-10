<?php
session_start();
include_once 'dbh.inc.php';
$id = $_SESSION['userId'];


if (isset($_POST['submitPost'])) {

    $date = $_POST['date'];
    //Text introduced by the user to post
    $postText = $_POST['postText'];
    if (empty($postText)) {
        header("Location: ../powerusersproper.php?error:noTextIntroduced");
        exit();
    } else if (!preg_match("/^[\r\na-zA-Z0-9, ?’.\"\/!#()_=;:-]*$/", $postText)) {
        header("Location: ../powerusersproper.php?error:invalidcharactersinPost");
        exit();
    } else if (strlen($postText) > 1000) {
        header("Location: ../powerusersproper.php?error:over1000characters" . strlen($postText));
        exit();
    } else {
        //Uploading the text that was introduced, the current user id, the date and status=1 in database
        $sql = "INSERT INTO powerposts (userId, postText, date) VALUES ('$id', '$postText', '$date')";
        mysqli_query($conn, $sql);

        header("Location: ../powerusersproper.php?succes:upload");
        exit();
    }
} else {
    header("Location: ../powerusersproper.php?error:buttonNotClicked");
    exit();
}
