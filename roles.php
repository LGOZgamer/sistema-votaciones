<?php require 'config.php'; requiereModulo('roles');
$mensaje=''; $edit=null;
if(isset($_GET['editar'])){$st=$pdo->prepare('SELECT * FROM roles WHERE id_rol=?');$st->execute([(int)$_GET['editar']]);$edit=$st->fetch();}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $id=(int)($_POST['id_rol'] ?? 0);
  if($id){$st=$pdo->prepare('UPDATE roles SET descripcion=? WHERE id_rol=?');$st->execute([$_POST['descripcion'],$id]);}
  header('Location: roles.php?ok=1');exit;
}
require 'header.php'; $rows=$pdo->query('SELECT * FROM roles ORDER BY id_rol')->fetchAll(); ?>
<h1>Roles</h1><p class="muted">Los roles base no se eliminan ni se crean; solo se puede editar la descripción.</p>
<?php if(isset($_GET['ok'])): ?><div class="alert success">Rol actualizado correctamente.</div><?php endif; ?>
<?php if($edit): ?><form method="POST" class="form-grid"><input type="hidden" name="id_rol" value="<?=e($edit['id_rol'])?>"><input value="<?=e($edit['nombre_rol'])?>" readonly><input name="descripcion" value="<?=e($edit['descripcion'])?>" required><button>Actualizar descripción</button><a class="btn secondary" href="roles.php">Cancelar</a></form><?php endif; ?>
<table><tr><th>ID</th><th>Rol</th><th>Descripción</th><th>Acciones</th></tr><?php foreach($rows as $r): ?><tr><td><?=e($r['id_rol'])?></td><td><?=e($r['nombre_rol'])?></td><td><?=e($r['descripcion'])?></td><td><a class="btn small" href="roles.php?editar=<?=e($r['id_rol'])?>">Editar</a></td></tr><?php endforeach; ?></table>
<?php require 'footer.php'; ?>
