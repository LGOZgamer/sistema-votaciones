<?php require 'config.php'; requiereModulo('reportes'); require 'header.php';
$idVotacion = $_GET['id_votacion'] ?? '';
$votaciones=$pdo->query('SELECT * FROM votaciones ORDER BY nombre')->fetchAll();
$params=[]; $where='';
if($idVotacion){$where='WHERE r.id_votacion=?'; $params=[$idVotacion];}
$sql='SELECT v.nombre votacion, c.nombre candidato, c.partido, SUM(r.votos) total_votos FROM resultados r JOIN votaciones v ON r.id_votacion=v.id_votacion JOIN candidatos c ON r.id_candidato=c.id_candidato '.$where.' GROUP BY v.id_votacion,c.id_candidato ORDER BY v.nombre,total_votos DESC';
$st=$pdo->prepare($sql);$st->execute($params);$resumen=$st->fetchAll();
$det=$pdo->prepare('SELECT v.nombre votacion, m.numero_mesa, m.centro_votacion, c.nombre candidato, c.partido, r.votos, r.fecha_registro FROM resultados r JOIN votaciones v ON r.id_votacion=v.id_votacion JOIN mesas m ON r.id_mesa=m.id_mesa JOIN candidatos c ON r.id_candidato=c.id_candidato '.($idVotacion?'WHERE r.id_votacion=?':'').' ORDER BY v.nombre,m.numero_mesa,c.nombre');$det->execute($params);$detalle=$det->fetchAll(); ?>
<h1>Consultar resultados</h1>
<p class="muted">Resumen total por candidato y detalle por mesa electoral.</p>
<form method="GET" class="form-grid"><select name="id_votacion"><option value="">Todas las votaciones</option><?php foreach($votaciones as $v): ?><option value="<?=e($v['id_votacion'])?>" <?=$idVotacion==$v['id_votacion']?'selected':''?>><?=e($v['nombre'])?></option><?php endforeach; ?></select><button>Filtrar</button><?php if(puedeVerModulo('descargar')): ?><a class="btn secondary" href="descargar.php?tabla=resultados">Descargar CSV</a><?php endif; ?></form>
<h2>Resumen general</h2><table><tr><th>Votación</th><th>Candidato</th><th>Partido</th><th>Total votos</th></tr><?php foreach($resumen as $r): ?><tr><td><?=e($r['votacion'])?></td><td><?=e($r['candidato'])?></td><td><?=e($r['partido'])?></td><td><strong><?=e($r['total_votos'])?></strong></td></tr><?php endforeach; ?></table>
<h2>Detalle por mesa</h2><table><tr><th>Votación</th><th>Mesa</th><th>Centro</th><th>Candidato</th><th>Partido</th><th>Votos</th><th>Fecha</th></tr><?php foreach($detalle as $r): ?><tr><td><?=e($r['votacion'])?></td><td><?=e($r['numero_mesa'])?></td><td><?=e($r['centro_votacion'])?></td><td><?=e($r['candidato'])?></td><td><?=e($r['partido'])?></td><td><?=e($r['votos'])?></td><td><?=e($r['fecha_registro'])?></td></tr><?php endforeach; ?></table>
<?php require 'footer.php'; ?>
