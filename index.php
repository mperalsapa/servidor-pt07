<?php
// Marc Peral
// script que s'encarrega de fer de "router" per a les peticions
// si tenim un servidor web que indiquem 403 a tot fitxer que sigui dintre del directori de src
// podem fer que d'aquesta manera nomes s'accedeixi als scripts que volem amb la ruta que volem.
// per exemple, si fem una crida de social login a google, ens retornara a /google-login, i aquesta ruta està
// en un script comú, el qual es "login-callback.php".
// d'aquesta manera podem associar mes d'una ruta al mateix script

// importem les variables d'entorn i funcions necessaries
require("env.php");

// funció que s'encarrega de mostrar la ruta demanada si existeix. Si no existeix, fa una redirecció a l'arrel.
// per exemple si un bot o algú que no sap el que fa introdueix una ruta com wp-admin, li farà una redirecció a l'arrel.
function route(string $url, array $mux, string $baseUrl): void
{
    if (isset($mux[$url])) {
        $controller = $mux[$url];
        include_once($controller);
        die();
    } else {
        header("location: $baseUrl");
    }
}

// declarem les rutes del lloc

$mux["/"] = "src/views/index.html";
$mux["/create-user"] = "src/controllers/create_user.php";
$mux["/read-users"] = "src/controllers/read_users.php";

// agafem el path de la petició
// per exemple, el path de https://google.com/cerca.php seria /cerca.php
$parsedUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// comprovem si la variable d'entorn es buida o es una "/".
// en cas de ser-ho vol dir que el lloc es a l'arrel del servidor web
// mostrem la ruta normalment 
if (empty($baseUrl) || $baseUrl == "/") {
    route($parsedUri, $mux, $baseUrl);
}

// si el lloc no es a l'arrel, trèiem la baseurl de la url actual
// es a dir, si la base url del lloc es (en el meu cas)
// /servidor/UF1/pt04/ i la petició es /servidor/UF1/pt04/contact
// ens traurà la base de la petició i quedara aquest resultat
// /contact
$parsedUri = "/" . str_replace($baseUrl, "", $parsedUri);
route($parsedUri, $mux, $baseUrl);
