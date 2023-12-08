 <?php include_once "includes/header.php";
  include "../conexion.php";
  if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['proveedor']) || empty($_POST['producto']) || empty($_POST['precio']) || $_POST['precio'] <  0 || empty($_POST['cantidad'] || $_POST['cantidad'] <  0)) {
      $alert = '<div class="alert alert-danger" role="alert">
      All fields are required
              </div>';
    } else {
      $proveedor = $_POST['proveedor'];
      $producto = $_POST['producto'];
      $precio = $_POST['precio'];
      $cantidad = $_POST['cantidad'];
      $usuario_id = $_SESSION['idUser'];

      $query_insert = mysqli_query($conexion, "INSERT INTO producto(proveedor,descripcion,precio,existencia,usuario_id) values ('$proveedor', '$producto', '$precio', '$cantidad','$usuario_id')");
      if ($query_insert) {
        $alert = '<div class="alert alert-primary" role="alert">
        Registered Product
              </div>';
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
        Error registering product
              </div>';
      }
    }
  }
  ?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">Administration panel</h1>
     <a href="lista_productos.php" class="btn btn-warning">Go back</a>
   </div>

   <!-- Content Row -->
   <div class="row">
     <div class="col-lg-6 m-auto">
       <form action="" method="post" autocomplete="off">
         <?php echo isset($alert) ? $alert : ''; ?>
         <div class="form-group">
           <label>Supplier</label>
           <?php
            $query_proveedor = mysqli_query($conexion, "SELECT codproveedor, proveedor FROM proveedor ORDER BY proveedor ASC");
            $resultado_proveedor = mysqli_num_rows($query_proveedor);
            mysqli_close($conexion);
            ?>
           <select id="proveedor" name="proveedor" class="form-control">
             <?php
              if ($resultado_proveedor > 0) {
                while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                  // code...
              ?>
                 <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
             <?php
                }
              }
              ?>
           </select>
         </div>
         <div class="form-group">
           <label for="producto">Product</label>
           <input type="text" placeholder="Enter product name" name="producto" id="producto" class="form-control">
         </div>
         <div class="form-group">
           <label for="precio">Price</label>
           <input type="text" placeholder="Enter price" class="form-control" name="precio" id="precio">
         </div>
         <div class="form-group">
           <label for="cantidad">Amount</label>
           <input type="number" placeholder="Enter quantity" class="form-control" name="cantidad" id="cantidad">
         </div>
         <input type="submit" value="Save Product" class="btn btn-success">
       </form>
     </div>
   </div>


 </div>
 <!-- /.container-fluid -->

 </div>
 <!-- End of Main Content -->
 <?php include_once "includes/footer.php"; ?>