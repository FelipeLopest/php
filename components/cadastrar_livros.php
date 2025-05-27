<?php

require_once(__DIR__ . '/funcao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caminhoImagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $nomeArquivo = uniqid() . '_' . $_FILES['imagem']['name'];
        $caminhoImagem = 'assets/' . $nomeArquivo;
        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../assets/' . $nomeArquivo);
    }

    $dados_livro = [
        ':titulo' => $_POST['titulo'],
        ':autor' => $_POST['autor'],
        ':genero' => $_POST['genero'],
        ':quantidade' => $_POST['quantidade'],
        ':imagem' => $caminhoImagem
    ];

    cadastrar_livros($dados_livro);
}
?>

<h2 class="mb-4">Cadastro de Livro</h2>
<form method="post" enctype="multipart/form-data">
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="col-md-4">
            <label for="autor" class="form-label">Autor</label>
            <input type="text" class="form-control" id="autor" name="autor" required>
        </div>
        <div class="col-md-4">
            <label for="genero" class="form-label">Gênero</label>
            <input type="text" class="form-control" id="genero" name="genero" required>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
        </div>
        <div class="col-md-4">
            <label for="imagem" class="form-label">Imagem da Capa</label>
            <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>