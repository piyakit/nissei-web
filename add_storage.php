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
    $quantity = $_POST['qty'] ?? '';
    $unit = $_POST['unit'] ?? '';
    $fgPart = $_POST['fgPart'] ?? '';
    $currentDateTime = date('Y-m-d H:i:s');

    // Perform necessary database operations (replace with your actual database logic)
    // Example: Inserting data into a table named 'material_lists'
    // Replace 'your_db_connection' and 'your_table_name' with actual values
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO material_lists (MATERIAL, QTY, UNIT, FG_PART, CREATE_DATE, UPDATE_DATE) VALUES (:materialName, :quantity, :unit, :fgPart, :currentDateTime, :currentDateTime)");
        $stmt->bindParam(':materialName', $materialName);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':fgPart', $fgPart);
        $stmt->bindParam(':currentDateTime', $currentDateTime);
        $stmt->execute();

        // Send a success response (you can customize this based on your needs)
        $response = array('status' => 'success');
        echo json_encode($response);
        exit();
    } catch (PDOException $e) {
        // Handle database error
        // Log or display the error message
        $response = array('status' => 'error', 'message' => 'Database error. Please try again.');
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
    <title>Add Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <h3 class="mb-4">Add Storage</h3>
                <form id="addMaterialForm" method="post">
                    <div class="mb-3">
                        <label for="materialName" class="form-label">Material Name</label>
                        <input type="text" class="form-control" id="materialName" name="materialName" required>
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
                        <label for="fgPart" class="form-label">F.G. Part</label>
                        <input type="text" class="form-control" id="fgPart" name="fgPart" required>
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
                    qty: $('#qty').val(),
                    unit: $('#unit').val(),
                    fgPart: $('#fgPart').val()
                };

                // Perform AJAX request to add material
                $.ajax({
                    type: "POST",
                    url: "add_mat.php", // Update with the correct page URL
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            // Handle success, e.g., show a success message
                            window.location.href = "meterial_lists.php";
                        } else {
                            // Handle error, e.g., display an error message
                            alert("Error adding material: " + response.message);
                        }
                    },
                    error: function() {
                        console.error("AJAX Error: Unable to add material.");
                    }
                });
            });
        });
    </script>
</body>

</html>