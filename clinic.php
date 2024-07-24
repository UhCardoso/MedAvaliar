<?php
include_once("templates/header.php");


// verifica se o usuário está autenticado
include_once("models/Clinic.php");
require_once("dao/ClinicDAO.php");
require_once("dao/ReviewDAO.php");

// pegar o id do filme 
$id = filter_input(INPUT_GET, "id");
$clinic;

$clinicDao = new ClinicDAO($conn, $BASE_URL);
$reviewDao = new ReviewDAO($conn, $BASE_URL);

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

// checar se o filme é do usuário
$userOwnsclinic = false;

if (!empty($userData)) {
    if ($userData->id === $clinic->users_id) {
        $userOwnsclinic = true;
    }

    //regatar as reviews do filme
    $alreadReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
}

// resgatar reviews do filme
$clinicReviews = $reviewDao->getClinicsReview($id);


?>
<div id="main-container" class="class-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 clinic-container">
            <h1 class="page-title"><?= $clinic->name ?></h1>
            <p class="clinic-details">
                <span><?= $clinic->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i> <?= $clinic->rating; ?></span>
            </p>
            <iframe src="<?= $clinic->location ?>" width="560" height="315" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p class="location-text"><b>Endereço:</b> <?= $clinic->neighborhood ?>, <?= $clinic->city ?> - <?= $clinic->state ?>, </p>
            <p><?= $clinic->description ?></p>
        </div>
        <div class="col-md-4">
            <div class="clinic-image-container" style="background-image: url('<?= $BASE_URL ?>/img/clinics/<?= $clinic->image ?>')"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações:</h3>
            <!-- verifica se habilita a review para o usuário -->
            <?php if (!empty($userData) && !$userOwnsclinic && !$alreadReviewed) : ?>
                <div class="col-md-12" id="review-form-container">
                    <h4>Envie sua avaliação</h4>
                    <p class="page-description">Preencha o formulário com as notas e comentário sobre a clínica</p>
                    <form action="<?= $BASE_URL ?>/review_process.php" id="review-form" method="post">
                        <input type="hidden" name="type" value="create" />
                        <input type="hidden" name="clinics_id" value="<?= $clinic->id ?>">
                        <div class="form-group">
                            <label for="customer_services">Atendimento:
                                <span class="info-icon" id="infoIcon">?</span>
                                <div id="infoText" class="info-text">
                                    Avalie como a equipe interage com você, incluindo simpatia, cortesia e disposição para ajudar.
                                </div>
                            </label>
                            <select name="customer_services" id="customer_services" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quality_services">Qualidade dos serviços:
                                <span class="info-icon" id="infoIcon">?</span>
                                <div id="infoText" class="info-text">
                                    Envolve aspectos como confiabilidade, eficiência, responsividade, segurança e empatia na entrega de um serviço que atenda sua expectativa.
                                </div>
                            </label>
                            <select name="quality_services" id="quality_services" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="facilities_equipment">Qualidade dos equipamentos:
                                <span class="info-icon" id="infoIcon">?</span>
                                <div id="infoText" class="info-text">
                                    Isso inclui a capacidade dos equipamentos de operar de maneira segura e eficaz, garantindo diagnósticos precisos.
                                </div>
                            </label>
                            <select name="facilities_equipment" id="facilities_equipment" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="waiting_time">Tempo de espera:
                                <span class="info-icon" id="infoIcon">?</span>
                                <div id="infoText" class="info-text">
                                    Tempo que você demorou para ser atendido, desde a chegada até o início do atendimento.
                                </div>
                            </label>
                            <select name="waiting_time" id="waiting_time" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cost_benefit">Custo benefício:
                                <span class="info-icon" id="infoIcon">?</span>
                                <div id="infoText" class="info-text">
                                    A relação entre o valor pago pelos serviços da clínica e a qualidade e eficácia desses serviços.
                                </div>
                            </label>
                            <select name="cost_benefit" id="cost_benefit" class="form-control">
                                <option value="">Selecione</option>
                                <option value="10">10</option>
                                <option value="9">9</option>
                                <option value="8">8</option>
                                <option value="7">7</option>
                                <option value="6">6</option>
                                <option value="5">5</option>
                                <option value="4">4</option>
                                <option value="3">3</option>
                                <option value="2">2</option>
                                <option value="1">1</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review">Seu comentário:</label>
                            <textarea name="review" id="review" rows="3" class="form-control" placeholder="Deixe mais detalhes sobre a sua avaliação a clínica..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="is_anonymous">Tornar sua avaliação anônima?</label>
                            <input id="nao" name="is_anonymous" type="radio" value="nao" checked />
                            <label for="nao">Não</label>
                            <input id="sim" name="is_anonymous" type="radio" value="sim" />
                            <label for="sim">Sim</label>
                        </div>
                        <input type="submit" class="btn card-btn" value="Enviar avaliação" />
                    </form>
                </div>
            <?php endif; ?>
            <!-- comentários -->
            <?php foreach ($clinicReviews as $review) : ?>
                <?php require("templates/user_review.php"); ?>
            <?php endforeach; ?>
            <?php if (count($clinicReviews) == 0) : ?>
                <p class="empty-list">Nenhum comentário</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var infoIcons = document.getElementsByClassName('info-icon');
        var infoTexts = document.getElementsByClassName('info-text');

        function showInfo(event) {
            var infoText = event.target.nextElementSibling; // Assuming info-text follows info-icon in the DOM

            var rect = event.target.getBoundingClientRect();

            infoText.style.display = 'block';
            infoText.style.top = rect.top + window.scrollY + 'px';
            infoText.style.left = rect.right + window.scrollX + 'px';
        }

        function hideInfo(event) {
            var infoText = event.target.nextElementSibling; // Assuming info-text follows info-icon in the DOM

            infoText.style.display = 'none';
        }

        Array.from(infoIcons).forEach(function(infoIcon) {
            infoIcon.addEventListener('mouseover', showInfo);
            infoIcon.addEventListener('mouseout', hideInfo);
            infoIcon.addEventListener('click', function(event) {
                var infoText = event.target.nextElementSibling; // Assuming info-text follows info-icon in the DOM

                if (infoText.style.display === 'block') {
                    hideInfo(event);
                } else {
                    showInfo(event);
                }
            });
        });

        document.addEventListener('click', function(event) {
            Array.from(infoTexts).forEach(function(infoText) {
                if (!infoText.previousElementSibling.contains(event.target) && infoText.style.display === 'block') {
                    hideInfo(event);
                }
            });
        });
    });
</script>

<?php
require_once("templates/footer.php");
?>