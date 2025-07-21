<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\UserController;
use App\Controllers\JobController;
use App\Controllers\ApplicationController;
use App\Controllers\DocumentController;
use App\Controllers\MessageController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Serve the HTML interface when visiting the root from a browser
if ($method === 'GET' && ($uri === '/' || $uri === '/index.html')) {
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    if (str_contains($accept, 'text/html') && file_exists(__DIR__ . '/index.html')) {
        header('Content-Type: text/html');
        readfile(__DIR__ . '/index.html');
        return;
    }
}

header('Content-Type: application/json');

switch (true) {
    case $method === 'GET' && $uri === '/':
        echo json_encode(['message' => 'Job Matching App API']);
        break;
    case $method === 'POST' && $uri === '/register':
        UserController::register();
        break;
    case $method === 'POST' && $uri === '/jobs':
        JobController::create();
        break;
    case $method === 'GET' && $uri === '/jobs':
        JobController::list();
        break;
    case $method === 'POST' && $uri === '/apply':
        ApplicationController::apply();
        break;
    case $method === 'GET' && $uri === '/applications':
        ApplicationController::list();
        break;
    case $method === 'POST' && $uri === '/documents':
        DocumentController::upload();
        break;
    case $method === 'GET' && $uri === '/documents':
        DocumentController::list();
        break;
    case $method === 'POST' && $uri === '/messages':
        MessageController::send();
        break;
    case $method === 'GET' && $uri === '/messages':
        MessageController::list();
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
}
