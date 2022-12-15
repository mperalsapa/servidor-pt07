var alertStatus = "alert-primary";

// funcio copiada de StackOverflow que converteix les dates del format 2000-12-31 a edat tenin en compte que la data es naixement.
function calculateAge(birthday) {
    const ageDifMs = Date.now() - new Date(birthday).getTime();
    const ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

// funcio que canvia l'estat de lalerta per que sigui visible
function toggleAlert(newState) {
    if (newState) {
        document.getElementById("statusAlert").classList.remove("d-none")
    } else {
        document.getElementById("statusAlert").classList.add("d-none")
    }

}

// funcio que canvia l'estat de l'alerta i el seu missatge
function setAlertStatus(alertMessage, alertType) {

    // agafem la referencia a l'alerta
    let alert = document.getElementById("statusAlert");

    // si el nou estat es diferent, canviem l'estat actual per el nou
    if (alertStatus != alertType) {
        succ = alert.classList.replace(alertStatus, alertType);
        if (succ) {
            alertStatus = alertType;
        }
    }

    // afegim el text de l'alerta
    document.getElementById("alertContent").innerText = alertMessage;

    // com no sabem quin tipus d'alerta tenim actualment, esborrem totes les possibles classes
    // alert.classList.remove("alert-primary");
    // alert.classList.remove("alert-secondary");
    // alert.classList.remove("alert-success");
    // alert.classList.remove("alert-danger");
    // alert.classList.remove("alert-warning");
    // alert.classList.remove("alert-info");
    // alert.classList.remove("alert-light");
    // alert.classList.remove("alert-dark");

}

// enviem al backend les dades del nou usuari
function sendNewUser() {

    // agafem les dades del formulari
    let name = document.getElementById("username-input").value
    let email = document.getElementById("useremail-input").value
    let birthDate = document.getElementById("userbirth-input").value
    let country = document.getElementById("usercountry-input").value

    // les guardem en un objecte per afegir-lo a la taula del client
    userData = { "name": name, "email": email, "birthDate": birthDate, "country": country };

    // mostrem un log de les dades que enviarem
    console.log("Sending new user with data: name=" + name + "\nemail=" + email + "\nbirthDate=" + birthDate + "\ncountry=" + country)

    // preparem l'alerta
    toggleAlert(true);
    setAlertStatus("Processant peticio...", "alert-primary")

    // preparem la peticio AJAX
    var xhttp = new XMLHttpRequest();
    // afegim una funcio que escolta els canvis en la peticio AJAX
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            let alertType;
            switch (this.status) {
                case 200:
                    alertType = "alert-success";
                    console.log(userData);
                    displayNewUser(userData);
                    clearForm();
                    break;
                default:
                    alertType = "alert-danger"

            }
            setAlertStatus(this.responseText, alertType)
        }

    };
    // configurem que sigui POST i la ruta del backend, i el header indicant que son dades d'un "formulari"
    xhttp.open("POST", "create-user");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // enviem les dades del nou usuari al backend
    xhttp.send(`name=${name}&email=${email}&birthDate=${birthDate}&country=${country}`);
}

// funcio que s'encarrega de esborrar el contingut dels camps del "formulari"
function clearForm() {
    document.getElementById("username-input").value = "";
    document.getElementById("useremail-input").value = "";
    document.getElementById("userbirth-input").value = "";
    document.getElementById("usercountry-input").value = "Afghanistan";
}

// funcio que afegeix a la taula d'usuaris una nova fila amb les dades introduides com a parametre
function displayNewUser(userData) {

    // busquem la taula on afegir l'usuari
    var table = document.getElementById("userTable");

    // creem una nova fila per afegir les dades de l'usuari
    var row = table.insertRow();

    // afegim les dades de l'usuari a la fila
    for (const [k, v] of Object.entries(userData)) {
        const ceil = row.insertCell();
        if (k == "birthDate") {
            let age = calculateAge(v);
            ceil.appendChild(document.createTextNode(age))
        } else {
            ceil.appendChild(document.createTextNode(v))
        }
    }

}

// funcio que s'encarrega de demanar tots els usuaris al backend i els mostra a la taula d'usuaris
function displayUsers() {

    toggleAlert(true);
    setAlertStatus("Carregant dades...", "alert-primary")

    // enviem les dades del nou usuari al backend
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            switch (this.status) {
                case 200:
                    toggleAlert(false);
                    response = JSON.parse(this.responseText)
                    response.users.forEach(user => {
                        displayNewUser(user)
                    });
                    break;
                default:
                    setAlertStatus(this.responseText, "alert-danger");

            }
        }

    };
    xhttp.open("GET", "read-users");
    xhttp.send();

}

// en la carrega inicial de la web, carregarem tots els usuaris per tenir una vista actual de les dades
displayUsers();