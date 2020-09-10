<?php

if (isset($_POST["submit-login"])) {

    require "dbh.inc.php";

    $email = $_POST["mail"];
    $password = $_POST["pwd"];

    if (empty($email) || empty($password)) { /*Checking if the user left empty fields*/
        header("Location: ../login.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login.php?error=sqlerror");
            exit();
        } else {

            mysqli_stmt_bind_param($stmt, "ss", $email, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row["pwdUsers"]);
                if ($pwdCheck == false) { /*Checking if the password is correct*/
                    header("Location: ../login.php?error=wrongpassword");
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION["userId"] = $row["idUsers"];
                    $_SESSION["userUid"] = $row["uidUsers"];

                    header("Location: ../index.php?login=succes");
                    exit();
                } else {
                    header("Location: ../login.php?error=wrongpassword");
                    exit();
                }
            } else {
                header("Location: ../login.php?error=invalidinput");
                exit();
            }
        }
    }
} else {
    header("Location: ../login.php");
    exit();
}