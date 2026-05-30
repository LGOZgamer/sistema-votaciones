<?php
$host = 'localhost';
$db   = 'votaciones_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Error de conexión a la base de datos: ' . $e->getMessage());
}

session_start();

function verificarSesion() {
    if (!isset($_SESSION['usuario'])) {
        header('Location: login.php');
        exit;
    }
}

function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

function puedeVerModulo($modulo) {
    $rol = $_SESSION['rol'] ?? '';
    $permisos = [
        'Administrador' => ['inicio','usuarios','roles','votaciones','mesas','candidatos','resultados','reportes','descargar'],
        'Operador' => ['inicio','votaciones','mesas','candidatos','resultados','reportes','descargar'],
        'Digitador' => ['inicio','resultados','reportes'],
        'Consulta' => ['inicio','reportes']
    ];
    return in_array($modulo, $permisos[$rol] ?? [], true);
}

function requiereModulo($modulo) {
    verificarSesion();
    if (!puedeVerModulo($modulo)) {
        http_response_code(403);
        die('<div style="font-family:Arial;padding:30px"><h2>Acceso denegado</h2><p>Tu rol no tiene acceso a este módulo.</p><a href="index.php">Volver al inicio</a></div>');
    }
}

function soloAdmin() {
    requiereModulo('usuarios');
}
?>
