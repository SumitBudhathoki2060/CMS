<?php
require "config.php";
require "auth.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // 🔹 GET all posts
    case 'GET':
        $sql = "SELECT posts.*, users.username 
                FROM posts 
                JOIN users ON posts.author_id = users.id
                ORDER BY created_at DESC";

        $result = $conn->query($sql);
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        break;

    // 🔹 CREATE post
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)"
        );
        $stmt->bind_param(
            "ssi",
            $data['title'],
            $data['content'],
            $user->id
        );

        $stmt->execute();
        echo json_encode(["message" => "Post created"]);
        break;

    // 🔹 UPDATE post
    case 'PUT':
        $id = $_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare(
            "UPDATE posts SET title=?, content=? WHERE id=?"
        );
        $stmt->bind_param(
            "ssi",
            $data['title'],
            $data['content'],
            $id
        );

        $stmt->execute();
        echo json_encode(["message" => "Post updated"]);
        break;

    // 🔹 DELETE post
    case 'DELETE':
        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM posts WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["message" => "Post deleted"]);
        break;

    default:
        http_response_code(405);
}
