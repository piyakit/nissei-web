<?php
// Your modified PHP code for getData.php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Build the SQL query based on filters
    $sql = "SELECT
    material_lists.MATERIAL as material,
    material_lists.QTY as qty,
    material_lists.UNIT as unit,
    material_lists.FG_PART as fg_part,
    transaction.qty * material_lists.QTY as usage_all
FROM
    transaction
INNER JOIN
    material_lists
ON
    transaction.material_name = material_lists.MATERIAL
WHERE 1 ORDER BY material_lists.MATERIAL;
";

    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $sql .= " AND material_lists.MATERIAL LIKE :material";
    }

    // Fetch data from the joined tables
    $stmt = $pdo->prepare($sql);

    // Bind parameters if they are set
    if (isset($_GET['material']) && $_GET['material'] !== '') {
        $materialParam = '%' . $_GET['material'] . '%';
        $stmt->bindParam(':material', $materialParam, PDO::PARAM_STR);
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
