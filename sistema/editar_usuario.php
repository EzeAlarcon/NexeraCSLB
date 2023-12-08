<?php
include "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) {
    $alert = '<p class"error">Todos los campos son requeridos</p>';
  } else {
    $idusuario = $_GET['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $rol = $_POST['rol'];
    $url_server = $_POST['url_server'];
    $pbx_username = $_POST['pbx_username'];
    $pbx_password = isset($_POST['pbx_password']) ? md5($_POST['pbx_password']) : ''; // Verificar si la clave está presente
    $cid = $_POST['cid'];
    $extension_src = $_POST['extension_src'];

    $sql_update = mysqli_query($conexion, "UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$usuario', rol = $rol, url_server = '$url_server', pbx_username = '$pbx_username', password_pbx = '$pbx_password', cid = '$cid', extension_src = '$extension_src' WHERE idusuario = $idusuario");
    $alert = '<p>Usuario Actualizado</p>';
  }
}

// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_usuarios.php");
}

$idusuario = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
  header("Location: lista_usuarios.php");
} else {
  if ($data = mysqli_fetch_array($sql)) {
    $idcliente = $data['idusuario'];
    $nombre = $data['nombre'];
    $correo = $data['correo'];
    $usuario = $data['usuario'];
    $rol = $data['rol'];
    $url_server = $data['url_server'];
    $pbx_username = $data['pbx_username'];
    // Verificar si la clave está presente antes de intentar acceder
    $pbx_password = isset($data['pbx_password']) ? $data['pbx_password'] : ''; 
    $cid = $data['cid'];
    $extension_src = $data['extension_src'];
  }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 m-auto">
      <form class="" action="" method="post">
        <?php echo isset($alert) ? $alert : ''; ?>
        <input type="hidden" name="id" value="<?php echo $idusuario; ?>">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
        </div>
        <div class="form-group">
          <label for="correo">Correo</label>
          <input type="text" placeholder="Ingrese correo" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>">
        </div>
        <div class="form-group">
          <label for="usuario">Usuario</label>
          <input type="text" placeholder="Ingrese usuario" class="form-control" name="usuario" id="usuario" value="<?php echo $usuario; ?>">
        </div>
        <div class="form-group">
          <label for="rol">Rol</label>
          <select name="rol" id="rol" class="form-control">
            <option value="1" <?php if ($rol == 1) echo "selected"; ?>>Administrador</option>
            <option value="2" <?php if ($rol == 2) echo "selected"; ?>>Supervisor</option>
            <option value="3" <?php if ($rol == 3) echo "selected"; ?>>Vendedor</option>
          </select>
        </div>
        <!-- Nuevos campos para la PBX -->
        <div class="form-group">
          <label for="url_server">URL del Servidor</label>
          <input type="text" class="form-control" placeholder="Ingrese URL del Servidor" name="url_server" id="url_server" value="<?php echo $url_server; ?>">
        </div>
        <div class="form-group">
          <label for="pbx_username">PBX Username</label>
          <input type="text" class="form-control" placeholder="Ingrese PBX Username" name="pbx_username" id="pbx_username" value="<?php echo $pbx_username; ?>">
        </div>
        <div class="form-group">
          <label for="pbx_password">PBX Password</label>
          <input type="password" class="form-control" placeholder="Ingrese PBX Password" name="pbx_password" id="pbx_password" value="<?php echo $pbx_password; ?>">
        </div>
        <div class="form-group">
          <label for="cid">CID</label>
          <input type="text" class="form-control" placeholder="Ingrese CID" name="cid" id="cid" value="<?php echo $cid; ?>">
        </div>
        <div class="form-group">
          <label for="extension_src">Extension Source</label>
          <input type="text" class="form-control" placeholder="Ingrese Extension Source" name="extension_src" id="extension_src" value="<?php echo $extension_src; ?>">
        </div>
        <button type="submit" class="btn btn-warning"><i class="fas fa-user-edit"></i> Edit User</button>
      </form>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
