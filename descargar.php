<?php require 'config.php'; requiereModulo('descargar');
$tabla = $_GET['tabla'] ?? 'resultados';
$permitidas = ['usuarios','roles','votaciones','mesas','candidatos','resultados'];
if(!in_array($tabla,$permitidas,true)){ die('Tabla no permitida'); }
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$tabla.'.csv');
$out=fopen('php://output','w');
if($tabla==='resultados'){
 $rows=$pdo->query('SELECT r.id_resultado, v.nombre votacion, m.numero_mesa, m.centro_votacion, c.nombre candidato, c.partido, r.votos, r.observaciones, r.fecha_registro FROM resultados r JOIN votaciones v ON r.id_votacion=v.id_votacion JOIN mesas m ON r.id_mesa=m.id_mesa JOIN candidatos c ON r.id_candidato=c.id_candidato ORDER BY r.id_resultado DESC')->fetchAll();
}else{$rows=$pdo->query("SELECT * FROM `$tabla`")->fetchAll();}
if($rows){fputcsv($out,array_keys($rows[0]));foreach($rows as $r){fputcsv($out,$r);}}
fclose($out); exit;
?>
