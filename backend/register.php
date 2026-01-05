<?php
require "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$password = $data['password'];
$role = $data['role'] ?? 'editor';

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $username, $hashedPassword, $role);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User registered"]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "User exists"]);
}
