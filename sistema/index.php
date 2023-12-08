<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Administration panel</h1>
	</div>

	<!-- Content Row -->
	<div class="row">

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_usuarios.php">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Users</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['usuarios']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-user fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_cliente.php">
			<div class="card border-left-success shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Customers</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['clientes']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-users fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		<!-- Earnings (Monthly) Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="lista_productos.php">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Products</div>
							<div class="row no-gutters align-items-center">
								<div class="col-auto">
									<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $data['productos']; ?></div>
								</div>
								<div class="col">
									<div class="progress progress-sm mr-2">
										<div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>

		

		<!-- Pending Requests Card Example -->
		<a class="col-xl-3 col-md-6 mb-4" href="ventas.php">
			<div class="card border-left-warning shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sales</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data['ventas']; ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>


	  <!-- Nueva Card para las CSLB Potentials -->
	  <a class="col-xl-3 col-md-6 mb-4" href="cslb_potential.php">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">CSLB Potentials</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo isset($data['potentials']) ? $data['potentials'] : 'CONSULT'; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>



	
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Setting</h1>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header bg-secondary text-white">
				Personal information
				</div>
				<div class="card-body">
					<div class="form-group">
						<label>Name: <strong><?php echo $_SESSION['nombre']; ?></strong></label>
					</div>
					<div class="form-group">
						<label>Email: <strong><?php echo $_SESSION['email']; ?></strong></label>
					</div>
					<div class="form-group">
						<label>Rol: <strong><?php echo $_SESSION['rol_name']; ?></strong></label>
					</div>
					<div class="form-group">
						<label>User: <strong><?php echo $_SESSION['user']; ?></strong></label>
					</div>
					<ul class="list-group">
						<li class="list-group-item bg-secondary text-white ">Change Password</li>
						<form action="" method=" post" name="frmChangePass" id="frmChangePass" class="p-3">
							<div class="form-group">
								<label>Current password</label>
								<input type="password" name="actual" id="actual" placeholder="Current password" required class="form-control">
							</div>
							<div class="form-group">
								<label>New Password</label>
								<input type="password" name="nueva" id="nueva" placeholder="New Password" required class="form-control">
							</div>
							<div class="form-group">
								<label>Confirm Password</label>
								<input type="password" name="confirmar" id="confirmar" placeholder="Confirm Password" required class="form-control">
							</div>
							<div class="alertChangePass" style="display:none;">
							</div>
							<div>
								<button type="submit" class="btn btn-danger btnChangePass">Change Password</button>
							</div>
						</form>
					</ul>
				</div>
			</div>
		</div>
		<?php if ($_SESSION['rol'] == 1) { ?>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white">
					Company data
					</div>
					<div class="card-body">
						<form action="empresa.php" method="post" id="frmEmpresa" class="p-3">
							<div class="form-group">
								<label>IDE:</label>
								<input type="number" name="txtDni" value="<?php echo $dni; ?>" id="txtDni" placeholder="Dni de la Empresa" required class="form-control">
							</div>
							<div class="form-group">
								<label>Name:</label>
								<input type="text" name="txtNombre" class="form-control" value="<?php echo $nombre_empresa; ?>" id="txtNombre" placeholder="Company name" required class="form-control">
							</div>
							<div class="form-group">
								<label>Business name:</label>
								<input type="text" name="txtRSocial" class="form-control" value="<?php echo $razonSocial; ?>" id="txtRSocial" placeholder="The business social reason">
							</div>
							<div class="form-group">
								<label>Phone:</label>
								<input type="number" name="txtTelEmpresa" class="form-control" value="<?php echo $telEmpresa; ?>" id="txtTelEmpresa" placeholder="Company phone" required>
							</div>
							<div class="form-group">
								<label>Email:</label>
								<input type="email" name="txtEmailEmpresa" class="form-control" value="<?php echo $emailEmpresa; ?>" id="txtEmailEmpresa" placeholder="Company Email" required>
							</div>
							<div class="form-group">
								<label>Address:</label>
								<input type="text" name="txtDirEmpresa" class="form-control" value="<?php echo $dirEmpresa; ?>" id="txtDirEmpresa" placeholder="Company address" required>
							</div>
							<div class="form-group">
								<label>IGV (%):</label>
								<input type="text" name="txtIgv" class="form-control" value="<?php echo $igv; ?>" id="txtIgv" placeholder="Company VAT" required>
							</div>
							<?php echo isset($alert) ? $alert : ''; ?>
							<div>
								<button type="submit" class="btn btn-success btnChangePass"><i class="fas fa-save"></i>Save data</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="col-lg-6">
				<div class="card">
					<div class="card-header bg-secondary text-white">
					Company data
					</div>
					<div class="card-body">
						<div class="p-3">
							<div class="form-group">
								<strong>IDE:</strong>
								<h6><?php echo $dni; ?></h6>
							</div>
							<div class="form-group">
								<strong>Name:</strong>
								<h6><?php echo $nombre_empresa; ?></h6>
							</div>
							<div class="form-group">
								<strong>Business name:</strong>
								<h6><?php echo $razonSocial; ?></h6>
							</div>
							<div class="form-group">
								<strong>Phone:</strong>
								<?php echo $telEmpresa; ?>
							</div>
							<div class="form-group">
								<strong>Email:</strong>
								<h6><?php echo $emailEmpresa; ?></h6>
							</div>
							<div class="form-group">
								<strong>Dirección:</strong>
								<h6><?php echo $dirEmpresa; ?></h6>
							</div>
							<div class="form-group">
								<strong>IGV (%):</strong>
								<h6><?php echo $igv; ?></h6>
							</div>

						</div>
					</div>
				</div>
			</div>

		<?php } ?>
	</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include_once "includes/footer.php"; ?>