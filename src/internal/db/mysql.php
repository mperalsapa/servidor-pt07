<?php
// Marc Peral 2DAW

// aquesta funcio s'encarrega de connectar amb la base de dades
// si es produeix un error, indiquem a l'usuari que s'ha produit un error i que contacti amb l'administrador
function getMysqlPDO(): PDO
{
    include("env.php");
    $servername = $mysqlHost;
    $username = $mysqlUser;
    $password = $mysqlPassword;
    $dbname = $mysqlDB;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        if ($debug) {
            $response =  "S'ha produit un error a l'hora de connectarse amb la base de dades. Contacta amb un administrador.<br>";
            $response = $response . "Error: $e";
            returnResponse($response, 500);
        } else {
            include_once("src/internal/form_errors.php");
            returnResponse("S'ha produit un error a l'hora de connectarse a la base de dades. Contacta amb un administrador.", 500);
        }
        die();
    }

    return $conn;
}

// busca en la base de dades si existeix un usuari amb un correu electronic demanat
function userExists(string $email): bool
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('SELECT id FROM usuaris WHERE correu = :email');
    $pdo->bindParam(":email", $email);
    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// afegeix un usuari a la base de dades, el cual ha sigut introduït en el "formulari" i s'ha enviat via AJAX
function addUser(string $name, string $email, string $birthDate, string $country): bool
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('INSERT INTO usuaris (nom, correu, naixement, pais) VALUES (:name, :email, :birthDate, :country)');
    $pdo->bindParam(":name", $name);
    $pdo->bindParam(":email", $email);
    $pdo->bindParam(":birthDate", $birthDate);
    $pdo->bindParam(":country", $country);

    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// agafa la informacio dels usuaris en base de dades
function getUsers(): Mixed
{
    $mysqlPdo = getMysqlPDO();
    $pdo = $mysqlPdo->prepare('SELECT nom, correu, naixement, pais FROM usuaris');
    $pdo->execute();

    if ($pdo->rowCount() > 0) {
        return $pdo;
    } else {
        return null;
    }
}
