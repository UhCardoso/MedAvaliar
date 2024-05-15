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
    // atualizar senha do usuario
} elseif ($type === "changepassword") {
} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}
