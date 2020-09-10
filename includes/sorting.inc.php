<?php

$sortingOption = $_POST['sorting'];
$returnPage = $_POST['url'];

if (strpos($returnPage, "index") == true) {
    header("Location: ../index.php?sortby:" . $sortingOption . "");
    exit();
} else if (strpos($returnPage, "userpage") == true) {
    header("Location: ../userpage.php?sortby:" . $sortingOption . "");
    exit();
} else if (strpos($returnPage, "powerusersproper") == true) {
    header("Location: ../powerusersproper.php?sortby:" . $sortingOption . "");
    exit();
}

header("Location: ../index.php?IDK" . $sortingOption . "" . $returnPage . "");
exit();
