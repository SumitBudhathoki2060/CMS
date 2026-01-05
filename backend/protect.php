<?php
require "config.php";

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit("No token");
}

$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    $decoded = JWT::decode($token, new Key($JWT_SECRET, 'HS256'));
    // access granted
    echo json_encode(["user_id" => $decoded->id, "role" => $decoded->role]);
} catch (Exception $e) {
    http_response_code(401);
    echo "Invalid token";
}
