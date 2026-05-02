<?php 
session_start();

// Si ya inició sesión, redirigir al foro
if (isset($_SESSION['user'])) {
    header("Location: pag_juegos.php");
    exit;
}

// Configuración de la base de datos
$host = 'localhost';
$db   = 'relax_corp_games';
$user_db = 'root'; 
$pass_db = '';     
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     $pdo = new PDO($dsn, $user_db, $pass_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
     ]);
} catch (\PDOException $e) {
     die("Error de conexión: " . $e->getMessage());
}

$error = null;

// Guardar en variables los datos de registro (no se debe registrar)
if (isset($_POST['login'])) {
    $user_input = trim($_POST['username']);
    $pass_input = trim($_POST['password']);

    // Consultar el usuario en la base de datos 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user_input]);
    $user_data = $stmt->fetch();

    // Verificación
    if ($user_data && $user_data['password'] === $pass_input) {
        $_SESSION['user'] = $user_data['username'];
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['is_admin'] = $user_data['is_admin'];
        
        header("Location: pag_juegos.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>RelaxCorp</title>
    <link rel="stylesheet" href="style.css"> </head>
</head>
<body>
<div class="container">
    <h1 class="text-center">¡Bienvenido!</h1>
    <p class="text-center">
        Página de descanso ¡¡Es hora de jugar!!<br>
        <strong>RelaxCorp</strong>
    </p>

<?php if ($error): ?>
<p style="color:red"><?= $error ?></p>
<?php endif; ?>

<h2>Iniciar sesión</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Usuario" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button name="login">Entrar</button>
</form>

</div>
</body>
</html>