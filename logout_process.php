<?php
session_start();

// Perform logout actions, e.g., destroying the session
$_SESSION = array();
session_destroy();

// Send a JSON response indicating success
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
