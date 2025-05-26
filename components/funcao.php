<?php
define('DB_HOST',     'localhost'); // Endereço do servidor MySQL
define('DB_USER',     'root');      // Usuário padrão do MySQL
define('DB_PASS',     '');          // Senha padrão do MySQL
define('DB_NAME',     'biblioteca');       // Nome do banco de dados
define('DB_CHARSET',  'utf8mb4');   // Charset do banco de dados

function conectar(): PDO
{
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET,
        DB_USER,
        DB_PASS
    );
    return $pdo;
}
function formatar_cpf($cpf): string
{
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

function cadastrar_usuario($dados): void
{
    $cx = conectar();
    $sql = " INSERT INTO usuario(cpf,nome,data_nascimento,rua,bairro,numero,cep,telefone,email) VALUES (:cpf , :nome , :data_nascimento, :rua , :bairro , :numero , :cep , :telefone , :email)";

    $stmt = $cx->prepare($sql);
    try {
        $stmt->execute($dados);
        if ($stmt->rowCount() > 0) {
            echo "cadastrado com sucesso";
        } else {
            echo "erro ao cadastrar";
        }
    } catch (PDOException $ex) {
        echo $ex;
    }
}
function cadastrar_aluguel($dados): void
{
    $cx = conectar();
    $sql = " INSERT INTO emprestimo(id_usuario,id_livro,data_emprestimo,data_devolucao,valor_aluguel) VALUES (:id_usuario , :id_livro , :data_emprestimo, :data_devolucao , :valor_aluguel)";

    $stmt = $cx->prepare($sql);
    try {
        $stmt->execute($dados);
        if ($stmt->rowCount() > 0) {
            echo "cadastrado com sucesso";
        } else {
            echo "erro ao cadastrar";
        }
    } catch (PDOException $ex) {
        echo $ex;
    }
}

function cadastrar_livros($dados): void
{
    $cx = conectar();
    $sql = "INSERT INTO livros(titulo,autor,genero,quantidade,imagem) VALUES (:titulo,:autor,:genero,:quantidade,:imagem)";
    $stmt = $cx->prepare($sql);
    try {
        $stmt->execute($dados);
        if ($stmt->rowCount() > 0) {
            echo "cadastrado com sucesso";
        } else {
            echo "falha ao cadastrar";
        }
    } catch (PDOException $ex) {
        echo $ex;
    }
}
