<?php
namespace App\Controllers;

use App\Database;
use PDO;

class MessageController
{
    public static function send(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['sender_id'], $data['receiver_id'], $data['content'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO messages (sender_id, receiver_id, content) VALUES (:sender_id, :receiver_id, :content)');
        $stmt->execute([
            ':sender_id' => $data['sender_id'],
            ':receiver_id' => $data['receiver_id'],
            ':content' => $data['content'],
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
    }

    public static function list(): void
    {
        if (!isset($_GET['user_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user_id']);
            return;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM messages WHERE sender_id = :id OR receiver_id = :id ORDER BY id DESC');
        $stmt->execute([':id' => $_GET['user_id']]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
