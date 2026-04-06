<?php
session_start();

if (!isset($_SESSION['user']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

$mensaje = "";
// conexión
$pdo = new PDO("mysql:host=localhost;dbname=relax_corp_games;charset=utf8mb4", "root", "");

if (isset($_POST['crear'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$user, $pass]);

    $mensaje = "Usuario creado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
</head>
<body>
    <h2>Crear Nuevo Usuario</h2>

    <?php if (!empty($mensaje)): ?>
        <p style="color: green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Usuario" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        
        <button name="crear">Crear Usuario</button>
        <a href="pag_juegos.php"><button type="button">Volver al Panel</button></a>
    </form>

</body>
</html>