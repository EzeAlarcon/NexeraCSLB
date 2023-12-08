<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">CSLB Licenses</h1>
        <a href="cslb_ca.gov.php" class="btn btn-warning">Return CSLB License</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="thead-dark">
                        <tr>
                            <th>License Number</th>
                            <th>Business</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Phone</th>
                            <th>Entity</th>
                            <th>Entity Issued</th>
                            <th>Entity Expire</th>
                            <th>CEO PRIMARY</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT * FROM cslb_data");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            $counter = 0;
                            while ($data = mysqli_fetch_assoc($query)) {
                                $counter++;
                                ?>
                                <tr>
                                    <td><?php echo $data['numero_licencia']; ?></td>
                                    <td><?php echo $data['business']; ?></td>
                                    <td><?php echo $data['address']; ?></td>
                                    <td><?php echo $data['city']; ?></td>
                                    <td><?php echo $data['state']; ?></td>
                                    <td><?php echo $data['phone']; ?></td>
                                    <td><?php echo $data['entity']; ?></td>
                                    <td><?php echo $data['entity_issued']; ?></td>
                                    <td><?php echo $data['entity_expire']; ?></td>
                                    <td><?php echo $data['ceo_primary']; ?></td>
                                    <td><?php echo $data['notes']; ?></td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <?php if ($result > 5) { ?>
                <p>Total records: <?php echo $result; ?></p>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Script JavaScript para DataTables -->
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            "paging": true,
            "pageLength": 5,
            "searching": true,
            "info": false
        });
    });
</script>

<?php include_once "includes/footer.php"; ?>
