<?php

include_once 'php/connection_bdd.php';
include_once 'php/operation_base_de_donnees.php';

$idToUpdate = $_GET["id"];
$TypOfElement = $_GET["element"];

if ($TypOfElement == "user") {
    $nom = $_GET["nom"];
    $prenom = $_GET["prenom"];
    $role = $_GET["role"];
    $newToken =  $_GET["newToken"];
    alterUser($idToUpdate, $nom, $prenom, $role, $newToken);
    header('Location: utilisateurs.php');
}

if ($TypOfElement == "medicament") {
    $nom = $_GET["nom"];
    $prenom = $_GET["prenom"];
    $role = $_GET["role"];
    $newToken =  $_GET["newToken"];
    alterUser($idToUpdate, $nom, $prenom, $role, $newToken);
    header('Location: medicaments.php');
}
