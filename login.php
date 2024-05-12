<?php
session_start();
// felhasználó által küldött adatok kinyerése POST tömbből
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginUsername = $_POST['loginUsername'] ?? '';
    $loginPassword = $_POST['loginPassword'] ?? '';

    // JSON fájl tartalmának mentése
    $users = json_decode(file_get_contents('users.json'), true) ?? [];
    $loggedInUser = null;
    // JSON fájl tartalmának bejárása
    foreach ($users as $user) {
        if ($user['username'] === $loginUsername && password_verify($loginPassword, $user['password'])) {
            //User adatának tárolása
            $loggedInUser = $user;
            break;
        }
    }

    // Sikeres bejelentkezés esetén a felhasználó adatait a sessionben tároljuk
    if ($loggedInUser) {
        $_SESSION['user'] = $loggedInUser;
        header("Location: welcome.php"); // Átirányítás az üdvözlő oldalra
        exit;
    } else {
        $message = "<h2 style='color: red;'>Hibás felhasználónév vagy jelszó</h2> <a class='link' href='index.html'>Vissza a főoldalra</a>";
    }
} else {
    http_response_code(405);
    $message = "<h2 style='color: red;'>Csak POST kérések fogadása engedélyezett</h2>  <a class='link' href='index.html'>Vissza a főoldalra</a>";
}

// HTML oldal generálása a válaszhoz
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Bejelentkezés</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";
echo "<div class='msg'>";
echo $message; // Kiírjuk az üzenetet
echo "</div>";
echo "</body>";
echo "</html>";
