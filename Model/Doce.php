<?php

namespace Model;

use PDO;
use Model\Connection; // Importa a classe de conexão com o banco de dados

// Classe que representa o modelo de "Doce" no banco de dados
class Doce
{
    private $conn; // A conexão com o banco de dados

    public $id;    // ID do doce
    public $nome;  // Nome do doce
    public $qtd;   // Quantidade disponível
    public $valor; // Valor do doce

    // Construtor que estabelece a conexão com o banco de dados
    public function __construct()
    {
        $this->conn = Connection::getConnection(); // Obtém a conexão com o banco
    }

    // Método para obter todos os doces cadastrados
    public function getDoces()
    {
        $sql = "SELECT * FROM doces"; // Consulta SQL para selecionar todos os doces
        $stmt = $this->conn->prepare($sql); // Prepara a consulta
        $stmt->execute(); // Executa a consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os doces como um array associativo
    }

    // Método para adicionar um novo doce ao estoque
    public function createDoce()
    {
        $sql = "INSERT INTO doces (nome, qtd, valor) VALUES (:nome, :qtd, :valor)"; // SQL de inserção
        $stmt = $this->conn->prepare($sql); // Prepara a consulta

        // Faz o bind dos parâmetros com as propriedades do objeto
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":qtd", $this->qtd, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor);

        return $stmt->execute(); // Executa a inserção e retorna o resultado (sucesso ou falha)
    }

    // Método para atualizar os dados de um doce específico
    public function updateDoce()
    {
        $sql = "UPDATE doces SET nome = :nome, qtd = :qtd, valor = :valor WHERE id = :id"; // SQL de atualização
        $stmt = $this->conn->prepare($sql); // Prepara a consulta

        // Faz o bind dos parâmetros com as propriedades do objeto
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":qtd", $this->qtd, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor);

        return $stmt->execute(); // Executa a atualização e retorna o resultado
    }

    // Método para excluir um doce do estoque
    public function deleteDoce()
    {
        $sql = "DELETE FROM doces WHERE id = :id"; // SQL de exclusão
        $stmt = $this->conn->prepare($sql); // Prepara a consulta

        // Faz o bind do parâmetro de ID
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute(); // Executa a exclusão e retorna o resultado
    }
}
