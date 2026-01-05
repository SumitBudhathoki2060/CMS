<?php
require "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$password = $data['password'];

$stmt = $conn->prepare(
    "SELECT id, password, role FROM users WHERE username = ?"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {

        $payload = [
            "id" => $user['id'],
            "role" => $user['role'],
            "iat" => time(),
            "exp" => time() + (60 * 60) // 1 hour
        ];

        $jwt = JWT::encode($payload, $JWT_SECRET, 'HS256');

        echo json_encode([
            "success" => true,
            "token" => $jwt
        ]);
        exit;
    }
}

http_response_code(401);
echo json_encode(["success" => false, "message" => "Invalid credentials"]);
