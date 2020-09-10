<?php

if (isset($_POST["submit-register"])) {

    require "dbh.inc.php";

    $fname = $_POST["FirstName"];
    $lname = $_POST["LastName"];
    $username = $_POST["uid"];
    $email = $_POST["mail"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat) || empty($fname) || empty($lname)) {
        header("Location: ../register.php?error=emptyfields&uid=" . $username . "&mail=" . $email . "&FirstName=" . $fname . "&LastName=" . $lname);
        exit();
    } else if (!preg_match("/^[a-zA-Z]*$/", $fname)) {
        header("Location: ../register.php?error=invalidFirstName&mail=" . $email . "&uid=" . $username . "&LastName=" . $lname);
        exit();
    } else if (!preg_match("/^[a-zA-Z]*$/", $lname)) {
        header("Location: ../register.php?error=invalidLastName&mail=" . $email . "&uid=" . $username . "&FirstName=" . $fname);
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../register.php?error=invalidusername&mail=" . $email . "&FirstName=" . $fname . "&LastName=" . $lname);
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidemail&uid=" . $username . "&FirstName=" . $fname . "&LastName=" . $lname);
        exit();
    } else if ($password !== $passwordRepeat) {
        header("Location: ../register.php?error=passwordsdonotmatch&uid=" . $username . "&mail=" . $email . "&FirstName=" . $fname . "&LastName=" . $lname);
        exit();
    } else {

        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
        $sqlemail = "SELECT emailUsers FROM users WHERE emailUsers=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../register.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../register.php?error=useralredadytaken&mail=" . $email . "&FirstName=" . $fname . "&LastName=" . $lname);
                exit();
            } else {
                if (!mysqli_stmt_prepare($stmt, $sqlemail)) {
                    header("Location: ../register.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    if ($resultCheck > 0) {
                        header("Location: ../register.php?error=emailalredadyinuse&uid=" . $username . "&FirstName=" . $fname . "&LastName=" . $lname);
                        exit();
                    } else {
                        $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, fnUsers, lnUsers) VALUES (?, ?, ?, ?, ?)";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../register.php?error=sqlerror");
                            exit();
                        } else {
                            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashedpassword, $fname, $lname);
                            mysqli_stmt_execute($stmt);

                            //INSERTING DEFAULT DESCRIPTION AND STATUS=1 IN PROFILEPICTURES TABLE
                            $sqlImg = "SELECT * FROM users WHERE uidUsers='$username'";
                            $result = mysqli_query($conn, $sqlImg);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $userid = $row['idUsers'];
                                    $sqlImg = "INSERT INTO profilepictures (userid, status, description) VALUES ('$userid', 1, 'Default description: I AM BATMAN!')";
                                    mysqli_query($conn, $sqlImg);
                                }
                            }

                            header("Location: ../register.php?register=succes");
                            exit();
                        }
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../register.php");
    exit();
}