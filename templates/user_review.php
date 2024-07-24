<?php
require_once("models/User.php");

$userModel = new User();

$fullName = $userModel->getFullName($review->user);

// checar se o filme tem imagme
if ($review->user->image == "" || $review->user->image == null) {
    $review->user->image = "user.png";
}
?>
<div class="col-md-12 review">
    <div class="row">
        <div class="col-md-1">
            <?php if ($review->is_anonymous) : ?>
                <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>/img/users/user.png')"></div>
            <?php else : ?>
                <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>/img/users/<?= $review->user->image; ?>')"></div>
            <?php endif; ?>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <?php if ($review->is_anonymous) : ?>
                    <a href="#">Anônimo</a>
                <?php elseif ($review->users_id == $userData->id) : ?>
                    <a href="<?= $BASE_URL ?>/profile.php?id=<?= $review->user->id ?>">Você</a>
                <?php else : ?>
                    <a href="<?= $BASE_URL ?>/profile.php?id=<?= $review->user->id ?>"><?= $fullName; ?></a>
                <?php endif ?>
            </h4>
            <p>Atendimento: <i class="fas fa-star"></i> <?= $review->customer_services; ?></p>
            <p>Qualidade de serviço: <i class="fas fa-star"></i> <?= $review->quality_services; ?></p>
            <p>Qualidade de equipamentos: <i class="fas fa-star"></i> <?= $review->facilities_equipment; ?></p>
            <p>Tempo de espera: <i class="fas fa-star"></i> <?= $review->waiting_time; ?></p>
            <p>Custo benefífcio: <i class="fas fa-star"></i> <?= $review->cost_benefit; ?></p>
        </div>
        <div class="col-md-12">
            <p class="comments-title">Comentário:</p>
            <p><?= $review->review; ?></p>
        </div>
        <hr />
    </div>
</div>