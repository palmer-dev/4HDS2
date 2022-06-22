<?php

include_once 'php/connection_bdd.php';
include_once 'php/operation_base_de_donnees.php';

$idToDelete = $_GET["id"];
$TypOfElement = $_GET["element"];

if ($TypOfElement == "user") {
    deleteUser($idToDelete);
    header('Location: utilisateurs.php');
}

if ($TypOfElement == "medicament") {
    deleteMedicament($idToDelete);
    header('Location: medicaments.php');
}
