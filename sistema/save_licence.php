<?php
include "../conexion.php";

// Verifica si los datos del formulario se enviaron mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera y verifica los datos del formulario
    $numero_licencia = isset($_POST['numero_licencia']) ? mysqli_real_escape_string($conexion, $_POST['numero_licencia']) : '';

    // Consultar si la licencia ya está en la base de datos
    $consulta = "SELECT * FROM cslb_data WHERE numero_licencia = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param('s', $numero_licencia);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si la licencia ya existe
    if ($resultado->num_rows > 0) {
        // La licencia ya existe, puedes mostrar un mensaje de error
        echo "This license has already been registered.";
        exit; // Otra acción según tus requerimientos
    }

    // Si la licencia no existe, procedemos a insertar los datos en la base de datos

    $business = isset($_POST['business']) ? mysqli_real_escape_string($conexion, $_POST['business']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conexion, $_POST['address']) : '';
    $city = isset($_POST['city']) ? mysqli_real_escape_string($conexion, $_POST['city']) : '';
    $state = isset($_POST['state']) ? mysqli_real_escape_string($conexion, $_POST['state']) : '';
    $zip = isset($_POST['zip']) ? mysqli_real_escape_string($conexion, $_POST['zip']) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conexion, $_POST['phone']) : '';
    $entity = isset($_POST['entity']) ? mysqli_real_escape_string($conexion, $_POST['entity']) : '';
    $entity_issued = isset($_POST['entity_issued']) ? mysqli_real_escape_string($conexion, $_POST['entity_issued']) : '';
    $entity_expire = isset($_POST['entity_expire']) ? mysqli_real_escape_string($conexion, $_POST['entity_expire']) : '';
    $classifications = isset($_POST['classifications']) ? mysqli_real_escape_string($conexion, $_POST['classifications']) : '';
    $workers_comp = isset($_POST['workers_comp']) ? mysqli_real_escape_string($conexion, $_POST['workers_comp']) : '';
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conexion, $_POST['status']) : '';
    $policy_number = isset($_POST['policy_number']) ? mysqli_real_escape_string($conexion, $_POST['policy_number']) : '';
    $effective_date = isset($_POST['effective_date']) ? mysqli_real_escape_string($conexion, $_POST['effective_date']) : '';
    $expire_date = isset($_POST['expire_date']) ? mysqli_real_escape_string($conexion, $_POST['expire_date']) : '';
    $ceo_primary = isset($_POST['ceo_primary']) ? mysqli_real_escape_string($conexion, $_POST['ceo_primary']) : '';
    $holder_type = isset($_POST['holder_type']) ? mysqli_real_escape_string($conexion, $_POST['holder_type']) : '';
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($conexion, $_POST['notes']) : '';

    // Consulta SQL para insertar los datos en la base de datos
    $query = "INSERT INTO cslb_data (numero_licencia, business, address, city, state, zip, phone, entity, entity_issued, entity_expire, classifications, workers_comp, status, effective_date, expire_date, ceo_primary, holder_type, notes) 
    VALUES ('$numero_licencia', '$business', '$address', '$city', '$state', '$zip', '$phone', '$entity', '$entity_issued', '$entity_expire', '$classifications', '$workers_comp', '$status', '$effective_date', '$expire_date', '$ceo_primary', '$holder_type', '$notes')";

    // Ejecuta la consulta
    if (mysqli_query($conexion, $query)) {
        echo "CSLB POTENTIAL SAVED CORRECTLY.";
    } else {
        echo "ERROR SAVING CSLB POTENTIAL: " . mysqli_error($conexion);
    }

    // Cierra la conexión
    mysqli_close($conexion);

    // Redirige al usuario de nuevo a la página original
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
