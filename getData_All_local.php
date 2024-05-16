<?php
// Your PHP code for getData.php
$sql = "";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $where = " WHERE 1";
    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $where .= " AND bom.material LIKE :material";
    }
    if (isset($_GET['groups']) && $_GET['groups'] !== '') {
        $where .= " AND bom.groups LIKE :groups";
    }

    if (isset($_GET['vendor']) && $_GET['vendor'] !== '') {
        $where .= " AND bom.vendor LIKE :vendor";
    }
    // Build the SQL query based on filters
    $sql = "SELECT
    bom.material,
    bom.vendor,
    'BOI' AS type,
    bom.qty,
    UNIT AS unit, 
    CUSTOMER AS customer,
    material_lists.price_local,
    material_lists.price_boi,
    material_lists.groups,
    material_lists.stock1_local AS stock1,
    material_lists.stock2_local AS stock2,
    material_lists.stock3_local AS stock3,
    material_lists.stock4_local AS stock4,
    material_lists.stock5_local AS stock5,
    material_lists.stock6_local AS stock6,
    material_lists.stock7_local AS stock7,
    bom.received_month1_local_qty as received_month1_qty,
    bom.received_month2_local_qty as received_month2_qty,
    bom.received_month3_local_qty as received_month3_qty,
    bom.received_month4_local_qty as received_month4_qty,
    bom.received_month5_local_qty as received_month5_qty,
    bom.received_month6_local_qty as received_month6_qty,
    bom.received_month7_local_qty as received_month7_qty,
    bom.received_month8_local_qty as received_month8_qty,
    bom.received_month9_local_qty as received_month9_qty,
    bom.received_month10_local_qty as received_month10_qty,
    bom.received_month11_local_qty as received_month11_qty,
    bom.received_month12_local_qty as received_month12_qty,
    bom.received_month1_date,
    bom.received_month2_date,
    bom.received_month3_date,
    bom.received_month4_date,
    bom.received_month5_date,
    bom.received_month6_date,
    bom.received_month7_date,
    bom.received_month8_date,
    bom.received_month9_date,
    bom.received_month10_date,
    bom.received_month11_date,
    bom.received_month12_date,
	bom.incoming_month1_local_qty as incoming_month1_qty,
    bom.incoming_month2_local_qty as incoming_month2_qty,
    bom.incoming_month3_local_qty as incoming_month3_qty,
    bom.incoming_month4_local_qty as incoming_month4_qty,
    bom.incoming_month5_local_qty as incoming_month5_qty,
    bom.incoming_month6_local_qty as incoming_month6_qty,
    bom.incoming_month7_local_qty as incoming_month7_qty,
    bom.incoming_month8_local_qty as incoming_month8_qty,
    bom.incoming_month9_local_qty as incoming_month9_qty,
    bom.incoming_month10_local_qty as incoming_month10_qty,
    bom.incoming_month11_local_qty as incoming_month11_qty,
    bom.incoming_month12_local_qty as incoming_month12_qty,
    bom.incoming_month1_date,
    bom.incoming_month2_date,
    bom.incoming_month3_date,
    bom.incoming_month4_date,
    bom.incoming_month5_date,
    bom.incoming_month6_date,
    bom.incoming_month7_date,
    bom.incoming_month8_date,
    bom.incoming_month9_date,
    bom.incoming_month10_date,
    bom.incoming_month11_date,
    bom.incoming_month12_date,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH1_local, 2)), '') as MONTH1_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH2_local, 2)), '') as MONTH2_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH3_local, 2)), '') as MONTH3_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH4_local, 2)), '') as MONTH4_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH5_local, 2)), '') as MONTH5_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH6_local, 2)), '') as MONTH6_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH7_local, 2)), '') as MONTH7_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH8_local, 2)), '') as MONTH8_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH9_local, 2)), '') as MONTH9_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH10_local, 2)), '') as MONTH10_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH11_local, 2)), '') as MONTH11_QTY,
    COALESCE(SUM(ROUND(bom.qty * bom.MONTH12_local, 2)), '') as MONTH12_QTY,
    COALESCE(SUM(ROUND(bom.qty * forecast.qty_local, 2)), '') as qty_local,
    COALESCE(SUM(ROUND(bom.qty * forecast.qty_boi, 2)), '') as qty_boi
FROM
    bom
INNER JOIN
    material_lists ON bom.Material = material_lists.MATERIAL
LEFT JOIN
    forecast ON 
    forecast.FG_PART = bom.FG_PART AND
    forecast.`month` = MONTH(CURRENT_DATE()) AND
    forecast.`year` = YEAR(CURRENT_DATE()) " . $where . "
GROUP BY
    bom.Material, bom.Vendor
ORDER BY
    material_lists.groups,material_lists.material
LIMIT 25;";

    // Check if transactionId is provided in the URL
    // $transactionId = isset($_GET['transactionId']) ? $_GET['transactionId'] : null;

    // if ($transactionId) {
    //     $sql .= " AND id = :transactionId";
    // }

    // Fetch data from the transaction table
    $stmt = $pdo->prepare($sql);
    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $stmt->bindParam(':material', $_GET['material'], PDO::PARAM_STR);
    }
    if (isset($_GET['groups']) && $_GET['groups'] !== '') {
        $stmt->bindParam(':groups', $_GET['groups'], PDO::PARAM_STR);
    }
    if (isset($_GET['vendor']) && $_GET['vendor'] !== '') {
        $stmt->bindParam(':vendor', $_GET['vendor'], PDO::PARAM_STR);
    }
    // Bind transactionId parameter if provided
    // if ($transactionId) {
    //     $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_INT);
    // }

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
    echo json_encode(['status' => 'error', 'message' => $sql]);
}
