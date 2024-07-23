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
    <div class="offset-md-4 col-md-4 new-clinic-container">
        <h1 class="page-title">Cadastrar clínica</h1>
        <p class="page-description">Adicione sua crítica e compartilhe com os outros pacientes!</p>
        <form action="<?= $BASE_URL ?>/clinic_process.php" id="add-clinic-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="type" value="create" />
            <div class="form-group">
                <label for="name">Nome:</label>
                <input name="name" class="form-control" type="text" id="name" placeholder="Digite o nome da clínica" />
            </div>
            <div class="form-group">
                <label for="image">Imagem:</label><br>
                <input type="file" class="form-control-file" name="image" id="image" value="teste" />
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Selecione a categoria da clínica</option>
                    <option value="Gerais">Gerais</option>
                    <option value="Diagnóstico e Imagem">Diagnóstico e Imagem</option>
                    <option value="Reabilitação e Fisioterapia">Reabilitação e Fisioterapia</option>
                    <option value="Medicina do Trabalho">Medicina do Trabalho</option>
                    <option value="Estética e Dermatologia">Estética e Dermatologia</option>
                    <option value="Medicina Preventiva">Medicina Preventiva</option>
                    <option value="Saúde Mental e Psicologia">Saúde Mental e Psicologia</option>
                </select>
            </div>
            <div class="form-group">
                <label for="state">Estado:</label>
                <input type="text" class="form-control" name="state" id="state" placeholder="Insira o nome completo do Estado da clínica. Ex: (Minas Gerais)" />
            </div>
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Insira a cidade da clínica. Ex: (Belo Horizonte)" />
            </div>
            <div class="form-group">
                <label for="neighborhood">Bairro:</label>
                <input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="Insira o bairro da clínica" />
            </div>
            <div class="form-group">
                <label for="description">Descrição:</label>
                <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva detalhes sobre a clínica e o que ela oferece..."></textarea>
            </div>
            <div class="form-group">
                <label for="trailer">Localização:</label>
                <input type="text" class="form-control" name="location" id="location" placeholder="Insira o link de incorporação de mapa da clínica" />
            </div>
            <input type="submit" class="btn form card-btn" value="Cadastrar clínica">
        </form>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>