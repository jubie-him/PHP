<?php
namespace App\Controllers;

class DocumentController
{
    public static function upload(): void
    {
        if (!isset($_FILES['file'], $_POST['user_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $uploadDir = __DIR__ . '/../../data/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = basename($_FILES['file']['name']);
        $targetPath = $uploadDir . '/' . uniqid() . '_' . $filename;
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to save file']);
            return;
        }

        $pdo = \App\Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO documents (user_id, path) VALUES (:user_id, :path)');
        $stmt->execute([
            ':user_id' => $_POST['user_id'],
            ':path' => $targetPath,
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
        $pdo = \App\Database::getConnection();
        $stmt = $pdo->prepare('SELECT id, path FROM documents WHERE user_id = :user_id');
        $stmt->execute([':user_id' => $_GET['user_id']]);
        echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }
}
