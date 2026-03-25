<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
    <h1>¡Hola, <?php echo $_SESSION['user']; ?>!</h1>
       <?php if ($_SESSION['is_admin']): ?>
        <h2>Panel de Administrador</h2>
        <a href="crear_usuario.php">Crear usuario</a>
       <?php endif; ?>
    <p>Has ingresado correctamente al sistema.</p>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>