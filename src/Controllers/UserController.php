<?php
namespace App\Controllers;

use App\Database;

class UserController
{
    public static function register(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['name'], $data['email'], $data['role'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('INSERT INTO users (name, email, role) VALUES (:name, :email, :role)');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':role' => $data['role'],
        ]);
        echo json_encode(['id' => $pdo->lastInsertId()]);
    }
}
