<?php
require_once(__DIR__ . '/funcao.php');

// Função para buscar todos os aluguéis

// Excluir aluguel
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $cx = conectar();
    $stmt = $cx->prepare("DELETE FROM emprestimo WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo '<p>Aluguel excluído com sucesso!</p>';
}

// Buscar dados para alteração
$aluguel_editar = null;
if (isset($_GET['alterar'])) {
    $id = (int)$_GET['alterar'];
    $cx = conectar();
    $stmt = $cx->prepare("SELECT * FROM emprestimo WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $aluguel_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualizar dados do aluguel
if (isset($_POST['id_alterar'])) {
    $cx = conectar();
    $sql = "UPDATE emprestimo SET 
                id_usuario = :id_usuario, 
                id_livro = :id_livro, 
                data_emprestimo = :data_emprestimo, 
                data_devolucao = :data_devolucao, 
                valor_aluguel = :valor_aluguel 
            WHERE id = :id";
    $stmt = $cx->prepare($sql);
    $stmt->execute([
        ':id_usuario'      => $_POST['id_usuario'],
        ':id_livro'        => $_POST['id_livro'],
        ':data_emprestimo' => $_POST['data_emprestimo'],
        ':data_devolucao'  => $_POST['data_devolucao'],
        ':valor_aluguel'   => $_POST['valor_aluguel'],
        ':id'              => $_POST['id_alterar']
    ]);
    echo '<p>Aluguel alterado com sucesso!</p>';
    $aluguel_editar = null;
}

if (isset($_POST['nome']) && $_POST['nome'] != '') {
    $alugueis = listar_alugueis_por_nome_usuario($_POST['nome']);
} else {
    $alugueis = listar_alugueis_por_nome_usuario();
}
?>

<h2>Lista de Aluguéis</h2>

<form method="POST" class="mb-3">
    <div class="input-group">
        <input type="text" name="nome" class="form-control" placeholder="Filtrar por id"
            value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Filtrar
        </button>
    </div>
</form>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID Usuário</th>
            <th>Nome Usuário</th>
            <th>ID Livro</th>
            <th>Data Empréstimo</th>
            <th>Data Devolução</th>
            <th>Valor Aluguel</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alugueis as $aluguel): ?>
            <tr>
                <td><?= $aluguel['id'] ?></td>
                <td><?= $aluguel['id_usuario'] ?></td>
                <td><?= $aluguel['nome_usuario'] ?></td>
                <td><?= $aluguel['id_livro'] ?></td>
                <td><?= $aluguel['data_emprestimo'] ?></td>
                <td><?= $aluguel['data_devolucao'] ?></td>
                <td><?= $aluguel['valor_aluguel'] ?></td>
                <td>
                    <a href="?pagina=verificar_aluguel&alterar=<?= $aluguel['id'] ?>">Alterar</a> |
                    <a href="?pagina=verificar_aluguel&excluir=<?= $aluguel['id'] ?>"
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($aluguel_editar): ?>
    <h3>Alterar Aluguel</h3>
    <form method="post">
        <input type="hidden" name="id_alterar" value="<?= $aluguel_editar['id'] ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_usuario" class="form-label">ID Usuário</label>
                <input type="text" class="form-control" id="id_usuario" name="id_usuario"
                    value="<?= $aluguel_editar['id_usuario'] ?>" required>
            </div>
            <div class="col-md-4">
                <label for="id_livro" class="form-label">ID Livro</label>
                <input type="text" class="form-control" id="id_livro" name="id_livro"
                    value="<?= $aluguel_editar['id_livro'] ?>" required>
            </div>
            <div class="col-md-4">
                <label for="data_emprestimo" class="form-label">Data Empréstimo</label>
                <input type="date" class="form-control" id="data_emprestimo" name="data_emprestimo"
                    value="<?= $aluguel_editar['data_emprestimo'] ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="data_devolucao" class="form-label">Data Devolução</label>
                <input type="date" class="form-control" id="data_devolucao" name="data_devolucao"
                    value="<?= $aluguel_editar['data_devolucao'] ?>" required>
            </div>
            <div class="col-md-4">
                <label for="valor_aluguel" class="form-label">Valor</label>
                <input type="text" class="form-control" id="valor_aluguel" name="valor_aluguel"
                    value="<?= $aluguel_editar['valor_aluguel'] ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
<?php endif; ?>