<?php
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

// conexión
$pdo = new PDO("mysql:host=localhost;dbname=relax_corp_games;charset=utf8mb4", "root", "");

if (isset($_POST['crear'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$user, $pass]);

    echo "Usuario creado";
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Usuario" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button name="crear">Crear</button>
</form>