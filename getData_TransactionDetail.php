<?php
// getTransactionDetail.php

// Assuming you have a database connection already established
$pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get the transactionId from the GET parameters
$transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : null;

if ($transactionId) {
    try {
        // Prepare and execute a query to fetch details for the specified transaction
        $stmt = $pdo->prepare("SELECT * FROM transaction_detail WHERE transaction_id = :transactionId");
        $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the details as an associative array
        $transactionDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return details as JSON response
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $transactionDetails]);
    } catch (PDOException $e) {
        // Log the error to the console
        error_log('Error: ' . $e->getMessage());

        // Return an error JSON response
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Error fetching transaction details.']);
    }
} else {
    // Return an error JSON response if transactionId is not provided
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Transaction ID not provided.']);
}
?>
