<?php
include_once("src/internal/form_errors.php");
include_once("src/internal/db/mysql.php");

// funció que es fa servir per validar la data introduïda per l'usuari
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}


// comprovem si la petició es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // comprovem si hi ha error amb algun camp introduït
    if (empty($_POST["name"]) || strlen($_POST["name"]) > 50) {
        $alertMessage = "Has d'introduir un nom (maxim 50 caràcters).";
    }
    $userData["name"] = $_POST["name"];

    if (empty($_POST["email"]) || strlen($_POST["email"]) > 50) {
        $alertMessage = "Has d'introduir un email (maxim 50 caràcters).";
    }
    $userData["email"] = $_POST["email"];

    if (empty($_POST["country"]) || strlen($_POST["country"]) > 50) {
        $alertMessage = "Has d'introduir un pais (maxim 50 caràcters).";
    }
    $userData["country"] = $_POST["country"];

    if (empty($_POST["birthDate"]) || !validateDate($_POST["birthDate"])) {
        $alertMessage = "Has d'introduir una data valida.";
    }
    $userData["birthDate"] = $_POST["birthDate"];

    // en cas de tenir algun error, mostrem el missatge i retornem el formulari un altre cop
    if (isset($alertMessage)) {
        returnResponse($alertMessage, 400);
    }

    if (userExists($userData["email"])) {
        $alertMessage = "L'usuari introduït (correu electronic) ja existeix a la base de dades.";
        returnResponse($alertMessage, 400);
    };

    if (!addUser($userData["name"], $userData["email"], $userData["birthDate"], $userData["country"])) {
        $alertMessage = "No s'ha pogut crear l'usuari a la base de dades";
        returnResponse($alertMessage, 500);
    }

    returnResponse("S'ha creat l'usuari correctament", 200);
}
