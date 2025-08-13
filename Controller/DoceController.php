<?php

namespace Controller;

use Model\Doce; // Importa a classe Doce do namespace Model

// Controlador responsável pelas operações relacionadas ao estoque de doces
class DoceController
{
    // Método para retornar todos os doces cadastrados
    public function getDoces()
    {
        $doce = new Doce(); // Instancia o model Doce
        $doces = $doce->getDoces(); // Recupera todos os doces do banco

        if ($doces) {
            // Retorna os doces com status 200 (OK)
            header("Content-Type: application/json", true, 200);
            echo json_encode($doces);
        } else {
            // Retorna mensagem de não encontrado com status 404
            header("Content-Type: application/json", true, 404);
            echo json_encode(["message" => "Nenhum doce encontrado"]);
        }
    }

    // Método para cadastrar um novo doce
    public function createDoce()
    {
        // Captura os dados da requisição JSON
        $data = json_decode(file_get_contents("php://input"));

        // Verifica se os campos obrigatórios foram fornecidos
        if (isset($data->nome) && isset($data->qtd) && isset($data->valor)) {
            $doce = new Doce();
            $doce->nome = $data->nome;
            $doce->qtd = $data->qtd;
            $doce->valor = $data->valor;

            // Tenta inserir o doce no banco de dados
            if ($doce->createDoce()) {
                header("Content-Type: application/json", true, 201);
                echo json_encode(["message" => "Doce adicionado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Erro ao adicionar doce"]);
            }
        } else {
            // Dados obrigatórios ausentes
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "Dados invalidos"]);
        }
    }

    // Método para atualizar os dados de um doce existente
    public function updateDoce()
    {
        // Captura os dados da requisição JSON
        $data = json_decode(file_get_contents("php://input"));

        // Verifica se o ID foi fornecido
        if (isset($data->id)) {
            $doce = new Doce();
            $doce->id = $data->id;
            $doce->nome = $data->nome;
            $doce->qtd = $data->qtd;
            $doce->valor = $data->valor;

            // Tenta atualizar o doce
            if ($doce->updateDoce()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Doce atualizado com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Erro ao atualizar doce"]);
            }
        } else {
            // ID não foi enviado
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID invalido"]);
        }
    }

    // Método para deletar um doce pelo ID
    public function deleteDoce()
    {
        // Recupera o ID via GET
        $id = $_GET["id"] ?? null;

        if ($id) {
            $doce = new Doce();
            $doce->id = $id;

            // Tenta excluir o doce
            if ($doce->deleteDoce()) {
                header("Content-Type: application/json", true, 200);
                echo json_encode(["message" => "Doce excluido com sucesso"]);
            } else {
                header("Content-Type: application/json", true, 500);
                echo json_encode(["message" => "Erro ao excluir doce"]);
            }
        } else {
            // ID ausente ou inválido
            header("Content-Type: application/json", true, 400);
            echo json_encode(["message" => "ID invalido"]);
        }
    }
}
