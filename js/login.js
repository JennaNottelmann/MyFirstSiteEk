const users = [
    {username: "admin", password: "1234"}
    {username: "user", password: "password"}
];

document.getElementById("login-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    const user = user.find(u => u.username === username && u.password === password);

    if (user) {
        window.location.href = "secret.php";
    } else {
        document.getElementById("error-message").innerText = "Benutzername oder Passwort falsch!";
    }
});