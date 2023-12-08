<?php
$alert = '';
session_start();
if (!empty($_SESSION['active'])) {
  header('location: sistema/');
} else {
  if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
      $alert = '<div class="alert alert-danger" role="alert">
      Enter your username and password
</div>';
    } else {
      require_once "conexion.php";
      $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
      $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
      $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo,u.usuario,r.idrol,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.usuario = '$user' AND u.clave = '$clave'");
      mysqli_close($conexion);
      $resultado = mysqli_num_rows($query);
      if ($resultado > 0) {
        $dato = mysqli_fetch_array($query);
        $_SESSION['active'] = true;
        $_SESSION['idUser'] = $dato['idusuario'];
        $_SESSION['nombre'] = $dato['nombre'];
        $_SESSION['email'] = $dato['correo'];
        $_SESSION['user'] = $dato['usuario'];
        $_SESSION['rol'] = $dato['idrol'];
        $_SESSION['rol_name'] = $dato['rol'];
        header('location: sistema/');
      } else {
        $alert = '<div class="alert alert-danger" role="alert">
          Incorrect user or password
            </div>';
        session_destroy();
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Nexera Dev Ezequiel Alarcon ">
  <link rel="stylesheet" href="stylus/styles.css"> 
  <!-- Agrega esto a tu encabezado (head) -->



  <title>NexeraCSLB-Login</title>

  <!-- Custom fonts for this template-->
  <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="sistema/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="logonexera.ico">


</head>

<body>
    <div class="container">
        <div class="image-box">
            <div class="logo-box">
                <img src="images/logo1.png" alt="Logo de la compañía" style="width: 45px; height: auto;">
                <img src="images/company.png" alt="Logo de la compañía" style="width: 596px; height: auto;">
            </div>
        </div>
        <div class="login-box">
            <div>
                <img src="images/logo.png">
                <h1>
                    Welcome to <span class="company-name">NexeraCSLB</span>
                </h1>
                <p>"We accept challenges as opportunities
                   for growth and a sample of our capabilities."</p>
            </div>
            <form class="user" method="POST">
                <?php echo isset($alert) ? $alert : ""; ?>
                <div class="login-form">
                    <div class="login-form-input-box">
                        
                        <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Your Email" name="usuario">
                    </div>
                    <div class="login-form-input-box">
                        
                        <input type="password" class="form-control" id="password" placeholder="Your Password***" name="clave">
                    </div>
                    <div class="login-form-button-box">
                        <button type="submit">Login</button>
                    </div>
                </div>
            </form>
            <div class="login-form-forget-box">
                <div class="copyright">
                    <img src="images/bandera.png" alt="Bandera de Estados Unidos" style="width: 30px; height: auto; margin-right: 10px; vertical-align: middle;">
                    <span style="vertical-align: middle;">&copy; Nexera Corp <?php echo date("Y"); ?></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="sistema/vendor/jquery/jquery.min.js"></script>
    <script src="sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="sistema/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="sistema/js/sb-admin-2.min.js"></script>
    <script src="sistema/js/snackbar.min.js"></script>
    <!-- Añade estas líneas en el head de tu HTML -->
    

</body>
</html>