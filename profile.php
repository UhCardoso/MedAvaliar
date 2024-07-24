<?php
include_once("templates/header.php");

// verifica se o usuário está autenticado
require_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/ClinicDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$clinicDao = new ClinicDAO($conn, $BASE_URL);

// receber id do usuário
$id = filter_input(INPUT_GET, "id");

if (empty($id)) {
    if (!empty($userData->id)) {
        $id = $userData->id;
    } else {
        $message->setMessage("Usuário não encontrado!", "error", "/index.php");
    }
} else {
    $userData = $userDao->findById($id);

    // se não encontrar usuário
    if (!$userData) {
        $message->setMessage("Usuário não encontrado!", "error", "/index.php");
    }
}

$fullname = $user->getFullName($userData);

if ($userData->image == "") {
    $userData->image = "user.png";
}

// files que o usuário adicionou

$userclinics = $clinicDao->getClinicsByUserId($id);
?>
<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?= $fullname ?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $BASE_URL ?>/img/users/<?= $userData->image ?>')"></div>
                <h3 class="about-title">Sobre:</h3>
                <?php if (!empty($userData->bio)) : ?>
                    <p class="profile-description"><?= $userData->bio ?></p>
                <?php else : ?>
                    <p class="profile-description">Usuário não possui bio...</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-clinics-container">
                <h3>Clínicas que adicionou:</h3>
                <div class="clinics-container">
                    <?php foreach ($userclinics as $clinic) : ?>
                        <?php require("templates/clinic_card.php"); ?>
                    <?php endforeach; ?>
                    <?php if (count($userclinics) === 0) : ?>
                        <p class="empty-list">O usuário ainda não enviou nenhuma clínica.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>