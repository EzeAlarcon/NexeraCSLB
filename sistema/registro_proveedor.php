<?php
include_once "includes/header.php";
include "../conexion.php";

if (!empty($_POST)) {
    $alert = "";

    // Verifica si los campos proveedor y contacto están vacíos
    if (empty($_POST['proveedor']) || empty($_POST['contacto'])) {
        $alert = '<div class="alert alert-danger" role="alert">
        All fields are required
                    </div>';
    } else {
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
        $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;
        $usuario_id = $_SESSION['idUser'];

        // Verifica si el contacto ya está registrado
        $query = mysqli_query($conexion, "SELECT * FROM proveedor where contacto = '$contacto'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
            The COD is already registered
                    </div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO proveedor(proveedor, contacto, telefono, direccion, usuario_id) values ('$proveedor', '$contacto', '$telefono', '$direccion', '$usuario_id')");

            if ($query_insert) {
                $alert = '<div class="alert alert-primary" role="alert">
                Registered Provider
                        </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                Error registering supplier
                        </div>';
            }
        }
    }
}

mysqli_close($conexion);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card-header bg-secondary text-white">
            Supplier registration
            </div>
            <div class="card">
                <form action="" autocomplete="off" method="post" class="card-body p-2">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    <div class="form-group">
                        <label for="nombre">Name</label>
                        <input type="text" placeholder="Enter Name" name="proveedor" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="contacto">COD</label>
                        <input type="text" placeholder="Enter code (0111)" name="contacto" id="contacto" class="form-control">
                    </div>
                    <input type="submit" value="Save Provider" class="btn btn-success">
                    <a href="lista_proveedor.php" class="btn btn-danger">Go back</a>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include_once "includes/footer.php"; ?>