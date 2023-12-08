<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">USERS</h1>
        <?php if ($_SESSION['rol'] == 1) { ?>
            <a href="registro_usuario.php" class="btn btn-warning">New</a>
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL</th>
                            <th>USER</th>
                            <th>ADDRESS</th>
                            <th>URL SERVER</th>
                            <th>PBX USERNAME</th>
                            <th>PASSWORD PBX</th>
                            <th>CID</th>
                            <th>EXTENSION SRC</th>
                            <?php if ($_SESSION['rol'] == 1) { ?>
                                <th>ACTIONS</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, u.address, u.url_server, u.pbx_username, u.password_pbx, u.cid, u.extension_src, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['idusuario']; ?></td>
                                    <td><?php echo $data['nombre']; ?></td>
                                    <td><?php echo $data['correo']; ?></td>
                                    <td><?php echo $data['usuario']; ?></td>
                                    <td><?php echo $data['address']; ?></td>
                                    <td><?php echo $data['url_server']; ?></td>
                                    <td><?php echo $data['pbx_username']; ?></td>
                                    <td><?php echo $data['password_pbx']; ?></td>
                                    <td><?php echo $data['cid']; ?></td>
                                    <td><?php echo $data['extension_src']; ?></td>
                                    <?php if ($_SESSION['rol'] == 1) { ?>
                                        <td>
                                            <a href="editar_usuario.php?id=<?php echo $data['idusuario']; ?>" class="btn btn-success"><i class='fas fa-edit'></i> Edit</a>
                                            <form action="eliminar_usuario.php?id=<?php echo $data['idusuario']; ?>" method="post" class="confirmar d-inline">
                                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                            </form>
                                        </td>
                                    <?php } ?>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php include_once "includes/footer.php"; ?>
