/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase(); //convertir lo que recibo en minusculas para empezar a validar
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz"; //se le permite espacio por eso el espacio al inicio
    //BackSpace-izquiera-derecha-suprimir-Ñ
    especiales = "8-37-38-39-46-164";

    tecla_especial = false
    for (var i in especiales) {
        if (key === especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) === -1 && !tecla_especial) {
        return false;
    }
}

function soloNumeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    numeros = "0123456789";
    // izquiera-derecha-suprimir
    especiales = "37-38-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key === especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (numeros.indexOf(tecla) === -1 && !tecla_especial) {
        return false;
    }
}

function validarUsuario(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();    
    patron = "áéíóúabcdefghijklmnñopqrstuvwxyz0123456789-_@.";    
    // izquiera-derecha-suprimir
    especiales = "37-38-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key === especiales[i]) {
            tecla_especial = true;
            break;
        }
    }
    if (patron.indexOf(tecla) === -1 && !tecla_especial) {
        return false;
    }
}





