<?php
require_once("global.php");
require_once("db.php");
require_once("models/Clinic.php");
require_once("models/Review.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/ClinicDAO.php");
require_once("dao/ReviewDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$clinicDao = new ClinicDAO($conn, $BASE_URL);
$reviewDao = new ReviewDAO($conn, $BASE_URL);

// resgata dados do usuario
$userData = $userDao->verifyToken();

//recebendo o tipo do formulário
$type = filter_input(INPUT_POST, "type");

if ($type === "create") {
    // recebendo dados do post
    $customer_services = filter_input(INPUT_POST, "customer_services");
    $quality_services = filter_input(INPUT_POST, "quality_services");
    $facilities_equipment = filter_input(INPUT_POST, "facilities_equipment");
    $waiting_time = filter_input(INPUT_POST, "waiting_time");
    $cost_benefit = filter_input(INPUT_POST, "cost_benefit");
    $review = filter_input(INPUT_POST, "review");
    $clinics_id = filter_input(INPUT_POST, "clinics_id");
    $is_anonymous = filter_input(INPUT_POST, "is_anonymous");
    $users_id = $userData->id;

    $reviewObject = new Review();

    $clinicData = $clinicDao->findById($clinics_id);

    // validando se o filme existe
    if ($clinicData) {
        // verificar dados minimos
        if (!empty($customer_services) && !empty($quality_services) && !empty($facilities_equipment) && !empty($waiting_time) && !empty($cost_benefit) && !empty($review) && !empty($clinics_id)) {
            $reviewObject->customer_services = $customer_services;
            $reviewObject->quality_services = $quality_services;
            $reviewObject->facilities_equipment = $facilities_equipment;
            $reviewObject->waiting_time = $waiting_time;
            $reviewObject->cost_benefit = $cost_benefit;
            $reviewObject->review = $review;
            $reviewObject->clinics_id = $clinics_id;
            $is_anonymous == "sim" ? $reviewObject->is_anonymous = true : $reviewObject->is_anonymous = false;
            $reviewObject->users_id = $users_id;

            $reviewDao->create($reviewObject);
        } else {
            $message->setMessage("Você precisa inserir a nota e o comentário", "error", "back");
        }
    } else {
        $message->setMessage("Informações inválidas!", "error", "/index.php");
    }
} else {
    $message->setMessage("Informações inválidas!", "error", "/index.php");
}
