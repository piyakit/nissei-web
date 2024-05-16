<?php
// Your PHP code for getData.php

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
        // Get the form data
        //$transactionName = $_POST['transaction_name'];
        $transactionName = "TEST NAME 001";
        $customerName = $_POST['customer_name'];
        $status = "pending";
        $qty = $_POST['qty'];
        $fg_part = $_POST['fgPart'];
        $type = $_POST['type'];
        // Validate and sanitize data as needed

        // Get current date and time
        $currentDate = date('Y-m-d H:i:s');

        // Perform your database insertion
        $stmt = $pdo->prepare("INSERT INTO transaction (transaction_name, customer_name, create_by, update_by, status, create_date, update_date,fg_part,type) VALUES (:transactionName,:customerName , :createBy, :updateBy, :status, :currentDate, :currentDate, :fgpart, :type)");
        $stmt->bindParam(':transactionName', $transactionName, PDO::PARAM_STR);
        $stmt->bindParam(':customerName', $customerName, PDO::PARAM_STR);
        $stmt->bindParam(':createBy', $createBy, PDO::PARAM_STR);
        $stmt->bindParam(':updateBy', $updateBy, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindParam(':fgpart', $fg_part, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Send success response
            echo json_encode(['status' => 'success']);
        } else {
            // Send error response
            echo json_encode(['status' => 'error', 'message' => 'Error inserting data']);
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
    echo json_encode(['status' => 'error', 'message' => 'Error fetching data.']);
}
