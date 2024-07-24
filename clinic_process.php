<?php
require_once("global.php");
require_once("db.php");
require_once("models/Clinic.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/ClinicDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$clinicDao = new ClinicDAO($conn, $BASE_URL);

// resgata tipo do formulario
$type = filter_input(INPUT_POST, "type");

// resgata dados do usuario
$userData = $userDao->verifyToken();

// pega link do local
function getLocationSrcMap($iframe, $message)
{
    $html = $iframe;

    // Usa uma expressão regular para encontrar o link src
    preg_match('/src="(https:\/\/[^\"]+)"/', $html, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    } else {
        $message->setMessage("Não foi possível encontrar o link src da localização. Adicione um link de incorporação!", "error", "back");
    }
}

if ($type === "create") {
    // receber os dados dos inputs
    $name = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "description");
    $location = filter_input(INPUT_POST, "location");
    $category = filter_input(INPUT_POST, "category");
    $state = filter_input(INPUT_POST, "state");
    $city = filter_input(INPUT_POST, "city");
    $neighborhood = filter_input(INPUT_POST, "neighborhood");

    $clinic = new Clinic();

    //validação minima de dados
    if (!empty($name) && !empty($description) && !empty($category)) {
        $clinic->name = $name;
        $clinic->description = $description;
        $clinic->category = $category;
        $clinic->users_id = $userData->id;
        $clinic->city = $city;
        $clinic->state = $state;
        $clinic->neighborhood = $neighborhood;

        if (isset($location)) {
            $clinic->location = getLocationSrcMap($location, $message);
        }

        //upload de imagem do filme
        if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];
            // checando tipo da imagem
            if (in_array($image["type"], $imageTypes)) {
                // checa se imagem é jpeg
                if (in_array($image["type"], $jpgArray)) {
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                // gerando nome da imagem
                $imageName = $clinic->imageGenerateName();

                imagejpeg($imageFile, "./img/clinics/" . $imageName, 100);

                $clinic->image = $imageName;
            } else {
                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!!", "error", "back");
            }
        }
        $clinicDao->create($clinic);
    } else {
        $message->setMessage("Você precisa adicionar: nome, descrição e categoria", "error", "back");
    }
} else if ($type == "delete") {
    // recebe dados do form
    $id = filter_input(INPUT_POST, "id");
    $clinic = $clinicDao->findById($id);

    if ($clinic) {
        // verificar se o filme é do usuário
        if ($clinic->users_id === $userData->id) {

            $clinicDao->destroy($clinic->id);
        } else {
            $message->setMessage("Informações inválidas!", "error", "/index.php");
        }
    } else {
        $message->setMessage("Informações inválidas!", "error", "/index.php");
    }
} else if ($type === "update") {
    // receber os dados dos inputs
    $name = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "description");
    $location = filter_input(INPUT_POST, "location");
    $category = filter_input(INPUT_POST, "category");
    $id = filter_input(INPUT_POST, "id");
    $state = filter_input(INPUT_POST, "state");
    $city = filter_input(INPUT_POST, "city");
    $neighborhood = filter_input(INPUT_POST, "neighborhood");

    $clinicData = $clinicDao->findById($id);

    //verifica se encontrou filme
    if ($clinicData) {
        // verificar se o filme é do usuário
        if ($clinicData->users_id === $userData->id) {
            if (!empty($name) && !empty($description) && !empty($category)) {
                // edição do filme
                $clinicData->name = $name;
                $clinicData->description = $description;
                $clinicData->location = $location;
                $clinicData->category = $category;
                $clinicData->city = $city;
                $clinicData->state = $state;
                $clinicData->neighborhood = $neighborhood;
                $clinicData->id = $id;

                if (isset($location)) {
                    $clinicData->location = getLocationSrcMap($location, $message);
                }

                //upload de imagem do filme
                if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
                    $image = $_FILES["image"];
                    $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                    $jpgArray = ["image/jpeg", "image/jpg"];
                    // checando tipo da imagem
                    if (in_array($image["type"], $imageTypes)) {
                        // checa se imagem é jpeg
                        if (in_array($image["type"], $jpgArray)) {
                            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                        } else {
                            $imageFile = imagecreatefrompng($image["tmp_name"]);
                        }

                        // gerando nome da imagem
                        $imageName = $clinicData->imageGenerateName();

                        imagejpeg($imageFile, "./img/clinics/" . $imageName, 100);

                        $clinicData->image = $imageName;
                    } else {
                        $message->setMessage("Tipo inválido de imagem, insira png ou jpg!!", "error", "back");
                    }
                }

                $clinicDao->update($clinicData);
            } else {
                $message->setMessage("Você precisa adicionar: nome, descrição e categoria", "error", "back");
            }
        } else {
            $message->setMessage("Informações inválidas!", "error", "/index.php");
        }
    } else {
        $message->setMessage("Informações inválidas!", "error", "/index.php");
    }
} else {
    $message->setMessage("Informações inválidas!", "error", "/index.php");
}
