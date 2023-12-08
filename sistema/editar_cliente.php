<?php include_once "includes/header.php";
include "../conexion.php";
if (!empty($_POST)) {
  $alert = "";
  if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
    $alert = '<p class"error">All fields are required</p>';
  } else {
    $idcliente = $_POST['id'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $result = 0;
    if (is_numeric($dni) and $dni != 0) {

      $query = mysqli_query($conexion, "SELECT * FROM cliente where (dni = '$dni' AND idcliente != $idcliente)");
      $result = mysqli_fetch_array($query);
      $resul = mysqli_num_rows($query);
    }

    if ($resul >= 1) {
      $alert = '<p class"error">The ID already exists</p>';
    } else {
      if ($dni == '') {
        $dni = 0;
      }
      $sql_update = mysqli_query($conexion, "UPDATE cliente SET dni = $dni, nombre = '$nombre' , telefono = '$telefono', direccion = '$direccion' WHERE idcliente = $idcliente");

      if ($sql_update) {
        $alert = '<p class"exito">Client Updated Successfully</p>';
      } else {
        $alert = '<p class"error">Client Update Error</p>';
      }
    }
  }
}
// Mostrar Datos

if (empty($_REQUEST['id'])) {
  header("Location: lista_cliente.php");
}
$idcliente = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idcliente = $idcliente");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
  header("Location: lista_cliente.php");
} else {
  while ($data = mysqli_fetch_array($sql)) {
    $idcliente = $data['idcliente'];
    $dni = $data['dni'];
    $nombre = $data['nombre'];
    $telefono = $data['telefono'];
    $direccion = $data['direccion'];
  }
}
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-6 m-auto">

              <form class="" action="" method="post">
                <?php echo isset($alert) ? $alert : ''; ?>
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <div class="form-group">
                  <label for="dni">IDE</label>
                  <input type="number" placeholder="Enter IDE" name="dni" id="dni" class="form-control" value="<?php echo $dni; ?>">
                </div>
                <div class="form-group">
                  <label for="nombre">Name</label>
                  <input type="text" placeholder="Enter name" name="nombre" class="form-control" id="nombre" value="<?php echo $nombre; ?>">
                </div>
                <div class="form-group">
                  <label for="telefono">Phone</label>
                  <input type="number" placeholder="Enter phone" name="telefono" class="form-control" id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <div class="form-group">
                  <label for="direccion">Address</label>
                  <input type="text" placeholder="Enter Address" name="direccion" class="form-control" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <button type="submit" class="btn btn-success"><i class="fas fa-user-edit"></i> Edit Client</button>
              </form>
            </div>
          </div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
      <?php include_once "includes/footer.php"; ?>