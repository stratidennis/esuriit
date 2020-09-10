<?php
session_start();
include_once "dbh.inc.php";
$id = $_SESSION["userId"];


if (isset($_POST['submitPhoto'])) {
    $file = $_FILES['ProPic'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');
    if (in_array($fileActualExt, $allowed)) {
        if ($fileActualExt == 'jpeg' || $fileActualExt == 'png') {
            $fileActualExt = 'jpg';
        }
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
                $fileNameNew = "profile" . $id . ".jpg";
                $fileDestination = '../uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE profilepictures SET status=0 WHERE userid='$id'";
                $result = mysqli_query($conn, $sql);
                header("Location: ../userpageEdit.php?uploadimage:success");
                exit();
            } else {
                header("Location: ../userpageEdit.php?error:fileistoolarge");
                exit();
            }
        } else {
            header("Location: ../userpageEdit.php?error:sqlProPic");
            exit();
        }
    } else {
        header("Location: ../userpageEdit.php?error:filetypenotallowed");
        exit();
    }
} else {
    header("Location: ../userpageEdit.php");
    exit();
}
