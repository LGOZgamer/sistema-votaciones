<?php require 'config.php'; requiereModulo('usuarios');
$mensaje=''; $edit=null;
if(isset($_GET['eliminar'])){$id=(int)$_GET['eliminar']; if($id!=(int)($_SESSION['id_usuario']??0)){$pdo->prepare('DELETE FROM usuarios WHERE id_usuario=?')->execute([$id]);} header('Location: usuarios.php?ok=eliminado');exit;}
if(isset($_GET['editar'])){$st=$pdo->prepare('SELECT * FROM usuarios WHERE id_usuario=?');$st->execute([(int)$_GET['editar']]);$edit=$st->fetch();}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id_usuario']??0); $hash=null; if(!empty($_POST['contrasena'])){$hash=password_hash($_POST['contrasena'], PASSWORD_DEFAULT);} 
 if($id){
   if($hash){$st=$pdo->prepare('UPDATE usuarios SET nombre=?, correo=?, contrasena=?, id_rol=?, estado=? WHERE id_usuario=?');$st->execute([$_POST['nombre'],$_POST['correo'],$hash,$_POST['id_rol'],$_POST['estado'],$id]);}
   else {$st=$pdo->prepare('UPDATE usuarios SET nombre=?, correo=?, id_rol=?, estado=? WHERE id_usuario=?');$st->execute([$_POST['nombre'],$_POST['correo'],$_POST['id_rol'],$_POST['estado'],$id]);}
 } else {
   $st=$pdo->prepare('INSERT INTO usuarios(nombre,correo,contrasena,id_rol,estado) VALUES(?,?,?,?,?)');$st->execute([$_POST['nombre'],$_POST['correo'],password_hash($_POST['contrasena'], PASSWORD_DEFAULT),$_POST['id_rol'],$_POST['estado']]);
 }
 header('Location: usuarios.php?ok=guardado');exit;
}
require 'header.php'; $roles=$pdo->query('SELECT * FROM roles ORDER BY nombre_rol')->fetchAll(); $rows=$pdo->query('SELECT u.*, r.nombre_rol FROM usuarios u JOIN roles r ON u.id_rol=r.id_rol ORDER BY u.id_usuario DESC')->fetchAll(); ?>
<h1>Usuarios</h1><?php if(isset($_GET['ok'])): ?><div class="alert success">Operación realizada correctamente.</div><?php endif; ?>
<form method="POST" class="form-grid"><input type="hidden" name="id_usuario" value="<?=e($edit['id_usuario']??'')?>"><input name="nombre" placeholder="Nombre completo" value="<?=e($edit['nombre']??'')?>" required><input type="email" name="correo" placeholder="Correo" value="<?=e($edit['correo']??'')?>" required><input type="password" name="contrasena" placeholder="Contraseña <?= $edit?'(dejar vacío para no cambiar)':'' ?>" <?= $edit?'':'required' ?>><select name="id_rol"><?php foreach($roles as $r): ?><option value="<?=e($r['id_rol'])?>" <?=($edit['id_rol']??'')==$r['id_rol']?'selected':''?>><?=e($r['nombre_rol'])?></option><?php endforeach; ?></select><select name="estado"><?php foreach(['Activo','Inactivo'] as $op): ?><option <?=($edit['estado']??'Activo')==$op?'selected':''?>><?=$op?></option><?php endforeach; ?></select><button><?= $edit?'Actualizar':'Guardar' ?> usuario</button><?php if($edit): ?><a class="btn secondary" href="usuarios.php">Cancelar</a><?php endif; ?></form>
<table><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr><?php foreach($rows as $r): ?><tr><td><?=e($r['id_usuario'])?></td><td><?=e($r['nombre'])?></td><td><?=e($r['correo'])?></td><td><?=e($r['nombre_rol'])?></td><td><span class="badge"><?=e($r['estado'])?></span></td><td class="actions"><a class="btn small" href="usuarios.php?editar=<?=e($r['id_usuario'])?>">Editar</a><?php if((int)$r['id_usuario']!=(int)($_SESSION['id_usuario']??0)): ?><a class="btn small danger" onclick="return confirm('¿Eliminar usuario?')" href="usuarios.php?eliminar=<?=e($r['id_usuario'])?>">Eliminar</a><?php endif; ?></td></tr><?php endforeach; ?></table>
<?php require 'footer.php'; ?>
