<?php
// Your PHP code for updateForcastData.php

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
        $month = date('n');
        $year = date('Y'); // Get current year
        // Validate and sanitize data as needed

        // Get current date and time
        $currentDate = date('Y-m-d H:i:s');

        // Check if the FG_PART already exists in the forecast table
        $stmt_check = $pdo->prepare("SELECT COUNT(*) AS count FROM forecast WHERE FG_PART = :fgPart AND month = :month AND year = :year");
        $stmt_check->bindParam(':fgPart', $fgPart, PDO::PARAM_STR);
        $stmt_check->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt_check->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt_check->execute();
        $result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($result_check['count'] > 0) {
            // FG_PART exists, perform update
            $stmt = $pdo->prepare("UPDATE forecast SET qty_".$type." = :newQty, updatedate = :currentDate WHERE FG_PART = :fgPart AND month = :month AND year = :year");
        } else {
            // FG_PART does not exist, perform insert
            $stmt = $pdo->prepare("INSERT INTO forecast (FG_PART, qty_".$type.", month, year, createdate, updatedate) VALUES (:fgPart, :newQty, :month, :year, :currentDate, :currentDate)");
        }

        // Bind parameters and execute the statement
        $stmt->bindParam(':fgPart', $fgPart, PDO::PARAM_STR);
        $stmt->bindParam(':newQty', $newQty, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);

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
    echo json_encode(['status' => 'error', 'message' => 'Error updating quantity: ' . $e->getMessage()]);
}
?>
