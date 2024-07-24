<?php
require_once("models/clinic.php");
require_once("models/Message.php");

// review dao
require_once("dao/ReviewDAO.php");

class ClinicDAO implements ClinicDAOInterface
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

    public function buildClinic($data)
    {
        $clinic = new Clinic();

        $clinic->id = $data["id"];
        $clinic->name = $data["name"];
        $clinic->description = $data["description"];
        $clinic->image = $data["image"];
        $clinic->location = $data["location"];
        $clinic->category = $data["category"];
        $clinic->state = $data["state"];
        $clinic->city = $data["city"];
        $clinic->neighborhood = $data["neighborhood"];
        $clinic->users_id = $data["users_id"];

        //recebe as ratings do filme
        $reviewDao = new ReviewDao($this->conn, $this->url);
        $rating = $reviewDao->getRatings($clinic->id);

        $clinic->rating = $rating;

        return $clinic;
    }

    public function findAll()
    {
    }

    public function getLatestClinics()
    {
        $clinics = [];

        $stmt = $this->conn->query("SELECT * FROM clinics ORDER BY id DESC  LIMIT 5");
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $clinicsArray = $stmt->fetchAll();

            foreach ($clinicsArray as $clinic) {
                $clinics[] = $this->buildClinic($clinic);
            }
        }

        return $clinics;
    }

    public function getClinicsByCategory($category)
    {
        $clinics = [];

        $stmt = $this->conn->prepare("SELECT * FROM clinics
                                    WHERE category = :category
                                    ORDER BY id DESC");

        $stmt->bindParam(":category", $category);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $clinicsArray = $stmt->fetchAll();

            foreach ($clinicsArray as $clinic) {
                $clinics[] = $this->buildClinic($clinic);
            }
        }

        return $clinics;
    }

    public function getClinicsByUserId($id)
    {
        $clinics = [];

        $stmt = $this->conn->prepare("SELECT * FROM clinics
                                    WHERE users_id = :users_id");

        $stmt->bindParam(":users_id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $clinicsArray = $stmt->fetchAll();

            foreach ($clinicsArray as $clinic) {
                $clinics[] = $this->buildClinic($clinic);
            }
        }

        return $clinics;
    }

    public function findById($id)
    {
        $clinic = [];

        $stmt = $this->conn->prepare("SELECT * FROM clinics
                                    WHERE id = :id");

        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $clinicData = $stmt->fetch();
            $clinic = $this->buildClinic($clinicData);
            return $clinic;
        } else {
            return false;
        }
    }

    public function search($search)
    {
        $clinics = [];

        $stmt = $this->conn->prepare(
            "SELECT * FROM clinics
             WHERE name LIKE :searchName 
             OR state LIKE :searchState 
             OR city LIKE :searchCity 
             OR neighborhood LIKE :searchNeighborhood"
        );

        $searchTerm = '%' . $search . '%';
        $stmt->bindParam(':searchName', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':searchState', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':searchCity', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':searchNeighborhood', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $clinicsArray = $stmt->fetchAll();

            foreach ($clinicsArray as $clinic) {
                $clinics[] = $this->buildClinic($clinic);
            }
        }

        return $clinics;
    }

    public function create(clinic $clinic)
    {
        $stmt = $this->conn->prepare("INSERT INTO clinics (
            name, description, image, location, category, state, city, neighborhood, users_id
        ) VALUES (
            :name, :description, :image, :location, :category, :state, :city, :neighborhood, :users_id
        )");

        $stmt->bindParam(":name", $clinic->name);
        $stmt->bindParam(":description", $clinic->description);
        $stmt->bindParam(":image", $clinic->image);
        $stmt->bindParam(":location", $clinic->location);
        $stmt->bindParam(":category", $clinic->category);
        $stmt->bindParam(":state", $clinic->state);
        $stmt->bindParam(":city", $clinic->city);
        $stmt->bindParam(":neighborhood", $clinic->neighborhood);
        $stmt->bindParam(":users_id", $clinic->users_id);

        $stmt->execute();

        // mensagem de successo ao adicionar filme
        $this->message->setMessage("Clínica adicionada com suceso!", "success", "/index.php");
    }

    public function update(Clinic $clinic)
    {
        $stmt = $this->conn->prepare("UPDATE clinics SET
            name = :name,
            description = :description,
            image = :image,
            category = :category,
            state = :state,
            city = :city,
            neighborhood = :neighborhood,
            location = :location
            WHERE id = :id
        ");

        $stmt->bindParam(":name", $clinic->name);
        $stmt->bindParam(":description", $clinic->description);
        $stmt->bindParam(":image", $clinic->image);
        $stmt->bindParam(":category", $clinic->category);
        $stmt->bindParam(":state", $clinic->state);
        $stmt->bindParam(":city", $clinic->city);
        $stmt->bindParam(":neighborhood", $clinic->neighborhood);
        $stmt->bindParam(":location", $clinic->location);
        $stmt->bindParam(":id", $clinic->id);

        $stmt->execute();
        // mensagem de successo ao atualizar filme
        $this->message->setMessage("Clínica atualizada com suceso!", "success", "/dashboard.php");
    }

    public function destroy($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM clinics WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // mensagem de successo ao deletar filme
        $this->message->setMessage("Clínica removida com suceso!", "success", "/index.php");
    }
}
