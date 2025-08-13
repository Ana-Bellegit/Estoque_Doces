<?php
require_once __DIR__ . '/vendor/autoload.php'; // Carrega o autoload para carregar as dependências

use Controller\DoceController; // Importa o controlador de doces

$doceController = new DoceController(); // Instancia o controlador de doces

$method = $_SERVER['REQUEST_METHOD']; // Obtém o método HTTP da requisição

$path = $_GET['path'] ?? ''; // Obtém o caminho da URL, default é uma string vazia

// Verifica se o caminho solicitado é "doces"
if ($path !== 'doces') {
    // Se não for, retorna erro 404 (rota não encontrada)
    http_response_code(404);
    echo json_encode(["message" => "Rota nao encontrada"]);
    exit; // Interrompe a execução
}

// Switch para lidar com os diferentes métodos HTTP
switch ($method) {
    case 'GET': // Para o método GET, retorna todos os doces
        $doceController->getDoces();
        break;

    case 'POST': // Para o método POST, cria um novo doce
        $doceController->createDoce();
        break;

    case 'PUT': // Para o método PUT, atualiza um doce existente
        $doceController->updateDoce();
        break;

    case 'DELETE': // Para o método DELETE, exclui um doce
        $doceController->deleteDoce();
        break;

    default:
        // Se o método não for GET, POST, PUT ou DELETE, retorna erro 405 (método não permitido)
        http_response_code(405);
        echo json_encode(["message" => "Metodo nao permitido"]);
        break;
}
