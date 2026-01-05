<?php
require "config.php";
require "auth.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // 🔹 GET pages
    case 'GET':
        $result = $conn->query("SELECT * FROM pages");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        break;

    // 🔹 CREATE page
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "INSERT INTO pages (title, content, slug) VALUES (?, ?, ?)"
        );
        $stmt->bind_param(
            "sss",
            $data['title'],
            $data['content'],
            $data['slug']
        );

        $stmt->execute();
        echo json_encode(["message" => "Page created"]);
        break;

    // 🔹 UPDATE page
    case 'PUT':
        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "UPDATE pages SET title=?, content=?, slug=? WHERE id=?"
        );
        $stmt->bind_param(
            "sssi",
            $data['title'],
            $data['content'],
            $data['slug'],
            $id
        );

        $stmt->execute();
        echo json_encode(["message" => "Page updated"]);
        break;

    // 🔹 DELETE page
    case 'DELETE':
        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM pages WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["message" => "Page deleted"]);
        break;

    default:
        http_response_code(405);
}
