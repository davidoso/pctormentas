function capitalize(str) {
    return str[0].toUpperCase() + str.slice(1).toLowerCase();
}

function over(id) {
    document.getElementById(id).innerHTML = "Consultar sistema de alerta de tormentas " + capitalize(id);
}

function out(id) {
    document.getElementById(id).innerHTML = capitalize(id);
}