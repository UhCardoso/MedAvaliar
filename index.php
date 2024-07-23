<?php
include_once("templates/header.php");
require_once("dao/ClinicDAO.php");

//dao dos filmes 
$clinicDao = new ClinicDAO($conn, $BASE_URL);

$latestclinics = $clinicDao->getLatestClinics();

$latestClinics = $clinicDao->getLatestClinics();
$geralClinics = $clinicDao->getClinicsByCategory("Gerais");
$diagnosticClinics = $clinicDao->getClinicsByCategory("Diagnóstico e Imagem");
$rehabilitationClinics = $clinicDao->getClinicsByCategory("Reabilitação e Fisioterapia");
$occupationalMedicineClinics = $clinicDao->getClinicsByCategory("Medicina do Trabalho");
$aestheticsDermatologyClinics = $clinicDao->getClinicsByCategory("Estética e Dermatologia");
$preventiveMedicineClinics = $clinicDao->getClinicsByCategory("Medicina Preventiva");
$mentalHealthPsychology = $clinicDao->getClinicsByCategory("Saúde Mental e Psicologia");

$actionclinics = $clinicDao->getClinicsByCategory("Ação");
?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title">Últimas clínicas adicionadas</h2>
    <p class="section-description">Veja as avaliações das últimas clínicas adicionados no MedAvaliar</p>
    <div class="clinics-container">
        <?php foreach ($latestClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($latestClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas cadastrados</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Geral</h2>
    <p class="section-description">Veja as clínicas de atendimento médico generalista para uma ampla variedade de condições de saúde</p>
    <div class="clinics-container">
        <?php foreach ($geralClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($geralClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de atendimento Geral</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Diagnóstico e Imagem</h2>
    <p class="section-description">Veja as clpinicas que Realizam exames diagnósticos, como ultrassonografias, tomografias, ressonâncias magnéticas, e radiografias.</p>
    <div class="clinics-container">
        <?php foreach ($diagnosticClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($diagnosticClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Diagnóstico e Imagem</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Reabilitação e Fisioterapia</h2>
    <p class="section-description">Clínicas de tratamento e reabilitação de pacientes com problemas físicos devido a lesões ou condições crônicas</p>
    <div class="clinics-container">
        <?php foreach ($rehabilitationClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($rehabilitationClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Reabilitação e Fisioterapia</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Medicina do Trabalho</h2>
    <p class="section-description">Clínicas para avaliações e tratamentos relacionados à saúde ocupacional e segurança do trabalho</p>
    <div class="clinics-container">
        <?php foreach ($occupationalMedicineClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($occupationalMedicineClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Medicina do Trabalho</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Estética e Dermatologia</h2>
    <p class="section-description">Clínicas para tratamentos estéticos, como peelings, aplicação de botox, e procedimentos para melhoria da aparência da pele</p>
    <div class="clinics-container">
        <?php foreach ($aestheticsDermatologyClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($aestheticsDermatologyClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Estética e Dermatologia</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Medicina Preventiva</h2>
    <p class="section-description">Clínicas com foco na prevenção de doenças por meio de check-ups regulares e orientações sobre estilo de vida saudável</p>
    <div class="clinics-container">
        <?php foreach ($preventiveMedicineClinics as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($preventiveMedicineClinics) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Medicina Preventiva</p>
        <?php endif; ?>
    </div>
    <h2 class="section-title">Saúde Mental e Psicologia</h2>
    <p class="section-description">Clínicas para ratamento e apoio psicológico para diversos transtornos mentais e emocionais</p>
    <div class="clinics-container">
        <?php foreach ($mentalHealthPsychology as $clinic) : ?>
            <?php require("templates/clinic_card.php"); ?>
        <?php endforeach; ?>
        <?php if (count($mentalHealthPsychology) === 0) : ?>
            <p class="empty-list">ainda não há clínicas de Saúde Mental e Psicologia</p>
        <?php endif; ?>
    </div>
</div>
<?php
include_once("templates/footer.php");
?>