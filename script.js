document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    // Egyszerű email formátum ellenőrzés
    if (!isValidEmail(email)) {
      alert("Hibás email formátum");
      event.preventDefault();
      return;
    }

    // Jelszó hossz ellenőrzése
    if (password.length < 6) {
      alert("A jelszónak legalább 6 karakter hosszúnak kell lennie");
      event.preventDefault();
      return;
    }
  });

// Email formátum ellenőrző függvény
function isValidEmail(email) {
  return /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(
    email
  );
}
