<?php
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

$mensaje = "";
$error = "";
// conexión
$pdo = new PDO("mysql:host=localhost;dbname=relax_corp_games;charset=utf8mb4", "root", "");

if (isset($_POST['crear'])) {
    $user = trim($_POST['username']);
    $pass = $_POST['password'];

    //Ajustes de contraseña
    if (strlen($pass) < 8) {
        $error = "La contraseña es demasiado corta (mínimo 8 caracteres).";
    } 
    // 2. Prohibir barras (/ y \) y espacios (\s)
    elseif (preg_match('/[\/\/\\\\\s]/', $pass)) {
        $error = "No se permiten espacios ni barras (/ o \) en la contraseña.";
    } 
    else {

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$user, $pass]);

    $mensaje = "Usuario creado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Panel Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Crear Nuevo Usuario</h2>

        <?php if ($mensaje): ?>
            <p style="color: #00ff00; font-weight: bold;"><?= $mensaje ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p style="color: #ff4b2b; font-weight: bold;"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            
            <input type="password" 
                   name="password" 
                   placeholder="Contraseña (Mín. 8 caracteres)" 
                   minlength="8"
                   pattern="^[^\s\\\/]+$"
                   title="La contraseña no puede tener espacios ni barras (/ o \)"
                   required>
            
            <button name="crear" class="btn">Registrar Usuario</button>
            <br><br>
            <a href="pag_juegos.php" class="btn">Volver al Panel</a>
        </form>
    </div>
</body>
</html>