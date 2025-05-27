<?php
require_once(__DIR__ . '/funcao.php');

// Função para buscar todos os livros
function listar_livros()
{
    $cx = conectar();
    $sql = "SELECT * FROM livros";
    $stmt = $cx->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir livro
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $cx = conectar();
    $stmt = $cx->prepare("DELETE FROM livros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    echo '<p>Livro excluído com sucesso!</p>';
}

// Buscar dados para alteração
$livro_editar = null;
if (isset($_GET['alterar'])) {
    $id = (int)$_GET['alterar'];
    $cx = conectar();
    $stmt = $cx->prepare("SELECT * FROM livros WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $livro_editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Atualizar dados do livro
if (isset($_POST['id_alterar'])) {
    $cx = conectar();
    $novoCaminhoImagem = $_POST['imagem_atual'];
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = uniqid() . '_' . $_FILES['imagem']['name'];
        $novoCaminhoImagem = 'assets/' . $nomeArquivo;
        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../assets/' . $nomeArquivo);
    }
    $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, quantidade = :quantidade, imagem = :imagem WHERE id = :id";
    $stmt = $cx->prepare($sql);
    $stmt->execute([
        ':titulo' => $_POST['titulo'],
        ':autor' => $_POST['autor'],
        ':genero' => $_POST['genero'],
        ':quantidade' => $_POST['quantidade'],
        ':imagem' => $novoCaminhoImagem,
        ':id' => $_POST['id_alterar']
    ]);
    echo '<p>Livro alterado com sucesso!</p>';
    $livro_editar = null;
}

$livros = listar_livros();
?>

<h2>Lista de Livros</h2>
<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($livros as $livro): ?>
        <div style="width: 220px; border: 1px solid #ccc; border-radius: 8px; background:rgb(60, 16, 202); padding: 10px; box-shadow: 2px 2px 8px #0001; text-align: center;">
            <img src="<?= htmlspecialchars($livro['imagem']) ?>" alt="Capa do livro" style="width: 180px; height: 240px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
            <h4><?= htmlspecialchars($livro['titulo']) ?></h4>
            <p><strong>ID:</strong> <?= htmlspecialchars($livro['id']) ?></p>
            <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
            <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?></p>
            <p><strong>Quantidade:</strong> <?= htmlspecialchars($livro['quantidade']) ?></p>
            <div style="margin-top: 10px;">
                <a href="?pagina=verificar_livros&alterar=<?= $livro['id'] ?>">Alterar</a> |
                <a href="?pagina=verificar_livros&excluir=<?= $livro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($livro_editar): ?>
    <h3>Alterar Livro</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_alterar" value="<?= $livro_editar['id'] ?>">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($livro_editar['titulo']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" value="<?= htmlspecialchars($livro_editar['autor']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label">Gênero</label>
                <input type="text" class="form-control" id="genero" name="genero" value="<?= htmlspecialchars($livro_editar['genero']) ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="quantidade" class="form-label">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" value="<?= htmlspecialchars($livro_editar['quantidade']) ?>" min="1" required>
            </div>
            <div class="col-md-4">
                <label for="imagem" class="form-label">Nova Imagem (opcional)</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($livro_editar['imagem']) ?>">
                <small>Se não enviar, a imagem atual será mantida.</small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
<?php endif; ?>