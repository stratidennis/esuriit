<?php

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    if ($password == 'Copilul1') {
        header("Location: ../powerusersproper.php");
        exit();
    } else {
        header("Location: ../powerusers.php?incorrectpassword");
        exit();
    }
} else {
    header("Location: ../powerusers.php?notsupposeddtobehere");
    exit();
}
