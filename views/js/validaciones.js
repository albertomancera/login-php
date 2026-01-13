// Función auxiliar para mostrar errores visuales en un campo específico
function marcarError(identificador, mensaje) {
    var divAyuda = document.getElementById(identificador + 'Help'); // Busca el div de ayuda asociado al input (ej: usuarioHelp)
    divAyuda.innerHTML = mensaje; // Inserta el texto del error dentro de ese div
    divAyuda.removeAttribute("hidden"); // Elimina el atributo 'hidden' para hacer visible el mensaje
    document.getElementById(identificador).style.borderColor = "red"; // Cambia el borde del input a rojo para resaltar el error
}

// Función auxiliar para limpiar/ocultar los errores visuales
function limpiarError(identificador) {
    var divAyuda = document.getElementById(identificador + 'Help'); // Busca el div de ayuda
    divAyuda.setAttribute("hidden", true); // Lo oculta añadiendo el atributo 'hidden'
    document.getElementById(identificador).style.borderColor = "#DEE2E6"; // Restaura el color original del borde (gris claro)
}

// Función principal que valida todo el formulario
function validarFormulario() {
    var usuario = document.getElementById('usuario').value; // Obtiene el valor actual del campo usuario
    var password = document.getElementById('password').value; // Obtiene el valor actual del campo password
    var correcto = true; // Bandera (flag) que asume que todo está bien al principio

    // Validación del Usuario
    if (usuario.trim() === "") { // Verifica si está vacío (quitando espacios en blanco)
        marcarError('usuario', 'El usuario es obligatorio.'); // Muestra error
        correcto = false; // Marca el formulario como inválido
    } else if (usuario.length < 8 || usuario.length > 15) { // Verifica la longitud requerida
        marcarError('usuario', 'El usuario debe tener entre 8 y 15 caracteres.');
        correcto = false;
    }

    // Expresiones Regulares (Regex) para analizar la contraseña
    var tieneMayus = /[A-Z]/.test(password); // Comprueba si tiene al menos una mayúscula
    var tieneMinus = /[a-z]/.test(password); // Comprueba si tiene al menos una minúscula
    var tieneAutorizados = /[@._\-\#$%\&*!?+]/.test(password); // Comprueba caracteres especiales permitidos
    var tieneProhibidos = /[ '"\\\/<>=\(\)]/.test(password); // Comprueba caracteres prohibidos (espacios, comillas, etc.)

    // Lógica de validación de Contraseña
    if (password.length < 8 || password.length > 15) { // Longitud
        marcarError('password', 'La contraseña debe tener entre 8 y 15 caracteres.');
        correcto = false;
    } else if (tieneProhibidos) { // Seguridad: caracteres peligrosos
        marcarError('password', 'La contraseña contiene caracteres prohibidos.');
        correcto = false;
    } else if (!tieneMayus || !tieneMinus || !tieneAutorizados) { // Complejidad
        marcarError('password', 'La contraseña no cumple con los requisitos de seguridad (mayúsculas, minúsculas y símbolos).');
        correcto = false;
    }

    return correcto; // Devuelve true si pasó todas las pruebas, false si falló alguna
}

// Espera a que el HTML cargue completamente antes de asignar eventos
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('formulario').addEventListener("submit", function(event){ // Escucha el evento de envío (submit)
        if (!validarFormulario()) { // Ejecuta la validación; si devuelve false...
            event.preventDefault(); // ...detiene el envío del formulario al servidor
        }
    });
});

// Eventos para limpiar los errores en tiempo real mientras el usuario escribe
document.getElementById('usuario').addEventListener("input", function(){
    limpiarError('usuario');
});

document.getElementById('password').addEventListener("input", function(){
    limpiarError('password');
});