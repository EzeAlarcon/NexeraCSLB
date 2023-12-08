<?php include_once "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">CSLB Administration Panel By cslb.ca.gov</h1>

    <!-- Search Form -->
    <form action="save_licence.php" method="post" id="licenseForm">
        <div class="row">
            <div class="col-md-4">
                <label for="numero_licencia">License Number:</label>
                <input type="number" name="numero_licencia" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="business">Business:</label>
                <input type="text" name="business" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label for="address">Address:</label>
                <input type="text" name="address" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="city">City:</label>
                <input type="text" name="city" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="state">State:</label>
                <input type="text" name="state" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="zip">ZIP:</label>
                <input type="number" name="zip" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="phone">Phone:</label>
                <input type="phone" name="phone" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="entity">Entity:</label>
                <input type="text" name="entity" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="entity_issued">Entity Issued:</label>
                <input type="text" name="entity_issued" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="entity_expire">Entity Expire:</label>
                <input type="text" name="entity_expire" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="classifications">Classifications:</label>
                <input type="text" name="classifications" class="form-control" required>
            </div>

            <div class="col-md-4 mt-4">
                <button type="button" class="btn btn-warning" onclick="searchLicense()">Search</button>
            </div>
        </div>

        <!-- Workers Comp Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <h5>Workers Comp:</h5>
            </div>
            <div class="col-md-4">
                <!-- ... (otros campos) ... -->
            </div>
        </div>

        <!-- Additional Fields -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label for="status">Status:</label>
                <input type="text" name="status" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="effective_date">Effective Date:</label>
                <input type="text" name="effective_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="expire_date">Expire Date:</label>
                <input type="text" name="expire_date" class="form-control" required>
            </div>
        </div>

        <!-- Personnel List Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <h5>Personnel List:</h5>
            </div>
            <div class="col-md-4">
                <!-- ... (otros campos) ... -->
            </div>
        </div>

        <!-- Additional Fields -->
        <div class="row mt-4">
            <div class="col-md-4">
                <label for="ceo_primary">CEO PRIMARY:</label>
                <input type="text" name="ceo_primary" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="holder_type">HOLDER TYPE:</label>
                <input type="text" name="holder_type" class="form-control" required>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <label for="notes">Notes:</label>
                <textarea name="notes" class="form-control"></textarea>
            </div>
        </div>

        <!-- Buttons for Next and Save -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary" onclick="nextLicense()">Next</button>
                <button type="submit" class="btn btn-success" onclick="saveLicense()">Save</button>
                
                
            </div>
        </div>
    </form>


<!-- Resto del código JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function searchLicense() {
        var licenseNumber = $("input[name='numero_licencia']").val();

        $.ajax({
            url: "https://cslb.nexeraadvisors.com/api/licenseMaster/" + licenseNumber,
            type: "GET",
            success: function (data) {
                console.log(data);
                if (data && data.license) {
                    fillFields(data);
                } else {
                    alert("Data format is incorrect. Please try again.");
                }
            },
            error: function () {
                alert("Error fetching data. Please try again.");
            }
        });
    }

    function fillFields(data) {
        if (data && data.license) {
            $("input[name='business']").val(data.license.BusinessName || '');
            $("input[name='address']").val(data.license.MailingAddress || '');
            $("input[name='city']").val(data.license.City || '');
            $("input[name='state']").val(data.license.State || '');
            $("input[name='zip']").val(data.license.ZIPCode || '');
            $("input[name='phone']").val(data.license.BusinessPhone || '');
            $("input[name='entity']").val(data.license.BusinessType || '');
            $("input[name='entity_issued']").val(data.license.IssueDate || '');
            $("input[name='entity_expire']").val(data.license.IssueDate || '');
            $("input[name='classifications']").val(data.license.Classifications || '');
            $("input[name='workers_comp']").val(data.workers_comp || '');
            $("input[name='status']").val(data.license.WorkersCompCoverageType || '');
            $("input[name='policy_number']").val(data.policy_number || '');
            $("input[name='effective_date']").val(data.license.WCEffectiveDate || '');
            $("input[name='expire_date']").val(data.license.ExpirationDate || '');
            $("input[name='ceo_primary']").val(data.personalList ? data.personalList.Name || '' : '');
            $("input[name='holder_type']").val(data.license.BusinessType || '');
        } else {
            alert("Data format is incorrect. Please try again.");
        }
    }

    function nextLicense() {
        var currentLicense = $("input[name='numero_licencia']").val();
        console.log("Current License:", currentLicense);

        // Limpia todos los campos, excepto el de licencia
        clearFieldsExceptLicense();

        // Obtén el siguiente número de licencia después de limpiar los campos
        var nextLicense = getNextLicenseNumber(currentLicense);
        $("input[name='numero_licencia']").val(nextLicense);
    }

    function clearFieldsExceptLicense() {
        // Limpia todos los campos excepto el de licencia
        $("#licenseForm :input").not("[name='numero_licencia']").val('');
    }


    function saveLicense(event) {
    event.preventDefault();

    var formData = $("#licenseForm").serialize();
    $.ajax({
        url: "save_licence.php",
        type: "POST",
        data: formData,
        success: function (response) {
            if (response.trim() === "CSLB POTENTIAL SAVED CORRECTLY.") {
                // Mostrar alerta solo si la respuesta es la esperada
                alert("CSLB POTENTIAL SAVED CORRECTLY.");

                // Limpiar todos los campos (excepto el de licencia)
                clearAllFieldsExceptLicense();

                // Avanzar al siguiente número de licencia después de guardar
                nextLicense();
            } else {
                alert("Error: " + response);  // Mostrar mensaje de error si la respuesta no es la esperada
            }
        },
        error: function () {
            alert("Error sending your request. Please try again.");
        }
    });
}

function clearAllFieldsExceptLicense() {
    // Limpiar todos los campos del formulario excepto el de licencia
    $("#licenseForm :input:not([name='numero_licencia'])").val('');
}





    // Asociar la función nextLicense al evento click del botón Next
    $("#nextButton").click(nextLicense);

    function getNextLicenseNumber(currentLicense) {
        // Asegúrate de que currentLicense no sea undefined o null
        if (currentLicense != undefined && currentLicense != null) {
            var parsedLicense = parseInt(currentLicense);
            if (!isNaN(parsedLicense)) {
                // Incrementa solo si es un número válido
                return parsedLicense + 1;
            }
        }
        // Si no es un número válido, devolver currentLicense
        console.error("Error: El número de licencia actual no es válido.");
        return currentLicense;
    }

    function clearFieldsExceptLicense() {
        // Limpia todos los campos excepto el de licencia
        $("#licenseForm :input").not("[name='numero_licencia']").val('');
    }
</script>

</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>





