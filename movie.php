<?php
include_once("templates/header.php");

// verifica se o usuário está autenticado
include_once("models/Movie.php");
require_once("dao/MovieDAO.php");

// pegar o id do filme 
$id = filter_input(INPUT_GET, "id");
$movie;

$movieDao = new MovieDAO($conn, $BASE_URL);

if (empty($id)) {
    $message->setMessage("O filme não foi encontrado!", "error", "/index.php");
} else {
    $movie = $movieDao->findById($id);

    // verifica se o filme existe
    if (!$movie) {
        $message->setMessage("O filme não foi encontrado!", "error", "/index.php");
    }
}

// checar se o filme é do usuário
$userOwnsMovie = false;

if (!empty($userData)) {
    if ($userData->id === $movie->users_id) {
        $userOwnsMovie = true;
    }
}

//regatar as reviews do filme
