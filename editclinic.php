<?php
include_once("templates/header.php");

// verifica se o usuário está autenticado
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/ClinicDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$clinicDao = new ClinicDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, "id");

if (empty($id)) {
    $message->setMessage("O filme não foi encontrado!", "error", "/index.php");
} else {
    $clinic = $clinicDao->findById($id);

    // verifica se o filme existe
    if (!$clinic) {
        $message->setMessage("O filme não foi encontrado!", "error", "/index.php");
    }
}

//checar se o filme tem imagem
if ($clinic->image == "" || $clinic->image == null) {
    $clinic->image = "clinic_cover.jpg";
}
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 offset-md-1">
                <h1><?= $clinic->name ?></h1>
                <p class="page-description">Altere os dados da clínica no formulário abaixo</p>
                <form id="edit-clinic-form" method="post" action="<?= $BASE_URL ?>/clinic_process.php" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update" />
                    <input type="hidden" name="id" value="<?= $clinic->id; ?>" />
                    <div class="form-group">
                        <label for="title">Título:</label>
                        <input name="title" class="form-control" type="text" id="title" placeholder="Digite um título para o seu filme" value="<?= $clinic->name; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label><br>
                        <input type="file" class="form-control-file" name="image" id="image" value="teste" />
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione a categoria da clínica</option>
                            <option value="Gerais <?= $clinic->category === "Gerais" ? "selected" : "" ?>">Ação</option>
                            <option value="Diagnóstico e Imagem <?= $clinic->category === "Diagnóstico e Imagem" ? "selected" : "" ?>">Drama</option>
                            <option value="Reabilitação e Fisioterapia <?= $clinic->category === "Reabilitação e Fisioterapia" ? "selected" : "" ?>">Comédia</option>
                            <option value="Medicina do Trabalho <?= $clinic->category === "Medicina do Trabalho" ? "selected" : "" ?>">Fantasia / Ficção</option>
                            <option value="Estética e Dermatologia <?= $clinic->category === "Estética e Dermatologia" ? "selected" : "" ?>">Romance</option>
                            <option value="Medicina Preventiva <?= $clinic->category === "Medicina Preventiva" ? "selected" : "" ?>">Romance</option>
                            <option value="Saúde Mental e Psicologia <?= $clinic->category === "Saúde Mental e Psicologia" ? "selected" : "" ?>">Romance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="location">Localização:</label>
                        <input type="url" class="form-control" name="location" id="location" placeholder="Insira o link do local da clinica do Google Maps" value="<?= $clinic->location; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva detalhes sobre a clínica e o que ela oferece..."><?= $clinic->description; ?></textarea>
                    </div>
                    <input type="submit" class="btn form card-btn" value="Editar filme">
                </form>
            </div>
            <div class="col-md-3">
                <div class="clinic-image-container" style="background-image: url(<?= $BASE_URL ?>/img/clinics/<?= $clinic->image ?>);"></div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>