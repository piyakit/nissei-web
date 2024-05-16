<?php
// form_input_page.php

// Start session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php or another appropriate page
    header("Location: login.php");
    exit();
}

// Include your database connection code or configuration here

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle the form submission to insert data into the database

    // Validate and sanitize the input data (use appropriate validation functions)
    $materialName = $_POST['materialName'] ?? '';
    $materialCode = $_POST['materialCode'] ?? '';
    $group = $_POST['group'] ?? '';
    $qty = $_POST['qty'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $customer = $_POST['customer'] ?? '';
    $vendor = $_POST['vendor'] ?? '';
    $fgPart = $_POST['fgPart'] ?? '';
    $currentDateTime = date('Y-m-d H:i:s');
    // $updateBy = $_SESSION['username'];
    // Perform necessary database operations (replace with your actual database logic)
    // Example: Inserting data into a table named 'material_lists'
    // Replace 'your_db_connection' and 'your_table_name' with actual values
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO bom (MATERIAL, MATERIAL_CODE, FG_PART, `GROUPS`, QTY, UNIT, CUSTOMER, VENDOR, CREATE_DATE, UPDATE_DATE) VALUES (:materialName, :materialCode, :fgPart, :group, :qty, :unit, :customer, :vendor, :currentDateTime, :currentDateTime)");
        $stmt->bindParam(':materialName', $materialName);
        $stmt->bindParam(':materialCode', $materialCode);
        $stmt->bindParam(':fgPart', $fgPart);
        $stmt->bindParam(':group', $group);
        $stmt->bindParam(':qty', $qty);
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':customer', $customer);
        // $stmt->bindParam(':updateby', $updateBy);
        $stmt->bindParam(':vendor', $vendor);
        $stmt->bindParam(':currentDateTime', $currentDateTime);
        $stmt->execute();

        // Send a success response (you can customize this based on your needs)
        $response = array('status' => 'success');
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        // Handle database error
        // Log or display the error message
        $response = array('status' => 'error', 'message' => 'Database error: ' . $e->getMessage());

        echo json_encode($response);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Mat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        <?php include './css/style.css'; ?>.td-min-width {
            min-width: 100px;
            height: 100%;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-2 pb-2" style="background-color: #fff;">
                <h3 class="mb-4">Add Mat</h3>
                <form id="addMaterialForm" method="post">
                    <div class="mb-3">
                        <label for="fgPart" class="form-label">F.G. Part</label>
                        <input type="text" class="form-control" id="fgPart" name="fgPart" required>
                    </div>
                    <div class="mb-3">
                        <label for="materialName" class="form-label">Material Name</label>
                        <input type="text" class="form-control" id="materialName" name="materialName" required>
                    </div>
                    <div class="mb-3">
                        <label for="materialCode" class="form-label">Material Code</label>
                        <input type="text" class="form-control" id="materialCode" name="materialCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="group" class="form-label">Group</label>
                        <input type="text" class="form-control" id="group" name="group" required>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer" class="form-label">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" required>
                    </div>
                    <div class="mb-3">
                        <label for="vendor" class="form-label">Vendor</label>
                        <input type="text" class="form-control" id="vendor" name="vendor" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Material</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Submit form to add material
            $('#addMaterialForm').submit(function(e) {
                e.preventDefault();

                // Retrieve form data
                var formData = {
                    materialName: $('#materialName').val(),
                    unit: $('#unit').val(),
                    materialCode: $('#materialCode').val(),
                    group: $('#group').val(),
                    qty: $('#qty').val(),
                    unit: $('#unit').val(),
                    customer: $('#customer').val(),
                    vendor: $('#vendor').val(),
                    fgPart: $('#fgPart').val(),
                };

                // Perform AJAX request to add material
                $.ajax({
                    type: "POST",
                    url: "add_bom.php", // Update with the correct page URL
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // Handle success, e.g., show a success message
                            window.location.href = "bom.php";
                        } else {
                            // Handle error, e.g., display an error message
                            alert("Error adding bom: " + response.message);
                        }
                    },
                    error: function() {
                        console.error("AJAX Error: Unable to add bom.");
                    }
                });
            });
        });
    </script>
</body>

</html>