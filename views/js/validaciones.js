function marcarError(identificador, mensaje) {
    var divAyuda = document.getElementById(identificador + 'Help');
    divAyuda.innerHTML = mensaje;
    divAyuda.removeAttribute("hidden");
    document.getElementById(identificador).style.borderColor = "red";
}

function limpiarError(identificador) {
    var divAyuda = document.getElementById(identificador + 'Help');
    divAyuda.setAttribute("hidden", true);
    document.getElementById(identificador).style.borderColor = "#DEE2E6";
}

function validarFormulario() {
    var usuario = document.getElementById('usuario').value;
    var password = document.getElementById('password').value;
    var correcto = true;

    if (usuario.trim() === "") {
        marcarError('usuario', 'El usuario es obligatorio.');
        correcto = false;
    } else if (usuario.length < 8 || usuario.length > 15) {
        marcarError('usuario', 'El usuario debe tener entre 8 y 15 caracteres.');
        correcto = false;
    }

    var tieneMayus = /[A-Z]/.test(password);
    var tieneMinus = /[a-z]/.test(password);
    var tieneAutorizados = /[@._\-\#$%\&*!?+]/.test(password);
    var tieneProhibidos = /[ '"\\\/<>=\(\)]/.test(password);

    if (password.length < 8 || password.length > 15) {
        marcarError('password', 'La contraseña debe tener entre 8 y 15 caracteres.');
        correcto = false;
    } else if (tieneProhibidos) {
        marcarError('password', 'La contraseña contiene caracteres prohibidos.');
        correcto = false;
    } else if (!tieneMayus || !tieneMinus || !tieneAutorizados) {
        marcarError('password', 'La contraseña no cumple con los requisitos de seguridad (mayúsculas, minúsculas y símbolos).');
        correcto = false;
    }

    return correcto;
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('formulario').addEventListener("submit", function(event){
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });
});

document.getElementById('usuario').addEventListener("input", function(){
    limpiarError('usuario');
});

document.getElementById('password').addEventListener("input", function(){
    limpiarError('password');
});