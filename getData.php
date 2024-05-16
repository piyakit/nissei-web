<?php
// Your PHP code for getData.php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Build the SQL query based on filters
    $sql = "SELECT 
    MATERIAL AS material, 
    MATERIAL_CODE AS material_code, 
    VENDOR AS vendor, 
    0 AS price, 
    QTY AS qty, 
    UNIT AS unit, 
    b.FG_PART AS fg_part, 
    CUSTOMER AS customer,
    COALESCE(b.MONTH1_local, '') AS MONTH1_local,
    COALESCE(b.MONTH2_local, '') AS MONTH2_local,
    COALESCE(b.MONTH3_local, '') AS MONTH3_local,
    COALESCE(b.MONTH4_local, '') AS MONTH4_local,
    COALESCE(b.MONTH5_local, '') AS MONTH5_local,
    COALESCE(b.MONTH6_local, '') AS MONTH6_local,
    COALESCE(b.MONTH7_local, '') AS MONTH7_local,
    COALESCE(b.MONTH8_local, '') AS MONTH8_local,
    COALESCE(b.MONTH9_local, '') AS MONTH9_local,
    COALESCE(b.MONTH10_local, '') AS MONTH10_local,
    COALESCE(b.MONTH11_local, '') AS MONTH11_local,
    COALESCE(b.MONTH12_local, '') AS MONTH12_local,
    COALESCE(b.MONTH1_boi, '') AS MONTH1_boi,
    COALESCE(b.MONTH2_boi, '') AS MONTH2_boi,
    COALESCE(b.MONTH3_boi, '') AS MONTH3_boi,
    COALESCE(b.MONTH4_boi, '') AS MONTH4_boi,
    COALESCE(b.MONTH5_boi, '') AS MONTH5_boi,
    COALESCE(b.MONTH6_boi, '') AS MONTH6_boi,
    COALESCE(b.MONTH7_boi, '') AS MONTH7_boi,
    COALESCE(b.MONTH8_boi, '') AS MONTH8_boi,
    COALESCE(b.MONTH9_boi, '') AS MONTH9_boi,
    COALESCE(b.MONTH10_boi, '') AS MONTH10_boi,
    COALESCE(b.MONTH11_boi, '') AS MONTH11_boi,
    COALESCE(b.MONTH12_boi, '') AS MONTH12_boi,
    COALESCE(ROUND(b.qty * forecast.qty_local, 2), 0) as qty_local,
	COALESCE(ROUND(b.qty * forecast.qty_boi, 2), 0) as qty_boi,
    COALESCE(forecast.qty_local,0) as forecast_local,
	COALESCE(forecast.qty_boi,0) as forecast_boi
  FROM 
    bom AS b 
  LEFT JOIN
    forecast ON 
    forecast.FG_PART = b.FG_PART AND
    forecast.`month` = MONTH(CURRENT_DATE()) AND
    forecast.`year` = YEAR(CURRENT_DATE())
  WHERE 
    1";

    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $sql .= " AND MATERIAL LIKE :material";
    }

    if (isset($_GET['material_code']) && $_GET['material_code'] !== '') {
        $sql .= " AND material_code LIKE :material_code";
    }

    if (isset($_GET['vendor']) && $_GET['vendor'] !== '') {
        $sql .= " AND vendor LIKE :vendor";
    }

    if (isset($_GET['fgPart']) && $_GET['fgPart'] !== '') {
        $sql .= " AND b.FG_PART LIKE :fgPart";
    }

    $sql .= " LIMIT 50";
    // Fetch data from the transaction table
    $stmt = $pdo->prepare($sql);

    // Bind parameters if they are set
    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $materialParam = '%' . $_GET['material'] . '%';
        $stmt->bindParam(':material', $materialParam, PDO::PARAM_STR);
    }

    if (isset($_GET['material_code']) && $_GET['material_code'] !== '') {
        $materialCodeParam = '%' . $_GET['material_code'] . '%';
        $stmt->bindParam(':material_code', $materialCodeParam, PDO::PARAM_STR);
    }

    if (isset($_GET['vendor']) && $_GET['vendor'] !== '') {
        $vendorParam = '%' . $_GET['vendor'] . '%';
        $stmt->bindParam(':vendor', $vendorParam, PDO::PARAM_STR);
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
