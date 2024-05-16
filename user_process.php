<?php
require_once("global.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

// resgata tipo do formulario
$type = filter_input(INPUT_POST, "type");

// atualiza usuário
if ($type === "update") {
    // resgata dados do usuario
    $userData = $userDao->verifyToken();

    //recebe dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    // criar o novo objeto de usuario
    $user = new User();

    //preencher dados do usuario
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    // upload da imagem
    if (isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];

        //checagem de tipo de imagem
        if (in_array($image["type"], $imageTypes)) {
            //checar se jpg
            if (in_array($image, $jpgArray)) {
                $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                // imagem é png
            } else {
                $imageFile = imagecreatefrompng($image["tmp_name"]);
            }

            $imageName = $user->imageGenerateName();

            imagejpeg($imageFile, './img/users/' . $imageName, 100);

            $userData->image = $imageName;
        } else {
            $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
        }
    }

    $userDao->update($userData);

    // atualizar senha do usuario
} elseif ($type === "changePassword") {
    //recebe dados do post
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    //resgata dados do usuario
    $userData = $userDao->verifyToken();
    $id = $userData->id;

    if ($password == $confirmPassword) {
        // criar o novo objeto de usuario
        $user = new User();

        $finalPassword = $user->generatePassword($password);

        $user->password = $finalPassword;
        $user->id = $id;

        $userDao->changePassword($user);
    } else {
        $message->setMessage("As senhas não são iguais!", "error", "back");
    }
} else {
    $message->setMessage("Informações inválidas!", "error", "/index.php");
}
