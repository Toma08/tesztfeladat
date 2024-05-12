<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.html"); // Ha nincs bejelentkezve, visszairányít a főoldalra
    exit;
}

$loggedInUser = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üdvözöljük</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="msg">
        <h2>Üdvözöljük, <?php echo $loggedInUser['username']; ?>!</h2>
        <a class='link' href='index.html'>Vissza a főoldalra</a>
    </div>

</body>

</html>