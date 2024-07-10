<?php
require_once("global.php");
require_once("db.php");
require_once("models/Movie.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

// resgata tipo do formulario
$type = filter_input(INPUT_POST, "type");

// resgata dados do usuario
$userData = $userDao->verifyToken();

if ($type === "create") {
    // receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST, "length");

    $movie = new Movie();

    //validação minima de dados
    if (!empty($title) && !empty($description) && !empty($category)) {
        $movie->title = $title;
        $movie->description = $description;
        $movie->trailer = $trailer;
        $movie->category = $category;
        $movie->length = $length;
        $movie->users_id = $userData->id;

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
                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                $movie->image = $imageName;
            } else {
                $message->setMessage("Tipo inválido de imagem, insira png ou jpg!!", "error", "back");
            }
        }
        $movieDao->create($movie);
    } else {
        $message->setMessage("Você precisa adicionar: título, descrição e categoria", "error", "back");
    }
} else if ($type == "delete") {
    // recebe dados do form
    $id = filter_input(INPUT_POST, "id");
    $movie = $movieDao->findById($id);

    if ($movie) {
        // verificar se o filme é do usuário
        if ($movie->users_id === $userData->id) {

            $movieDao->destroy($movie->id);
        } else {
            $message->setMessage("Informações inválidas!", "error", "/index.php");
        }
    } else {
        $message->setMessage("Informações inválidas!", "error", "/index.php");
    }
} else if ($type === "update") {
    // receber os dados dos inputs
    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST, "length");
    $id = filter_input(INPUT_POST, "id");

    $movieData = $movieDao->findById($id);

    //verifica se encontrou filme
    if ($movieData) {
        // verificar se o filme é do usuário
        if ($movieData->users_id === $userData->id) {
            if (!empty($title) && !empty($description) && !empty($category)) {
                // edição do filme
                $movieData->title = $title;
                $movieData->description = $description;
                $movieData->trailer = $trailer;
                $movieData->category = $category;
                $movieData->$length = $length;

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
                        $imageName = $movieData->imageGenerateName();

                        imagejpeg($imageFile, "./img/movies/" . $imageName, 100);

                        $movieData->image = $imageName;
                    } else {
                        $message->setMessage("Tipo inválido de imagem, insira png ou jpg!!", "error", "back");
                    }
                }

                $movieDao->update($movieData);
            } else {
                $message->setMessage("Você precisa adicionar: título, descrição e categoria", "error", "back");
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
