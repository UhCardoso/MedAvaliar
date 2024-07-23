<?php
include_once("templates/header.php");
require_once("dao/ClinicDAO.php");

//dao dos filmes 
$clinicDao = new ClinicDAO($conn, $BASE_URL);

// resgata busca do usuário
$q = filter_input(INPUT_GET, "q");

$clinics = $clinicDao->search($q);

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title" id="search-title">Você está buscando por: <span id="search-result"><?= $q ?></span></h2>
    <p class="section-description">Clínicas encontradas com base na sua pesquisa.</p>
    <div class="clinics-container">
        <?php foreach ($clinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($clinics) === 0) : ?>
            <p class="empty-list">Nenhuma clínica encontrada... <a class="back-link" href="<?= $BASE_URL ?>">Voltar</a></p>
        <?php endif; ?>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>