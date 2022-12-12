<?php
// Marc Peral
// script que s'encarrega de guardar i llegir dades de la sessio de PHP


// comprovem l'estat de la sessio.
// 0 = session disabled
// 1 = session none
// 2 = session started
// en cas de no haver-hi sessio, la iniciem
if (session_status() == 1) {
    session_start();
}

// funcio que comprova si l'usuari te una sessio iniciada. Retorna un valor boolea
function checkLogin(): bool
{
    if (!isset($_SESSION["loggedin"])) {
        $_SESSION["loggedin"] = false;
    }

    if ($_SESSION["loggedin"]) {
        return true;
    }
    return false;
}

// funcio que guarda l'estat de sessio iniciada
function setLoggedin(bool $loggedin): void
{
    $_SESSION["loggedin"] = $loggedin;
}

// funcio que guarda les inicials de l'usuari en la sessio
function setInitials(array $initials): void
{
    $_SESSION["name-initial"] = $initials[0];
    $_SESSION["surname-initial"] = $initials[1];
}

// funcio que guarda l'id de l'usuari en la sessio
function setUserID(string $userID): void
{
    $_SESSION["id"] = $userID;
}

// funcio que agafa l'id de l'usuari de la sessio
function getUserIDSession(): int
{
    return $_SESSION["id"];
}

// funcio que agafa el numero d'intents que s'han fet per iniciar sessio
function getLoginAttempts(): int
{
    if (isset($_SESSION["login-attempts"])) {
        return $_SESSION["login-attempts"];
    }
    return 0;
}

// funcio que guarda el numero d'intents que s'han fet per iniciar sessio
function setLoginAttempt(int $attempt): void
{
    $_SESSION["login-attempts"] = $attempt;
}

// funcio que guarda el la sessio, les dades de l'usuari, com les inicials, el id o si ha iniciat sessio
function setUserLoggedinData(PDO $pdo, string $email): void
{
    setLoginAttempt(0);
    $initials = getUserInitials($pdo, $email);
    setInitials($initials);
    $id = getUserID($pdo, $email);
    setUserID($id);
    setLoggedin(true);
}

function setLastArticleWrite(int $articleId): void
{
    $_SESSION["lastArticleWrite"] = $articleId;
}

function getLastArticleWrite(): int
{
    return $_SESSION["lastArticleWrite"];
}

function setSelectedImage(int $imageId): void
{
    $_SESSION["selectedImage"] = $imageId;
}

function getSelectedImage(): int
{
    return $_SESSION["selectedImage"];
}
