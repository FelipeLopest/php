<?php
require_once(__DIR__ . '/funcao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados_usuario = [
        ':cpf' => preg_replace('/\D/', '', $_POST['cpf']),
        ':nome' => $_POST['nome'],
        ':data_nascimento' => $_POST['data_nascimento'],
        ':rua' => $_POST['rua'],
        ':bairro' => $_POST['bairro'],
        ':numero' => $_POST['numero'],
        ':cep' => preg_replace('/\D/', '', $_POST['cep']),
        ':telefone' => $_POST['telefone'],
        ':email' => $_POST['email']
    ];
    cadastrar_usuario($dados_usuario);
}
?>

<h2 class="mb-4">Cadastro de Usuário</h2>
<form method="post">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="14" placeholder="000.000.000-00">
        </div>
        <div class="col-md-4">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="col-md-4">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="rua" class="form-label">Rua</label>
            <input type="text" class="form-control" id="rua" name="rua" required>
        </div>
        <div class="col-md-4">
            <label for="bairro" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" required>
        </div>
        <div class="col-md-2">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
        <div class="col-md-2">
            <label for="cep" class="form-label">CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" required maxlength="9" placeholder="00000-000">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" required>
        </div>
        <div class="col-md-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>