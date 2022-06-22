<?php

// ************ FONCTIONS GENERALES ************ //
function randomToken($car)
{
    $string = "";
    $chaine =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqr
    stuvwxyz";
    srand((float) microtime() * 1000000);
    for ($i = 0; $i < $car; $i++) {
        $string .= $chaine[rand() % strlen($chaine)];
    }
    return $string;
}

// ************ SELECTION DES ELEMENTS DANS LA BdD ************ //
function selectUsers()
{
    $query = "SELECT * FROM users";
    return callBdD($query, "select");
}

function selectMedicaments()
{
    $query = "SELECT * FROM medicaments";
    return callBdD($query, "select");
}

// ************ CREATION DES ELEMENTS DANS LA BdD ************ //
function createUser($nom, $prenom, $role)
{
    $query = "INSERT INTO users(nom,prenom,role,token) VALUES ('$nom','$prenom','$role', '" . randomToken(40) . "')";
    callBdD($query, "insert");
}

function createMedicament($nom, $prix, $stock, $description, $reference)
{
    $query = "INSERT INTO medicaments(nom,description,token,prix,stock,reference) VALUES ('$nom','$description', '" . randomToken(40) . "','$prix','$stock','$reference')";
    callBdD($query, "insert");
}

// ************ MODIFIER DES ELEMENTS DANS LA BdD ************ //
function alterUser($id, $nom, $prenom, $role, $newToken)
{
    // Si il y a une demande de génération d'un nouveau TOKEN
    if ($newToken == True) {
        $query = "UPDATE users SET nom='$nom', prenom = '$prenom', role = '$role', token = '" . randomToken(40) . "', updated_at=CURRENT_TIMESTAMP WHERE id = $id";
    }
    // Si il n'y a pas de demande de génération d'un nouveau TOKEN 
    else {
        $query = "UPDATE users SET nom='$nom', prenom = '$prenom', role = '$role', updated_at=CURRENT_TIMESTAMP WHERE id = $id";
    }

    callBdD($query, "update");
}

function alterMedicament($id, $nom, $prix, $stock, $description, $reference, $newToken)
{
    // Si il y a une demande de génération d'un nouveau TOKEN
    if ($newToken == True) {
        $query = "UPDATE medicaments SET nom='$nom', prix = '$prix', stock = '$stock', token = '" . randomToken(40) . "', description='$description', reference='$reference', updated_at=CURRENT_TIMESTAMP WHERE id = $id";
    }
    // Si il n'y a pas de demande de génération d'un nouveau TOKEN 
    else {
        $query = "UPDATE medicaments SET nom='$nom', prix = '$prix', stock = '$stock', description='$description', reference='$reference', updated_at=CURRENT_TIMESTAMP WHERE id = $id";
    }

    callBdD($query, "update");
}

// ************ SUPPRESSION DES ELEMENTS DANS LA BdD ************ //
function deleteUser($id)
{
    $query = "DELETE FROM users WHERE id = $id";
    callBdD($query, "delete");
};

function deleteMedicament($id)
{
    $query = "DELETE FROM medicaments WHERE id = $id";
    callBdD($query, "delete");
};

// ************ ACTION SUR LA BdD ************ //
function callBdD($query, $type)
{
    $check_query_message = null;
    $check_query = false;
    global $dbhost, $dbuser, $dbpass, $dbport, $db, $dbport;
    $check_query = false;
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $db, $dbport);
    if ($mysqli->connect_errno) {
        die('Could not connect: ' . $mysqli->connect_error);
    }
    $content = [];
    $result = $mysqli->query($query);
    if ($result) {
        $check_query = true;
        if ($type == "select") {
            while ($row = $result->fetch_assoc()) {
                $content[] = $row;
            }
        }
    } else {
        $check_query_message = $mysqli->error;
    }
    $mysqli->close();
    return ["content" => $content, "check_query" => $check_query, "check_query_message" => $check_query_message];
}
