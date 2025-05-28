<?php
require_once(__DIR__ . '/funcao.php');

// Função para buscar todos os usuários
function listar_usuarios()
{
    $cx = conectar();
    $sql = "SELECT * FROM usuario";
    $stmt = $cx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir usuário
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $cx = conectar();
    $stmt = $cx->prepare("DELETE FROM usuario WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo '<p>Usuário excluído com sucesso!</p>';
}

// Buscar dados para alteração
$usuario_editar = null;
if (isset($_GET['alterar'])) {
    $id = (int)$_GET['alterar'];
    $cx = conectar();
    $stmt = $cx->prepare("SELECT * FROM usuario WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $usuario_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualizar dados do usuário
if (isset($_POST['id_alterar'])) {
    $cx = conectar();
    $sql = "UPDATE usuario 
            SET cpf = :cpf, nome = :nome, data_nascimento = :data_nascimento, 
                rua = :rua, bairro = :bairro, numero = :numero, cep = :cep, 
                telefone = :telefone, email = :email 
            WHERE id = :id";
    $stmt = $cx->prepare($sql);
    $stmt->execute([
        ':cpf' => $_POST['cpf'],
        ':nome' => $_POST['nome'],
        ':data_nascimento' => $_POST['data_nascimento'],
        ':rua' => $_POST['rua'],
        ':bairro' => $_POST['bairro'],
        ':numero' => $_POST['numero'],
        ':cep' => $_POST['cep'],
        ':telefone' => $_POST['telefone'],
        ':email' => $_POST['email'],
        ':id' => $_POST['id_alterar']
    ]);
    echo '<p>Usuário alterado com sucesso!</p>';
    $usuario_editar = null;
}

// Buscar usuários por nome, se informado
if (isset($_POST['nome']) && $_POST['nome'] != '') {
    $usuarios = listar_usuarios_por_nome($_POST['nome']);
} else {
    $usuarios = listar_usuarios_por_nome();
}
?>

<!-- Formulário de filtro -->
<form method="POST" class="mb-3">
    <div class="input-group">
        <input type="text" name="nome" class="form-control" placeholder="Filtrar por nome"
            value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i> Filtrar
        </button>
    </div>
</form>

<!-- Tabela de usuários -->
<h2>Lista de Usuários</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>CPF</th>
            <th>Nome</th>
            <th>Data Nascimento</th>
            <th>Rua</th>
            <th>Bairro</th>
            <th>Número</th>
            <th>CEP</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario['id'] ?></td>
                <td><?= $usuario['cpf'] ?></td>
                <td><?= $usuario['nome'] ?></td>
                <td><?= $usuario['data_nascimento'] ?></td>
                <td><?= $usuario['rua'] ?></td>
                <td><?= $usuario['bairro'] ?></td>
                <td><?= $usuario['numero'] ?></td>
                <td><?= $usuario['cep'] ?></td>
                <td><?= $usuario['telefone'] ?></td>
                <td><?= $usuario['email'] ?></td>
                <td>
                    <a href="?pagina=verificar_usuario&alterar=<?= $usuario['id'] ?>">Alterar</a> |
                    <a href="?pagina=verificar_usuario&excluir=<?= $usuario['id'] ?>"
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulário de alteração -->
<?php if ($usuario_editar): ?>
    <h3>Alterar Usuário</h3>
    <form method="post">
        <input type="hidden" name="id_alterar" value="<?= $usuario_editar['id'] ?>">

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf"
                    value="<?= htmlspecialchars($usuario_editar['cpf']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome"
                    value="<?= htmlspecialchars($usuario_editar['nome']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento"
                    value="<?= htmlspecialchars($usuario_editar['data_nascimento']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" id="rua" name="rua"
                    value="<?= htmlspecialchars($usuario_editar['rua']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro"
                    value="<?= htmlspecialchars($usuario_editar['bairro']) ?>" required>
            </div>
            <div class="col-md-2">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero"
                    value="<?= htmlspecialchars($usuario_editar['numero']) ?>" required>
            </div>
            <div class="col-md-2">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep"
                    value="<?= htmlspecialchars($usuario_editar['cep']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone"
                    value="<?= htmlspecialchars($usuario_editar['telefone']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?= htmlspecialchars($usuario_editar['email']) ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
<?php endif; ?>