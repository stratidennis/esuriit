<?php
include_once "dbh.inc.php";

/*Deleting selected post*/

if (isset($_POST['deletePost'])) {

    $postID = $_POST['idOFpost'];

    $sql = "DELETE FROM posts WHERE id='$postID'";
    mysqli_query($conn, $sql);

    header("Location: ../index.php?success:deletePost".$postID."");
    exit();

} else {
    header("Location: ../index.php");
    exit();
}