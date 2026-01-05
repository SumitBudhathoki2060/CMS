<?php
require "config.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$headers = getallheaders();

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit("Unauthorized");
}

$token = str_replace("Bearer ", "", $headers['Authorization']);

try {
    $user = JWT::decode($token, new Key($JWT_SECRET, 'HS256'));
} catch (Exception $e) {
    http_response_code(401);
    exit("Invalid token");
}
// Access granted, you can use $user->id and $user->role
echo json_encode(["user_id" => $user->id, "role" => $user->role]);
?>