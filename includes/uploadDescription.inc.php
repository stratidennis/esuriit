<?php
session_start();
include_once "dbh.inc.php";
$id = $_SESSION["userId"];

if (isset($_POST["submitDescription"])) {

    $description = $_POST["properDescription"];

    if (empty($description)) {
        header("Location: ../userpageEdit.php?error:empty");
        exit();
    } else if (!preg_match("/^[\r\na-zA-Z0-9, ?’.\"\/!#()_&=;:-]*$/", $description)) {
        header("Location: ../userpageEdit.php?error:invalidcharacters");
        exit();
    } else if (strlen($description) > 150) {
        header("Location: ../userpageEdit.php?error:toomanycharacters" . strlen($description));
        exit();
    } else {
        $sql = "UPDATE profilepictures SET description='$description' WHERE id='$id'";
        mysqli_query($conn, $sql);
        header("Location: ../userpageEdit.php?dupload:success");
        exit();
    }
} else {
    header("Location: ../userpageEdit.php");
    exit();
}
