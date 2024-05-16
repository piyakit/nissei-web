<?php
// Your PHP code for getData.php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $month = date('n');
    $year = date('Y'); 
    // Build the SQL query based on filters
    $sql = "SELECT DISTINCT b.FG_PART AS fg_part, CUSTOMER AS customer_name,f.qty_local,f.qty_boi,f.`month`,f.`year`, MONTH1_LOCAL AS month1_local, MONTH2_LOCAL AS month2_local, MONTH3_LOCAL AS month3_local, MONTH4_LOCAL AS month4_local, MONTH5_LOCAL AS month5_local, MONTH6_LOCAL AS month6_local, MONTH7_LOCAL AS month7_local, MONTH8_LOCAL AS month8_local, MONTH9_LOCAL AS month9_local, MONTH10_LOCAL AS month10_local, MONTH11_LOCAL AS month11_local, MONTH12_LOCAL AS month12_local, MONTH1_BOI AS month1_boi, MONTH2_BOI AS month2_boi, MONTH3_BOI AS month3_boi, MONTH4_BOI AS month4_boi, MONTH5_BOI AS month5_boi, MONTH6_BOI AS month6_boi, MONTH7_BOI AS month7_boi, MONTH8_BOI AS month8_boi, MONTH9_BOI AS month9_boi, MONTH10_BOI AS month10_boi, MONTH11_BOI AS month11_boi, MONTH12_BOI AS month12_boi FROM bom AS b LEFT JOIN forecast f ON b.FG_PART = f.FG_PART WHERE 1 AND ((f.month = :month AND f.year = :year) OR (f.month IS NULL AND f.`year` IS NULL))";

    if (isset($_GET['customer']) && $_GET['customer'] !== '') {
        $sql .= " AND CUSTOMER LIKE :customer";
    }

    if (isset($_GET['fgPart']) && $_GET['fgPart'] !== '') {
        $sql .= " AND b.FG_PART LIKE :fgPart";
    }

    $sql .= " ORDER BY b.id";

    // Fetch data from the transaction table
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    // if ($customer) {
    //     $stmt->bindParam(':customer', $customer, PDO::PARAM_STR);
    // }
    // if ($fgPart) {
    //     $stmt->bindParam(':fgPart', $fgPart, PDO::PARAM_STR);
    // }

    if (isset($_GET['customer']) && $_GET['customer'] !== '') {
        $customerParam = '%' . $_GET['customer'] . '%';
        $stmt->bindParam(':customer', $customerParam, PDO::PARAM_STR);
    }

    if (isset($_GET['fgPart']) && $_GET['fgPart'] !== '') {
        $fgPartParam = '%' . $_GET['fgPart'] . '%';
        $stmt->bindParam(':fgPart', $fgPartParam, PDO::PARAM_STR);
    }


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
