<?php
require_once('../Controller/TallerController');

if (!isset($_GET["id"])) {
    header("Location: ../index.php?error=id_invalido");
}
$id = $_GET["id"];
TallerController::desactivarRepuesto($id);

?>