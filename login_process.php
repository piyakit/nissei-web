<?php
// login_process.php

// Get the submitted username and password from the form
$userInput = isset($_POST['username']) ? $_POST['username'] : '';
$passInput = isset($_POST['password']) ? $_POST['password'] : '';

// Replace these values with your actual authentication logic (e.g., checking against a database)
// $pdo = new PDO("mysql:host=localhost;dbname=factory", "root", "");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
require_once('./conn.php');
$sql = "SELECT * FROM users WHERE username = '$userInput' AND password_hash = '$passInput'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data_json = json_encode($data);
// var_dump(json_decode($data_json));
// $check = mysqli_fetch_array($result);

$validUsername = 'admin';
$validPassword = 'admin';

if (count($data) > 0) {
    // echo $data_json[0];
    // Start the session (if not already started)
    session_start();
    $username = json_decode($data_json);
    var_dump($username[0]->username);

    // Set a session variable to indicate that the user is logged in
    $_SESSION['user_id'] = true;
    $_SESSION['username'] = $username[0]->username;
    // Redirect the user to the index.php page
    header("Location: forcast.php");
    exit(); // Make sure to exit after sending the header to prevent further execution
} else {
    // Redirect the user back to the login page if authentication fails
    header("Location: login.php");
    exit();
}
