<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Obtener los usuarios de la base de datos para poder eliminarlos
$usuarios = [];
if ($_SESSION['is_admin']) {
    $pdo = new PDO("mysql:host=localhost;dbname=relax_corp_games;charset=utf8mb4", "root", "");
    $stmt = $pdo->prepare("SELECT id, username, created_at FROM users WHERE id != ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Juegos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>¡Hola, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        
        <?php if ($_SESSION['is_admin']): ?>
            <hr>
            <h2>Panel de Administrador</h2>
            
            <div style="margin-bottom: 20px;">
                <a href="crear_usuario.php" class="btn-link">Crear nuevo usuario</a>
                
                <button type="button" class="btn-link" id="btn-toggle-usuarios">
                    Gestionar Usuarios Existentes
                </button>
            </div>

            <div id="tabla-usuarios">
                <h3>Gestión de Usuarios Existentes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Fecha Registro</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['username']) ?></td>
                            <td><?= $u['created_at'] ?></td>
                            <td>
                                <a href="eliminar_usuario.php?id=<?= $u['id'] ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <hr>
        <?php endif; ?>

        <p>Has ingresado correctamente al sistema.</p>
        <a href="logout.php" class="btn">Cerrar Sesión</a>
    </div>

    <script>
        document.getElementById('btn-toggle-usuarios').addEventListener('click', function() {
            var tabla = document.getElementById('tabla-usuarios');
            if (tabla.style.display === 'none' || tabla.style.display === '') {
                tabla.style.display = 'block';
                this.innerText = 'Ocultar Gestión de Usuarios';
            } else {
                tabla.style.display = 'none';
                this.innerText = 'Gestionar Usuarios Existentes';
            }
        });
    </script>
</body>
</html>