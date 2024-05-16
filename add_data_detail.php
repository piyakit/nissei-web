<?php
// add_data_detail.php

try {
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login.php
        header("Location: login.php");
        exit();
    }

    // Assuming $_SESSION['username'] contains the username information
    $createBy = $_SESSION['username'];
    $updateBy = $_SESSION['username'];
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve existing form data
        $existingData = isset($_POST['existingData']) ? $_POST['existingData'] : [];
        $fgPart = isset($existingData['fgPart']) ? $existingData['fgPart'] : '';
        $qty = isset($existingData['qty']) ? $existingData['qty'] : '';
        $type = isset($existingData['type']) ? $existingData['type'] : '';
        $create_by = isset($existingData['create_by']) ? $existingData['create_by'] : '';
        $create_date = isset($existingData['create_date']) ? $existingData['create_date'] : '';
        $months = isset($existingData['month']) ? $existingData['month'] : '';
        $transaction_id =  isset($existingData['transaction_id']) ? $existingData['transaction_id'] : '';
        // Retrieve new material data
        $newMaterialData = isset($_POST['newMaterialData']) ? $_POST['newMaterialData'] : [];
        $currentDate = date('Y-m-d H:i:s');
        // Validate and sanitize data as needed

        // Get current date and time
        $currentDate = date('Y-m-d H:i:s');
        foreach ($newMaterialData as $material) {
            $stmt = $pdo->prepare("INSERT INTO transaction_detail (transaction_id,fg_part,qty,type,create_by,update_by,material_name,month, create_date, update_date) VALUES (:transaction_id,:fgPart,:qty,:type,:create_by,:update_by,:material_name,:months,:currentDate, :currentDate)");
            $stmt->bindParam(':transaction_id', $transaction_id, PDO::PARAM_STR);
            $stmt->bindParam(':fgPart', $fgPart, PDO::PARAM_STR);
            $stmt->bindParam(':qty', $qty, PDO::PARAM_STR);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->bindParam(':create_by', $createBy, PDO::PARAM_STR);
            $stmt->bindParam(':update_by', $updateBy, PDO::PARAM_STR);
            $stmt->bindParam(':months', $months, PDO::PARAM_STR);
            $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
            $materialName = $material['material_name'];
            // // Bind parameters for material details
             $stmt->bindParam(':material_name', $materialName, PDO::PARAM_STR);
            // // Execute the statement for each material
            $stmt->execute();
        }
        // Send success response
        echo json_encode(['status' => 'success']);
    } else {
        // Send error response for unsupported request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    // Log the error to the console
    error_log('Error: ' . $e->getMessage());

    // Send a JSON response indicating failure
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
