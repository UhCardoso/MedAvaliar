<?php
include_once("templates/header.php");
require_once("dao/UserDAO.php");

$userDao = new UserDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

?>
<div id="main-container" class="container-fuid">
    <h1>Edição de perfil</h1>
</div>
<?php
include_once("templates/footer.php");
?>