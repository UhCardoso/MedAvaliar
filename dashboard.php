<?php
include_once("templates/header.php");

include_once("models/User.php");
require_once("dao/UserDAO.php");
require_once("dao/ClinicDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$clinicDao = new ClinicDAO($conn, $BASE_URL);

// verifica se o usuário está autenticado
$userData = $userDao->verifyToken(true);

$userclinics = $clinicDao->getClinicsByUserId($userData->id);
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações das clínicas que você adicionou</p>
    <div class="col-md-12" id="add-clinic-container">
        <a href="<?= $BASE_URL ?>/newclinic.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicionar clínica
        </a>
    </div>
    <div class="col-md-12" id="clinics-dashboard">
        <table class="table">
            <thead>
                <th scope="#">#</th>
                <th scope="#">Nome</th>
                <th scope="#">Nota</th>
                <th scope="#" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach ($userclinics as $clinic) : ?>
                    <tr scope="row">
                        <td><?= $clinic->id ?></td>
                        <td><a href="<?= $BASE_URL ?>/clinic.php?id=<?= $clinic->id ?>" class="table-clinic-title"><?= $clinic->name ?></a></td>
                        <td><i class="fas fa-star"></i> <?= $clinic->rating ?></td>
                        <td class="actions-column">
                            <a href="<?= $BASE_URL ?>/editclinic.php?id=<?= $clinic->id ?>" class="edit-btn">
                                <i class="far fa-edit"></i> Editar
                            </a>
                            <form action="<?= $BASE_URL ?>/clinic_process.php" method="post">
                                <input type="hidden" name="type" value="delete" />
                                <input type="hidden" name="id" value="<?= $clinic->id ?>" />
                                <button type="submit" class="delete-btn">
                                    <i class="fas fa-times"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>