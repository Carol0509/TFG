<?php
session_start();

// Para que solo el admin pueda hacer esto
if (!isset($_SESSION['user']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_a_eliminar = $_GET['id'];
    
    // Para evitar que el admin se elimine a si mismo 
    if ($id_a_eliminar == $_SESSION['user_id']) {
        die("No puedes eliminar tu propia cuenta de administrador.");
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=relax_corp_games;charset=utf8mb4", "root", "");
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id_a_eliminar]);
        
        header("Location: pag_juegos.php?msg=Usuario eliminado");
        exit;
    } catch (Exception $e) {
        die("Error al eliminar: " . $e->getMessage());
    }
} else {
    header("Location: pag_juegos.php");
}
?>