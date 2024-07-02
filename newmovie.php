<?php
include_once("templates/header.php");

// verifica se o usuário está autenticado
include_once("models/User.php");
require_once("dao/UserDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

?>
<div id="main-container" class="container-fluid">
    <div class="offset-md-4 col-md-4 new-movie-container">
        <h1 class="page-title">Adicionar filme</h1>
        <p class="page-description">Adicione sua crítica e compartilhe com o mundo!</p>
        <form action="<?= $BASE_URL ?>/movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create" />
            <div class="form-group">
                <label for="title">Título:</label>
                <input name="title" class="form-control" type="text" id="title" placeholder="Digite um título para o seu filme" />
            </div>
            <div class="form-group">
                <label for="image">Imagem:</label><br>
                <input type="file" class="form-control-file" name="image" id="image" value="teste" />
            </div>
            <div class="form-group">
                <label for="length">Duração:</label>
                <input type="text" name="length" class="form-control" name="length" id="length" placeholder="Digite a duração do filme" />
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione</option>
                    <option value="Ação">Ação</option>
                    <option value="Drama">Drama</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Fantasia / Ficção">Fantasia / Ficção</option>
                    <option value="Romance">Romance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="trailer">Trailer:</label>
                <input type="url" class="form-control" name="trailer" id="trailer" placeholder="Insira o link do trailer" />
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme..."></textarea>
            </div>
            <input type="submit" class="btn form card-btn" value="Adicionar filme">
        </form>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>