<?php
namespace App\Controllers;

use App\Database;

use PDO;
class JobController
{
    public static function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['title'], $data['description'], $data['requiredSkills'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO jobs (title, description, requiredSkills) VALUES (:title, :description, :requiredSkills)');
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':requiredSkills' => $data['requiredSkills'],
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
    }

    public static function list(): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM jobs');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
