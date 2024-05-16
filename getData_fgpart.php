<?php
// Your modified PHP code for getData.php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Build the SQL query based on filters
    $sql = "SELECT DISTINCT FG_PART as fg_part FROM bom WHERE 1;";
    // Fetch data from the joined tables
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the database connection
    $pdo = null;

    // Return data as JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    // Log the error to the console
    error_log('Error: ' . $e->getMessage());

    // Send a JSON response indicating failure
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error fetching data.']);
}
?>
