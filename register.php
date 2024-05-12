<?php
// Ellenőrizzük, hogy POST kérés érkezett-e
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ellenőrzötten tároljuk a felhasználókat
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ellenőrizzük az email cím formátumát
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<h2 style='color: red;''>Hibás email formátum <a class='link' href='index.html'>Vissza a főoldalra</a>";
    } elseif (strlen($password) < 6) {
        $message = "<h2 style='color: red;''>A jelszónak legalább 6 karakter hosszúnak kell lennie <a class='link' href='index.html'>Vissza a főoldalra</a>";
    } else {
        // Ellenőrizzük, hogy a felhasználónév és az email cím még nem lett-e regisztrálva
        $users = json_decode(file_get_contents('users.json'), true) ?? [];

        foreach ($users as $user) {
            if ($user['username'] === $username) {
                $message = "<h2 style='color: red;''>A felhasználónév már foglalt</h2><a class='link' href='index.html'>Vissza a főoldalra</a>";
                break;
            }
            if ($user['email'] === $email) {
                $message = "<h2 style='color: red;''>Az email cím már regisztrálva van </h2><a class='link' href='index.html'>Vissza a főoldalra</a>";
                break;
            }
        }

        if (!isset($message)) {
            // Új felhasználó hozzáadása a JSON fájlhoz
            $newUser = array(
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT) // Jelszó hashelése
            );

            $users[] = $newUser;
            file_put_contents('users.json', json_encode($users));

            // Sikeres regisztráció üzenet
            $message = "<h2 style='color: green;'>Sikeres regisztráció!</h2>";
            $message .= "<a class='link' href='index.html'>Vissza a főoldalra</a>";
        }
    }
} else {
    // Ha nem POST kérés érkezett, hibát dobunk
    http_response_code(405);
    $message = "Csak POST kérések fogadása engedélyezett <a class='link' href='index.html'>Vissza a főoldalra</a>";
}

// HTML oldal generálása a válaszhoz
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Regisztráció</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";
echo "<div class='msg'>";
echo $message; // Kiírjuk az üzenetet
echo "</div>";
echo "</body>";
echo "</html>";
