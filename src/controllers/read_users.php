<?php
include_once("src/internal/form_errors.php");
include_once("src/internal/db/mysql.php");

function makeUser($name, $email, $birthDate, $country): array
{
    $userData = array("name" => $name, "email" => $email, "birthDate" => $birthDate, "country" => $country);
    return $userData;
}


$queriedUsers = getUsers();
$users = array();
while ($user = $queriedUsers->fetch()) {
    $userData = makeUser($user["nom"], $user["correu"], $user["naixement"], $user["pais"]);
    array_push($users, $userData);
}

$data = array("users" => $users);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
