<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
		<div class="sidebar-brand-icon rotate-n-15">
			<img src="img/logo2.png" class="img-thumbnail">
		</div>
		
	</a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog" style="color: orange;"></i>
            <span style="color: orange;">Sales</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="nueva_venta.php">New sale</a>
                <a class="collapse-item" href="ventas.php">Sales</a>
                <a class="collapse-item" href="cslb_ca.gov.php">cslb-ca.gov</a>
                <a class="collapse-item" href="cslb_potential.php">cslb-Potential</a>
                <a class="collapse-item" href="potential_contac.php">potential agenda</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Clientes Collapse Menu -->
    <?php if ($_SESSION['rol'] != 2) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-users" style="color: orange;"></i>
                <span style="color: orange;">Customers</span>
            </a>
            <div id="collapseClientes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="registro_cliente.php">New Customers</a>
                    <a class="collapse-item" href="lista_cliente.php">Customers</a>
                </div>
            </div>
        </li>
    <?php } ?>

    <!-- Nav Item - Utilities Collapse Menu -->
    <?php if ($_SESSION['rol'] == 1) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench" style="color: orange;"></i>
                <span style="color: orange;">Services</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="registro_producto.php">New Service</a>
                    <a class="collapse-item" href="lista_productos.php">Services</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProveedor" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-hospital" style="color: orange;"></i>
                <span style="color: orange;">Proveedor</span>
            </a>
            <div id="collapseProveedor" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="registro_proveedor.php">New supplier</a>
                    <a class="collapse-item" href="lista_proveedor.php">supplier</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Usuarios Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-user" style="color: orange;"></i>
                <span style="color: orange;">Users</span>
            </a>
            <div id="collapseUsuarios" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="registro_usuario.php">New User</a>
                    <a class="collapse-item" href="lista_usuarios.php">Users</a>
                </div>
            </div>
        </li>

       
    <?php } ?>

</ul>
