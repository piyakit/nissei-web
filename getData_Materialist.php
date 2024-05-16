<?php
// Your PHP code for getData.php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "";
    // Build the SQL query based on filters
    $sql = "SELECT 
                ml.material,
                ml.material_code,
                ml.vendor,
                ml.groups,
                ml.price_local,
                ml.price_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH1_local, 2)), '') as MONTH1_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH2_local, 2)), '') as MONTH2_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH3_local, 2)), '') as MONTH3_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH4_local, 2)), '') as MONTH4_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH5_local, 2)), '') as MONTH5_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH6_local, 2)), '') as MONTH6_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH7_local, 2)), '') as MONTH7_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH8_local, 2)), '') as MONTH8_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH9_local, 2)), '') as MONTH9_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH10_local, 2)), '') as MONTH10_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH11_local, 2)), '') as MONTH11_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH12_local, 2)), '') as MONTH12_local,
                COALESCE(SUM(ROUND(b.qty * b.MONTH1_boi, 2)), '') as MONTH1_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH2_boi, 2)), '') as MONTH2_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH3_boi, 2)), '') as MONTH3_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH4_boi, 2)), '') as MONTH4_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH5_boi, 2)), '') as MONTH5_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH6_boi, 2)), '') as MONTH6_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH7_boi, 2)), '') as MONTH7_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH8_boi, 2)), '') as MONTH8_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH9_boi, 2)), '') as MONTH9_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH10_boi, 2)), '') as MONTH10_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH11_boi, 2)), '') as MONTH11_boi,
                COALESCE(SUM(ROUND(b.qty * b.MONTH12_boi, 2)), '') as MONTH12_boi,
                COALESCE(SUM(ROUND(b.qty * forecast.qty_local, 2)), '') as qty_local,
                COALESCE(SUM(ROUND(b.qty * forecast.qty_boi, 2)), '') as qty_boi
            FROM material_lists ml
            LEFT JOIN bom b ON ml.MATERIAL = b.MATERIAL
            LEFT JOIN
                forecast ON 
                forecast.FG_PART = b.FG_PART AND
                forecast.`month` = MONTH(CURRENT_DATE()) AND
                forecast.`year` = YEAR(CURRENT_DATE()) 
            WHERE 1";

    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $sql .= " AND ml.MATERIAL LIKE :material";
    }

    if (isset($_GET['material_code']) && $_GET['material_code'] !== '') {
        $sql .= " AND ml.material_code LIKE :material_code";
    }

    if (isset($_GET['vendor']) && $_GET['vendor'] !== '') {
        $sql .= " AND ml.vendor LIKE :vendor";
    }

    if (isset($_GET['groups']) && $_GET['groups'] !== '') {
        $sql .= " AND ml.groups LIKE :groups";
    }

    $sql .= " GROUP BY ml.material,ml.material_code, ml.vendor, ml.groups, ml.price_local, ml.price_boi";

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

    if (isset($_GET['groups']) && $_GET['groups'] !== '') {
        $groupsParam = '%' . $_GET['groups'] . '%';
        $stmt->bindParam(':groups', $groupsParam, PDO::PARAM_STR);
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
