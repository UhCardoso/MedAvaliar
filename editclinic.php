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
                        <label for="name">Título:</label>
                        <input name="name" class="form-control" type="text" id="name" placeholder="Digite o nome da clínica" value="<?= $clinic->name; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label><br>
                        <input type="file" class="form-control-file" name="image" id="image" value="teste" />
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione a categoria da clínica</option>
                            <option value="Gerais <?= $clinic->category === "Gerais" ? "selected" : "" ?>">Gerais</option>
                            <option value="Diagnóstico e Imagem <?= $clinic->category === "Diagnóstico e Imagem" ? "selected" : "" ?>">Diagnóstico e Imagem</option>
                            <option value="Reabilitação e Fisioterapia <?= $clinic->category === "Reabilitação e Fisioterapia" ? "selected" : "" ?>">Reabilitação e Fisioterapia</option>
                            <option value="Medicina do Trabalho <?= $clinic->category === "Medicina do Trabalho" ? "selected" : "" ?>">Medicina do Trabalho</option>
                            <option value="Estética e Dermatologia <?= $clinic->category === "Estética e Dermatologia" ? "selected" : "" ?>">Estética e Dermatologia</option>
                            <option value="Medicina Preventiva <?= $clinic->category === "Medicina Preventiva" ? "selected" : "" ?>">Medicina Preventiva</option>
                            <option value="Saúde Mental e Psicologia <?= $clinic->category === "Saúde Mental e Psicologia" ? "selected" : "" ?>">Saúde Mental e Psicologia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="state">Estado:</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="Insira o nome completo do Estado da clínica. Ex: (Minas Gerais)" value="<?= $clinic->state; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="city">Cidade:</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Insira a cidade da clínica. Ex: (Belo Horizonte)" value="<?= $clinic->city; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="neighborhood">Bairro:</label>
                        <input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="Insira o bairro da clínica" value="<?= $clinic->neighborhood; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="location">Localização:</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Insira o link de incorporação de mapa da clínica" value='<iframe src="<?= $clinic->location ?>" width="560" height="315" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>' />
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva detalhes sobre a clínica e o que ela oferece..."><?= $clinic->description; ?></textarea>
                    </div>
                    <input type="submit" class="btn form card-btn" value="Salvar alterações">
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