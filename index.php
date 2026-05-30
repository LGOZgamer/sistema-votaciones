<?php
require 'config.php'; verificarSesion(); require 'header.php';
function contar($pdo,$tabla){$permitidas=['usuarios','votaciones','mesas','candidatos','resultados']; if(!in_array($tabla,$permitidas,true)) return 0; return $pdo->query("SELECT COUNT(*) c FROM `$tabla`")->fetch()['c'];}
$cards = [
 ['mod'=>'votaciones','titulo'=>'Votaciones registradas','tabla'=>'votaciones','url'=>'votaciones.php','icon'=>'vote'],
 ['mod'=>'mesas','titulo'=>'Mesas electorales','tabla'=>'mesas','url'=>'mesas.php','icon'=>'box'],
 ['mod'=>'candidatos','titulo'=>'Candidatos','tabla'=>'candidatos','url'=>'candidatos.php','icon'=>'person'],
 ['mod'=>'resultados','titulo'=>'Resultados ingresados','tabla'=>'resultados','url'=>'resultados.php','icon'=>'chart'],
 ['mod'=>'usuarios','titulo'=>'Usuarios activos','tabla'=>'usuarios','url'=>'usuarios.php','icon'=>'users']
];
function ico($i){$icons=[
'vote'=>'<svg viewBox="0 0 24 24"><path d="M4 20h16v2H4v-2Zm2-2h12l2-8H4l2 8Zm5.7-9.3-4-4 1.4-1.4 2.6 2.6 5.2-5.2L18.3 2l-6.6 6.7Z"/></svg>',
'box'=>'<svg viewBox="0 0 24 24"><path d="M3 7h18v14H3V7Zm2 2v10h14V9H5Zm3-6h8l2 3H6l2-3Z"/></svg>',
'person'=>'<svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm0 2c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5Z"/></svg>',
'chart'=>'<svg viewBox="0 0 24 24"><path d="M5 9h3v10H5V9Zm5-4h3v14h-3V5Zm5 7h3v7h-3v-7ZM3 21h18v2H3v-2Z"/></svg>',
'users'=>'<svg viewBox="0 0 24 24"><path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm8 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM8 13c-3.3 0-6 1.7-6 3.8V19h12v-2.2C14 14.7 11.3 13 8 13Zm8 0c-.7 0-1.4.1-2 .3 1.2.9 2 2.1 2 3.5V19h6v-2.2c0-2.1-2.7-3.8-6-3.8Z"/></svg>'
]; return $icons[$i] ?? $icons['vote'];}
?>
<h1>Panel principal</h1>
<p class="page-subtitle">Bienvenido al sistema para gestionar votaciones, mesas electorales y registro de resultados.</p>
<div class="stats-grid">
<?php foreach($cards as $c): if(puedeVerModulo($c['mod'])): ?>
<a class="stat-card" href="<?= $c['url'] ?>"><div><h2><?= $c['titulo'] ?></h2><strong><?= contar($pdo,$c['tabla']) ?></strong></div><div class="stat-icon"><?= ico($c['icon']) ?></div></a>
<?php endif; endforeach; ?>
</div>
<?php require 'footer.php'; ?>
