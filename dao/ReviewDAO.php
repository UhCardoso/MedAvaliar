<?php
require_once("models/Review.php");
require_once("models/Message.php");

require_once("dao/UserDAO.php");

class ReviewDao implements ReviewDAOInterface
{
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url)
    {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildReview($data)
    {
        $reviewObject = new Review();

        $reviewObject->id = $data["id"];
        $reviewObject->customer_services = $data["customer_services"];
        $reviewObject->quality_services = $data["quality_services"];
        $reviewObject->facilities_equipment = $data["facilities_equipment"];
        $reviewObject->waiting_time = $data["waiting_time"];
        $reviewObject->cost_benefit = $data["cost_benefit"];
        $reviewObject->review = $data["review"];
        $reviewObject->users_id = $data["users_id"];
        $reviewObject->clinics_id = $data["clinics_id"];

        return $reviewObject;
    }

    public function create(Review $review)
    {
        $stmt = $this->conn->prepare("INSERT INTO reviews (
            customer_services, quality_services, facilities_equipment, waiting_time, cost_benefit, review, clinics_id, users_id
        ) VALUES (
            :customer_services, :quality_services, :facilities_equipment, :waiting_time, :cost_benefit, :review, :clinics_id, :users_id
        )");

        $stmt->bindParam(":customer_services", $review->customer_services);
        $stmt->bindParam(":quality_services", $review->quality_services);
        $stmt->bindParam(":facilities_equipment", $review->facilities_equipment);
        $stmt->bindParam(":waiting_time", $review->waiting_time);
        $stmt->bindParam(":cost_benefit", $review->cost_benefit);
        $stmt->bindParam(":review", $review->review);
        $stmt->bindParam(":clinics_id", $review->clinics_id);
        $stmt->bindParam(":users_id", $review->users_id);

        $stmt->execute();

        // mensagem de successo ao adicionar filme
        $this->message->setMessage("Avaliação adicionada com suceso!", "success", "/index.php");
    }

    public function getclinicsReview($id)
    {
        $reviews = [];

        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE clinics_id = :clinics_id");

        $stmt->bindParam(":clinics_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $reviewsData = $stmt->fetchAll();
            $userDao = new UserDAO($this->conn, $this->url);
            foreach ($reviewsData as $review) {
                $reviewObject = $this->buildReview($review);

                // chamar dados so usuário
                $user = $userDao->findById($reviewObject->users_id);

                $reviewObject->user = $user;

                $reviews[] = $reviewObject;
            }
        }

        return $reviews;
    }

    public function hasAlreadyReviewed($id, $userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE clinics_id = :clinics_id AND users_id = :users_id");

        $stmt->bindParam(":clinics_id", $id);
        $stmt->bindParam(":users_id", $userId);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getRatings($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE clinics_id = :clinics_id");

        $stmt->bindParam(":clinics_id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rating = 0;

            $reviews = $stmt->fetchAll();

            foreach ($reviews as $review) {
                $rating += $review["customer_services"];
                $rating += $review["quality_services"];
                $rating += $review["facilities_equipment"];
                $rating += $review["waiting_time"];
                $rating += $review["cost_benefit"];
            }

            $rating = ($rating / 5) / count($reviews);
        } else {
            $rating = "Não avaliado";
        }

        return $rating;
    }
}
