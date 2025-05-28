<?php

require_once(__DIR__ . "/funcao.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dados_aluguel = [
        'id_usuario' => $_POST['id_usuario'],
        'id_livro' => $_POST['id_livro'],
        'data_emprestimo' => $_POST['data_emprestimo'],
        'data_devolucao' => $_POST['data_devolucao'],
        'valor_aluguel' => $_POST['valor_aluguel']
    ];
    cadastrar_aluguel($dados_aluguel);
}
?>

<h2 class="mb-4">Cadastro de Pessoa</h2>
<form method="post">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="cpf" class="form-label">id do usuario</label>
            <input type="text" class="form-control" id="cpf" name="id_usuario">
        </div>
        <div class="col-md-4">
            <label for="nome" class="form-label">id Livro</label>
            <input type="text" class="form-control" id="nome" name="id_livro">
        </div>
        <div class="col-md-4">
            <label for="sobrenome" class="form-label">Data de Emprestimo</label>
            <input type="date" class="form-control" id="sobrenome" name="data_emprestimo">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label for="data_nasc" class="form-label">Data de Devolução</label>
            <input type="date" class="form-control" id="data_nasc" name="data_devolucao">
        </div>
        <div class="col-md-4">
            <label for="telefone" class="form-label">Valor</label>
            <input type="tel" class="form-control" id="telefone" name="valor_aluguel">
        </div>

    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>