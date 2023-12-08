<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave']) || empty($_POST['rol'])) {
        $alert = '<div class="alert alert-primary" role="alert">
                    Todos los campos son obligatorios
                </div>';
    } else {
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol'];
        $url_server = $_POST['url_server'];
        $pbx_username = $_POST['pbx_username'];
        $pbx_password = md5($_POST['password_pbx']);
        $cid = $_POST['cid'];
        $extension_src = $_POST['extension_src'];

        $query = mysqli_query($conexion, "SELECT * FROM usuario where correo = '$email'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                        El correo ya existe
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,rol,url_server,pbx_username,pbx_password,cid,extension_src) values ('$nombre', '$email', '$user', '$clave', '$rol', '$url_server', '$pbx_username', '$pbx_password', '$cid', '$extension_src')");
            
            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                            Usuario registrado
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                        Error al registrar
                    </div>';
            }
        }
    }
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Administration panel</h1>
        <a href="lista_usuarios.php" class="btn btn-warning">Go back</a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <form action="" method="post" autocomplete="off">
                <?php echo isset($alert) ? $alert : ''; ?>
                <div class="form-group">
                    <label for="nombre">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name" name="nombre" id="nombre">
                </div>
                <div class="form-group">
                    <label for="correo">Email</label>
                    <input type="email" class="form-control" placeholder="Enter Email" name="correo" id="correo">
                </div>
                <div class="form-group">
                    <label for="usuario">User</label>
                    <input type="text" class="form-control" placeholder="Enter User" name="usuario" id="usuario">
                </div>
                <div class="form-group">
                    <label for="clave">Password</label>
                    <input type="password" class="form-control" placeholder="Enter You Pass***" name="clave" id="clave">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="rol" id="rol" class="form-control">
                        <?php
                        $query_rol = mysqli_query($conexion, " select * from rol");
                        mysqli_close($conexion);
                        $resultado_rol = mysqli_num_rows($query_rol);
                        if ($resultado_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                                <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <!-- Nuevos campos para la PBX -->
                <div class="form-group">
                    <label for="url_server">URL del Servidor</label>
                    <input type="text" class="form-control" placeholder="Enter Server URL" name="url_server" id="url_server">
                </div>
                <div class="form-group">
                    <label for="pbx_username">PBX Username</label>
                    <input type="text" class="form-control" placeholder="Enter PBX Username" name="pbx_username" id="pbx_username">
                </div>
                <div class="form-group">
                    <label for="pbx_password">PBX Password</label>
                    <input type="password" class="form-control" placeholder="Enter PBX Password" name="pbx_password" id="pbx_password">
                </div>
                <div class="form-group">
                    <label for="cid">CID</label>
                    <input type="text" class="form-control" placeholder="Enter CID" name="cid" id="cid">
                </div>
                <div class="form-group">
                    <label for="extension_src">Extension Source</label>
                    <input type="text" class="form-control" placeholder="Enter Extension Source" name="extension_src" id="extension_src">
                </div>
                <input type="submit" value="Save User" class="btn btn-success">
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>
