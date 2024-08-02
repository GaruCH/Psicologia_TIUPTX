// Validaciones Personalizadas
$.validator.addMethod("passRegex", function(value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test(value);
}, "Debe escoger una contraseña segura");

$.validator.addMethod("emailRegex", function(value, element) {
    return this.optional(element) || /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i.test(value);
}, "No corresponde a una ruta de email");

$.validator.addMethod("numeric", function(value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
}, "Solo se permiten números");

$.validator.addMethod("validDate", function(value, element) {
    var today = new Date();
    var dob = new Date(value);
    var minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate()); // 18 años atrás

    // Validar si la fecha de nacimiento es válida
    if (isNaN(dob.getTime())) {
        return false;
    }

    // Validar que la fecha de nacimiento no sea en el futuro
    if (dob > today) {
        return false;
    }

    // Validar que la fecha de nacimiento sea al menos 15 años atrás
    if (dob < minDate) {
        return false;
    }

    return true;
}, "Ingrese una fecha de nacimiento válida y que indique al menos 18 años de edad.");

// Validación Personalizada para Mayores de 18 Años
$.validator.addMethod("ageMin18", function(value, element) {
    var today = new Date();
    var dob = new Date(value);
    var minAge = 3;

    // Validar si la fecha de nacimiento es válida
    if (isNaN(dob.getTime())) {
        return false;
    }

    // Calcular la edad
    var age = today.getFullYear() - dob.getFullYear();
    var monthDiff = today.getMonth() - dob.getMonth();

    // Ajustar la edad si el mes de nacimiento aún no ha llegado
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    return age >= minAge;
}, "Debes tener al menos 3 años.");

// FORMULARIO VALIDACIÓN
$("#formulario-paciente-nuevo").validate({
    rules: {
        nombre: {
            required: true,
            rangelength: [3, 50]
        },
        ap_paterno: {
            required: true,
            rangelength: [3, 50]
        },
        ap_materno: {
            required: true,
            rangelength: [3, 50]
        },
        fecha_nacimiento: {
            required: true,
            validDate: true,
            ageMin18: true,
            date: true
        },
        referencia: {
            required: true
        },
        emailr: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        },
        passwordr: {
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_passwordr: {
            required: true,
            equalTo: '#passwordr',
            rangelength: [8, 16],
            passRegex: true
        },
        identificador: {
            required: true,
        }
    }, // end rules
    messages: {
        nombre: {
            required: 'Se requiere el nombre del paciente.',
            rangelength: 'El nombre debe tener entre 3 y 50 caracteres.'
        },
        ap_paterno: {
            required: 'Se requiere el apellido paterno del paciente.',
            rangelength: 'El apellido paterno debe tener entre 3 y 50 caracteres.'
        },
        ap_materno: {
            required: 'Se requiere el apellido materno del paciente.',
            rangelength: 'El apellido materno debe tener entre 3 y 50 caracteres.'
        },
        fecha_nacimiento: {
            required: 'Se requiere la fecha de nacimiento del paciente.',
            validDate: 'Ingrese una fecha de nacimiento válida y que indique al menos 18 años de edad.',
            ageMin18: 'Debes tener al menos 18 años.',
            date: 'Ingrese una fecha válida.'
        },
        referencia: {
            required: 'Se requiere el tipo de referencia.'
        },
        emailr: {
            required: 'Se requiere el correo electrónico del paciente.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
        },
        passwordr: {
            required: 'Se requiere la contraseña para el paciente.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc.).'
        },
        confirm_passwordr: {
            required: 'Se requiere confirmar la contraseña del paciente.',
            equalTo: 'Las contraseñas no coinciden.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc.).'
        },
        identificador: {
            required: 'Se requiere el identificador del paciente.'
        }
    }, // end messages
    highlight: function(input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    }, // end highlight
    unhighlight: function(input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    }, // end unhighlight
    errorPlacement: function(error, element) {
        $(element).next().append(error);
    } // end errorPlacement
}); // end validation


// Validación de checkbox y radio button
$("#formulario-paciente-nuevo").submit(function(event) {
    if ($('.radio-item:checked').length <= 0) {
        event.preventDefault();
        mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
    }
});

// Funcionalidad para cambiar la imagen de perfil en función del género
$("input[name='sexo']").on('change', function() {
    if ($(this).val() === 'Masculino') {
        $("#imagen_perfil").attr('src', 'path-to-male-image.png');
    } else if ($(this).val() === 'Femenino') {
        $("#imagen_perfil").attr('src', 'path-to-female-image.png');
    }
});


function nextSection() {
    // Validar la primera sección
    if ($("#formulario-paciente-nuevo").valid()) {
        // Validar que se haya seleccionado al menos un radio button
        if ($('.radio-item:checked').length <= 0) {
            // Mostrar notificación si no se selecciona ningún radio button
            mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
            return; // Detener la navegación si la validación falla
        }

        // Si la primera sección es válida y todos los radio buttons están seleccionados, ocultar la sección 1 y mostrar la sección 2
        document.getElementById('section1').classList.add('d-none');
        document.getElementById('section2').classList.remove('d-none');
    } else {
        // Si la primera sección no es válida, mostrar errores
        $("html, body").animate({ scrollTop: $("#formulario-paciente-nuevo").offset().top }, 500);
    }
}

function prevSection() {
    // Volver a mostrar la primera sección y ocultar la segunda sección
    document.getElementById('section2').classList.add('d-none');
    document.getElementById('section1').classList.remove('d-none');
}
