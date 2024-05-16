<?php
// Your PHP code for updateQuantity.php

try {
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login.php
        header("Location: login.php");
        exit();
    }

    // Assuming $_SESSION['username'] contains the username information
    $updateBy = $_SESSION['username'];
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $fgPart = $_POST['fgPart'];
        $newQty = $_POST['new_qty'];
        $type = $_POST['type'];
        $month = $_POST['month'];
        // Validate and sanitize data as needed

        // Get current date and time
        $currentDate = date('Y-m-d H:i:s');

        // Perform your database update
        $stmt = $pdo->prepare("UPDATE bom SET month" . $month . "_" . $type . " = :newQty WHERE fg_part = :fgPart");

        $stmt->bindParam(':newQty', $newQty, PDO::PARAM_STR);
        $stmt->bindParam(':fgPart', $fgPart, PDO::PARAM_STR);
        if ($stmt->execute()) {
            // Send success response
            echo json_encode(['status' => 'success']);
        } else {
            // Send error response
            echo json_encode(['status' => 'error', 'message' => 'Error updating quantity']);
        }
    } else {
        // Send error response for unsupported request method
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
} catch (PDOException $e) {
    // Log the error to the console
    error_log('Error: ' . $e->getMessage());

    // Send a JSON response indicating failure
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error updating quantity.']);
}
?>
