<?php
require_once("global.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

// Verificar o tipo do formulário
$type = filter_input(INPUT_POST, "type");

// verificação do tipo de formulario
if ($type === "register") {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword");

    // verificacao de dados minimos
    if ($name && $lastname && $email && $password) {
        // Verificar se as senhas batem
        if ($password === $confirmPassword) {
            // Verificar se o email já está cadastrado no sistema
            if ($userDao->findByEmail($email) === false) {
                $user = new User();

                // Criação de token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {
                // enviar mensagem de erro usuario já existe
                $message->setMessage("Usuário já cadastrado, tente outro e-mail", "error", "back");
            }
        } else {
            // enviar mensagem de erro de senhas não são iguais
            $message->setMessage("As senhas não são iguais", "error", "back");
        }
    } else {
        // enviar mensagem de erro de dados faltantes
        $message->setMessage("Por favor preeencha todos os campos", "error", "back");
    }
} else if ($type === "login") {
}
