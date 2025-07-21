<?php
namespace App\Controllers;

use App\Database;

use PDO;
class ApplicationController
{
    public static function apply(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['user_id'], $data['job_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO applications (user_id, job_id, status) VALUES (:user_id, :job_id, :status)');
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':job_id' => $data['job_id'],
            ':status' => 'applied',
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
    }

    public static function list(): void
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query('SELECT * FROM applications');
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}
