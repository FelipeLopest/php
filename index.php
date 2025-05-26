<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <header>BIBLIOTECA</header>

    <div class="painel-lateral">
        <nav class="navegacao-lateral">
            <ul>
                <li class="menu"><a href="?pagina=cadastrar_aluguel" class="menus">Cadastrar Aluguel </a></li>
                <li class="menu"><a href="?pagina=cadastrar_livros" class="menus">Cadastrar Livros </a></li>
                <li class="menu"><a href="?pagina=cadastrar_usuario" class="menus">Cadastrar Usuários</a></li>
                <li class="menu"><a href="?pagina=verificar-alugueis" class="menus">Verificar Aluguéis</a></li>
                <li class="menu"><a href="" class="menus">Verificar Livros</a></li>
                <li class="menu"><a href="" class="menus">Verificar Usuários</a></li>
            </ul>

        </nav>
        <img class="img-menu" src="assets/livros.webp" alt="Imagem de livros">
    </div>

    <div class="conteudo">
        <?php
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            $caminho = __DIR__ . '/components/' . $pagina . '.php';
            if (file_exists($caminho)) {
                require_once($caminho);
            }
        }
        ?>
    </div>
</body>

</html>