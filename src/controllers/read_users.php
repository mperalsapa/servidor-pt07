<?php
// Marc Peral
// script que s'encarrega de llegir de la base de dades tots els usuaris

include_once("src/internal/form_errors.php");
include_once("src/internal/db/mysql.php");

// funció que genera un array preparat per convertir-lo en json
// @return string[]
function makeUser($name, $email, $birthDate, $country): array
{
    $userData = array("name" => $name, "email" => $email, "birthDate" => $birthDate, "country" => $country);
    return $userData;
}

function reponseUsers(array $users): void
{
    // afegim l'array d'usuaris a un "objecte" (array)
    $data = array("users" => $users);
    // indiquem al navegador que el que rebrà es JSON
    header('Content-Type: application/json; charset=utf-8');
    // convertim l'array d'usuaris en JSON
    echo json_encode($data);
    die();
}

// creem un array que omplirem amb els usuaris de la base de dades
$users = array();
// agafem els usuaris de la base de dades
$queriedUsers = getUsers();

// en cas de la query sigui null, retornem un array buit
if (is_null($queriedUsers)) {
    reponseUsers($users);
}

// afegirem cada usuari a l'array d'usuaris buida
while ($user = $queriedUsers->fetch()) {
    $userData = makeUser($user["nom"], $user["correu"], $user["naixement"], $user["pais"]);
    array_push($users, $userData);
}

reponseUsers($users);
