<?php

//Image selected by the user to post
if (isset($_POST['submitPost'])) {

    $file = $_FILES['postPicture'];

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

                $sql = "SELECT id FROM posts WHERE date='$date'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $fileNameNew = "post" . $row['id'] . ".jpg";
                $fileDestination = '../uploadImagesPosts/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "UPDATE posts SET status=0 WHERE date='$date'";
                $result = mysqli_query($conn, $sql);
                header("Location: ../index.php?succes:uploadPostTextAndImage");
                exit();
            } else {
                header("Location: ../index.php?error:fileistoolarge");
                exit();
            }
        } else {
            header("Location: ../index.php?error:sqlProPic");
            exit();
        }
    } else {
        if ($fileName == "") { //Means there is no file uploaded
            header("Location: ../index.php?succes:uploadPostText");
            exit();
        } else {
            header("Location: ../index.php?error:filetypenotallowed");
            exit();
        }
    }
} else {
    header("Location: ../index.php?error:tryagain");
    exit();
}
