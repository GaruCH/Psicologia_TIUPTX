let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_psicologos_table = () => {
    columns_elements = [
        {
            "targets": [0, 1, 2, 3, 4, 5, 6],
            "createdCell": function (td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");
            },
        }
    ];
    columns_order = [
        { "data": "total" },
        { "data": "numero_trabajador" },
        { "data": "nombre_psicologo" },
        { "data": "sexo_psicologo" },
        { "data": "edad_psicologo" },
        { "data": "correo_psicologo" },
        { "data": "acciones" }
    ];
    return instantiateAjaxDatatable('table-psicologos', './obtener_psicologos', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_psicologos = create_psicologos_table();



// BOTONES OPCIONES
// =================================================================
$(document).on('click', '.estatus-psicologo', function () {
    let elemento = $(this).attr('id');
    let id = elemento.split('_')[0];
    let estatus = elemento.split('_')[1];
    let array = ['./estatus_psicologo', id, estatus, 'este psicologo', 'podrá ingresar al sistema.'];
    cambiar_estatus_datatable(array, table_psicologos);
});//end onclick estatus-psicologos


$(document).on('click', '.eliminar-psicologo', function () {
    eliminar_datatable("./eliminar_psicologo", $(this).attr('id'), '¿Estás seguro de eliminar a este psicologo?', 'Esta acción es permanente', table_psicologos);
});//end onclick eliminar-psicologo


$(document).on('click', '.recover-psicologo', function () {
    let titulo = '¿Deseas recuperar a este psicólogo?';
    let texto = 'Al recuperar este psicólogo volverá a estar disponible en la base de datos del sistema y podrá ser visualizado en el panel. ¿Estás seguro de restaurar a este psicólogo?';
    let texto_confirmar = 'Sí, restaurar el psicólogo';
    let texto_cancelar = 'Cancelar';
    let opciones_form = ['./restaurar_psicologo', 'POST'];
    let data = new FormData();
    data.append('id', $(this).attr('id').split('_')[1]);
    mensaje_confirmacion_texto_propio(titulo, texto, texto_confirmar, texto_cancelar, opciones_form, data);
});//end onclick recover-psicologo


//==============================================================================
//==============SECCIÓN PARA CAMBIAR CONTRASEÑA USUARIO=========================
//==============================================================================



$(document).on('click', '.cambiar-password-psicologo', function () {
    let clean_elements = { 'password_psicologo': '', 'confirm_password_psicologo': '', 'id_psicologo_pass': '' };
    resetear_formulario('formulario-cambiar-password-psicologo', clean_elements, false);

    // Obtener el ID del psicólogo desde el botón y asignarlo al campo oculto
    let psicologoId = $(this).attr('id').split('_')[1];
    //console.log('ID del psicólogo:', psicologoId); // Agrega este log para depuración
    document.getElementById('id_psicologo_pass').value = psicologoId;

    let modal_change_password = new bootstrap.Modal(document.getElementById('cambiar-password-psicologo'));
    modal_change_password.show();
});


document.getElementById('formulario-cambiar-password-psicologo').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    if ($('#formulario-cambiar-password-psicologo .is-invalid').length == 0) {
        loader.setLoaderTitle('Actualizando la contraseña del psicólogo, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se actualiza al psicólogo...');
        loader.openLoader();

        fetch('./actualizar_password_psicologo', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-cambiar-password-psicologo'))
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Ocurrió un error');
                }
                return res.json();
            })
            .then(respuesta => {
                loader.closeLoader();
                mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

                if (respuesta.error === 0) {
                    $('#formulario-cambiar-password-psicologo')[0].reset();
                    $('.invalid-feedback').text('');
                    feather.replace();
                    $('#formulario-cambiar-password-psicologo .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-cambiar-password-psicologo .form-check-input').removeClass('is-valid is-invalid');
                    $('#cambiar-password-psicologo').modal('hide');
                    table_psicologos.ajax.reload(null, false);
                }
            })
            .catch(error => {
                loader.closeLoader();
                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al actualizar!', 4000);
            });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});





$.validator.addMethod("passRegex", function (value, element) {
    return this.optional(element) || /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$/.test(value);
}, "Debe escoger una contraseña segura");


// FORM CAMBIAR_PASSWORD VALIDATION
// =================================================================
$("#formulario-cambiar-password-psicologo").validate({
    rules: {
        password_psicologo: {
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_password_psicologo: {
            required: true,
            equalTo: '#password_psicologo',
            rangelength: [8, 16],
            passRegex: true
        }
    },//end rules
    messages: {
        password_psicologo: {
            required: 'Se requiere la nueva contraseña para el psicólogo.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        },
        confirm_password_psicologo: {
            required: 'Se requiere confirmar la nueva contraseña.',
            equalTo: 'Las contraseñas no coinciden.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        }
    },//end messages
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },//end highlight
    unhighlight: function (input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },//end unhighlight
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }//end errorPlacement
});//end validation





//================================================================
//===================SECCIÓN PARA CREAR===========================
//================================================================
$.validator.addMethod("emailRegex", function (value, element) {
    return this.optional(element) || /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i.test(value);
}, "No corresponde a una ruta de email");

// Método de validación personalizado para asegurar solo números
$.validator.addMethod("numeric", function (value, element) {
    return this.optional(element) || /^[0-9]+$/.test(value);
}, "Solo se permiten números");

$("#formulario-psicologo-nuevo").validate({
    rules: {
        numero_trabajador: {
            required: true,
            maxlength: 3,
            numeric: true,
            minlength: 1
        },
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
        email: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        },
        fecha_nacimiento: {
            required: true,
            validDate: true,
            ageMin18: true,
            date: true
        },
        password: {
            required: true,
            rangelength: [8, 16],
            passRegex: true
        },
        confirm_password: {
            required: true,
            equalTo: '#password',
            rangelength: [8, 16],
            passRegex: true
        }
    },//end rules
    messages: {
        numero_trabajador: {
            required: 'Se requiere el numero de trabajador del psicólogo.',
            maxlength: 'El numero de trabajador no debe exceder los 3 caracteres.',
            numeric: "Solo se permiten números",
            minlength: "El numero de trabajador no debe tener menos de 1 caracter."
        },
        nombre: {
            required: 'Se requiere el nombre del psicólogo.',
            rangelength: 'El nombre debe tener entre 3 y 50 caracteres.'
        },
        ap_paterno: {
            required: 'Se requiere el apellido paterno del psicólogo.',
            rangelength: 'El apellido paterno debe tener entre 3 y 50 caracteres.'
        },
        ap_materno: {
            required: 'Se requiere el apellido materno del psicólogo.',
            rangelength: 'El apellido materno debe tener entre 3 y 50 caracteres.'
        },
        email: {
            required: 'Se requiere el correo electrónico del psicólogo.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
        },
        fecha_nacimiento: {
            required: 'Se requiere la fecha de nacimiento del psicólogo.',
            validDate: 'Ingrese una fecha de nacimiento válida y que indique al menos 18 años de edad.',
            ageMin18: 'Debes tener al menos 18 años.',
            date: 'Ingrese una fecha válida.'
        },
        password: {
            required: 'Se requiere la contraseña para la cuenta del psicólogo.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        },
        confirm_password: {
            required: 'Se requiere confirmar la contraseña para la cuenta del psicólogo.',
            equalTo: 'Las contraseñas no coinciden.',
            rangelength: 'La contraseña debe tener de 8 a 16 caracteres.',
            passRegex: 'La contraseña debe tener por lo menos un dígito, una mayúscula, una minúscula y un símbolo especial (&, %, $, #, etc..).'
        }
    },//end messages
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },//end highlight
    unhighlight: function (input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },//end unhighlight
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }//end errorPlacement
});//end validation

//FUNCIONES JS QUE SIRVEN PARA VALIDAR EL CHECKBOX Y RADIO BUTTON
$("#formulario-psicologo-nuevo").submit(function (event) {
    if ($('.radio-item:checked').length <= 0) {
        event.preventDefault();
        //mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
    }//end if no hay ningun radiobutton activo
});

$(document).on('click', '#masculino', function () {
    document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);");
    if (document.getElementById('imagen_perfil').value == '') {
        let urlImg = BASE_URL(I_D_O + '/no-image-m.png');
        let idImg = document.getElementById('img');
        idImg.src = urlImg;
    }//end if no hay imagen cargada
});//end onclick sexo masculino

$(document).on('click', '#femenino', function () {
    document.getElementById('imagen_perfil').setAttribute('onchange', "validate_image(this, 'img', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-f.png', 512, 512);");
    if (document.getElementById('imagen_perfil').value == '') {
        let urlImg = BASE_URL(I_D_O + '/no-image-f.png');
        let idImg = document.getElementById('img');
        idImg.src = urlImg;
    }//end if no hay imagen cargada
});//end onclick sexo femenino



$('#numero_trabajador').on('input', function () {
    if (this.value.length > 11) {
        this.value = this.value.slice(0, 3);
    }
});

// Prevenir ingreso de más de dos dígitos
$('#numero_trabajador').on('keypress', function (e) {
    if (this.value.length >= 3) {
        e.preventDefault();
    }
});


//INSERTAR PSICÓLOGO
//================================================================
document.getElementById('formulario-psicologo-nuevo').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    // Asegúrate de ejecutar tu lógica de validación antes de este punto
    if ($('#formulario-psicologo-nuevo .is-invalid').length == 0) {
        loader.setLoaderTitle('Registrando al psicólogo, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se registra al psicólogo...');
        loader.openLoader();

        fetch('./registrar_psicologo', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-psicologo-nuevo'))
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Ocurrió un error');
                }
                return res.json();
            })
            .then(respuesta => {
                loader.closeLoader();
                mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

                if (respuesta.error === 0) {
                    //Reseteamos los campos básicos
                    // Limpia todos los campos del formulario
                    $('#formulario-psicologo-nuevo')[0].reset();
                    // Limpia las imágenes de perfil si hay alguna cargada
                    let defaultSrc = $('#img').data('default-src');
                    $('#img').attr('src', defaultSrc);
                    // Limpia cualquier mensaje de retroalimentación
                    $('.invalid-feedback').text('');
                    // Limpia los íconos de los inputs
                    feather.replace();

                    // Eliminar clases de validación de Bootstrap
                    $('#formulario-psicologo-nuevo .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-psicologo-nuevo .form-check-input').removeClass('is-valid is-invalid');

                    $('#nuevo-psicologo').modal('hide');
                    table_psicologos.ajax.reload(null, false);
                }
            })
            .catch(error => {
                loader.closeLoader();
                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al registrar!', 4000);
            });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});




//==============================================================================
//===================SECCIÓN PARA EDITAR========================================
//==============================================================================




// CREAR DATOS DEL MODAL

// =================================================================
$(document).on('click', '.editar-psicologo', function () {
    let button_info = document.getElementById($(this).attr('id'));
    // Esconder el tooltip por si se bugea
    let tooltip_button = bootstrap.Tooltip.getInstance(button_info);
    if (tooltip_button) {
        tooltip_button.hide();
    }

    let id = $(this).attr('id').split('_')[1];

    loader.setLoaderTitle('Cargando datos, por favor espere...');
    loader.setLoaderBody('Por favor espere en lo que se cargan los datos del psicólogo...');
    loader.openLoader();

    fetch('./obtener_psicologo/' + id)
        .then(res => {
            if (!res.ok) {
                throw new Error('Ocurrió un error');
            }
            return res.json();
        })
        .then(respuesta => {
            loader.closeLoader();
            if (respuesta.data === -1) {
                mensaje_notificacion("No existe el psicólogo buscado ¿Ha seleccionado correctamente el psicólogo?", DANGER_ALERT, "!Error al obtener el psicólogo¡");
            } else {
                let clean_elements = {
                    'numero_trabajador_editar': respuesta.data.numero_trabajador_psicologo,
                    'nombre_editar': respuesta.data.nombre_usuario,
                    'ap_paterno_editar': respuesta.data.ap_paterno_usuario,
                    'ap_materno_editar': respuesta.data.ap_materno_usuario,
                    'masculino_editar': respuesta.data.sexo_usuario,
                    'femenino_editar': respuesta.data.sexo_usuario,
                    'email_editar': respuesta.data.email_usuario,
                    'fecha_nacimiento_editar': respuesta.data.fecha_nacimiento_usuario,
                    'id_psicologo_editar': respuesta.data.id_psicologo
                };

                // Manejo de la imagen
                let sexoUsuario = parseInt(respuesta.data.sexo_usuario, 10); // Convertir a número

                let imgSrc;
                if (respuesta.data.imagen_usuario) {
                    imgSrc = `../../recursos_panel_monster/images/profile-images/${respuesta.data.imagen_usuario}`;
                } else {
                    if (sexoUsuario === 2) {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-m.png'; // Masculino
                    } else if (sexoUsuario === 1) {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-f.png'; // Femenino
                    } else {
                        imgSrc = '../../recursos_panel_monster/images/profile-images/no-image-default.png'; // En caso de valor inesperado
                    }
                }

                clean_elements['img_editar'] = imgSrc;

                resetear_formulario('formulario-psicologo-editar', clean_elements, true);
                let modal_edit_psicologo = new bootstrap.Modal(document.getElementById('editar-psicologo'));
                modal_edit_psicologo.show();
            }
        })
        .catch(error => {
            loader.closeLoader();
            mensaje_notificacion("Hubo un error con nuestro servidor. Intente nuevamente, por favor", DANGER_ALERT, "!Error al obtener el psicólogo¡");
        });
});


$(document).on('click', '#masculino_editar', function () {
    document.getElementById('imagen_perfil_editar').setAttribute('onchange', "validate_image(this, 'img_editar', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-m.png', 512, 512);");
    if (document.getElementById('imagen_perfil_editar').value == '') {
        let urlImg = BASE_URL(I_D_O + '/no-image-m.png');
        let idImg = document.getElementById('img_editar');
        idImg.src = urlImg;
    }//end if no hay imagen cargada
});//end onclick sexo masculino

$(document).on('click', '#femenino_editar', function () {
    document.getElementById('imagen_perfil_editar').setAttribute('onchange', "validate_image(this, 'img_editar', 'btn-guardar', '../recursos_panel_monster/images/profile-images/no-image-f.png', 512, 512);");
    if (document.getElementById('imagen_perfil_editar').value == '') {
        let urlImg = BASE_URL(I_D_O + '/no-image-f.png');
        let idImg = document.getElementById('img_editar');
        idImg.src = urlImg;
    }//end if no hay imagen cargada
});//end onclick sexo femenino


$.validator.addMethod("validDate", function (value, element) {
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
$.validator.addMethod("ageMin18", function (value, element) {
    var today = new Date();
    var dob = new Date(value);
    var minAge = 18;

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
}, "Debes tener al menos 18 años.");

$("#formulario-psicologo-editar").validate({
    rules: {
        numero_trabajador_editar: {
            required: true,
            maxlength: 3,
            numeric: true,
            minlength: 1,
        },
        nombre_editar: {
            required: true,
            rangelength: [3, 50]
        },
        ap_paterno_editar: {
            required: true,
            rangelength: [3, 50]
        },
        ap_materno_editar: {
            required: true,
            rangelength: [3, 50]
        },
        email_editar: {
            required: true,
            emailRegex: true,
            email: true,
            rangelength: [5, 70]
        },
        fecha_nacimiento_editar: {
            required: true,
            validDate: true,
            ageMin18: true,
            date: true
        }
    },//end rules
    messages: {
        numero_trabajador_editar: {
            required: 'Se requiere el numero de trabajador del psicólogo.',
            rangelength: 'El numero de trabajador no debe exceder los 3 caracteres.',
            numeric: "Solo se permiten números",
            minlength: "El numero de trabajador no debe tener menos de 1 caracter.",
            maxlength: 'El numero de trabajador no debe exceder los 3 caracteres.'
        },
        nombre_editar: {
            required: 'Se requiere el nombre del psicólogo.',
            rangelength: 'El nombre debe tener entre 3 y 50 caracteres.'
        },
        ap_paterno_editar: {
            required: 'Se requiere el apellido paterno del psicólogo.',
            rangelength: 'El apellido paterno debe tener entre 3 y 50 caracteres.'
        },
        ap_materno_editar: {
            required: 'Se requiere el apellido materno del psicólogo.',
            rangelength: 'El apellido materno debe tener entre 3 y 50 caracteres.'
        },
        email_editar: {
            required: 'Se requiere el correo electrónico del psicólogo.',
            emailRegex: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            email: 'El correo electrónico debe tener el siguiente formato: ejemplo@dominio.com',
            rangelength: 'El correo electrónico no debe exceder los 70 caracteres.'
        },
        fecha_nacimiento_editar: {
            required: 'Se requiere la fecha de nacimiento del psicólogo.',
            validDate: 'Ingrese una fecha de nacimiento válida y que indique al menos 18 años de edad.',
            ageMin18: 'Debes tener al menos 18 años.',
            date: 'Ingrese una fecha válida.'
        }
    },//end messages
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },//end highlight
    unhighlight: function (input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },//end unhighlight
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }//end errorPlacement
});//end validation

//FUNCIONES JS QUE SIRVEN PARA VALIDAR EL CHECKBOX Y RADIO BUTTON
$("#formulario-psicologo-editar").submit(function (event) {
    if ($('.radio-item:checked').length <= 0) {
        event.preventDefault();
        //mensaje_notificacion('Se requiere seleccionar el sexo para el usuario.', WARNING_ALERT, '¡Faltan campos!', 3500, 'toast-bottom-left');
    }//end if no hay ningun radiobutton activo
});

// Limitar la entrada a 2 dígitos
$('#edad').on('input', function () {
    if (this.value.length > 2) {
        this.value = this.value.slice(0, 2);
    }
});

// Prevenir ingreso de más de dos dígitos
$('#edad_editar').on('keypress', function (e) {
    if (this.value.length >= 2) {
        e.preventDefault();
    }
});

$('#numero_trabajador_editar').on('input', function () {
    if (this.value.length > 11) {
        this.value = this.value.slice(0, 3);
    }
});

// Prevenir ingreso de más de dos dígitos
$('#numero_trabajador_editar').on('keypress', function (e) {
    if (this.value.length >= 3) {
        e.preventDefault();
    }
});

//INSERTAR PSICÓLOGO
//================================================================
document.getElementById('formulario-psicologo-editar').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    // Asegúrate de ejecutar tu lógica de validación antes de este punto
    if ($('#formulario-psicologo-editar .is-invalid').length == 0) {
        loader.setLoaderTitle('Actualizando al psicólogo, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se actualiza al psicólogo...');
        loader.openLoader();

        fetch('./editar_psicologo', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-psicologo-editar'))
        })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Ocurrió un error');
                }
                return res.json();
            })
            .then(respuesta => {
                loader.closeLoader();
                mensaje_notificacion(respuesta.mensaje, respuesta.tipo_mensaje, respuesta.titulo, respuesta.timer_message);

                if (respuesta.error === 0) {
                    //Reseteamos los campos básicos
                    // Limpia todos los campos del formulario
                    $('#formulario-psicologo-editar')[0].reset();
                    // Limpia las imágenes de perfil si hay alguna cargada
                    let defaultSrc = $('#img_editar').data('default-src');
                    $('#img_editar').attr('src', defaultSrc);
                    // Limpia cualquier mensaje de retroalimentación
                    $('.invalid-feedback').text('');
                    // Limpia los íconos de los inputs
                    feather.replace();

                    // Eliminar clases de validación de Bootstrap
                    $('#formulario-psicologo-editar .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-psicologo-editar .form-check-input').removeClass('is-valid is-invalid');

                    $('#editar-psicologo').modal('hide');
                    table_psicologos.ajax.reload(null, false);
                }
            })
            .catch(error => {
                loader.closeLoader();
                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al actualizar!', 4000);
            });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});




//==============================================================================
//==================================ON PAGE LOADED==============================
//==============================================================================
$(document).ready(function () {
    $('#cancel-form-create-psicologo').on('click', function () {
        // Limpia todos los campos del formulario
        $('#formulario-psicologo-nuevo')[0].reset();
        // Limpia las imágenes de perfil si hay alguna cargada
        let defaultSrc = $('#img').data('default-src');
        $('#img').attr('src', defaultSrc);
        // Limpia cualquier mensaje de retroalimentación
        $('.invalid-feedback').text('');
        // Limpia los íconos de los inputs
        feather.replace();

        // Eliminar clases de validación de Bootstrap
        $('#formulario-psicologo-nuevo .form-control').removeClass('is-valid is-invalid');
        $('#formulario-psicologo-nuevo .form-check-input').removeClass('is-valid is-invalid');
    });
});

$(document).ready(function () {
    $('#cancel-form-edit-psicologo').on('click', function () {
        // Limpia todos los campos del formulario
        $('#formulario-psicologo-editar')[0].reset();
        // Limpia las imágenes de perfil si hay alguna cargada
        let defaultSrc = $('#img_editar').data('default-src');
        $('#img_editar').attr('src', defaultSrc);
        // Limpia cualquier mensaje de retroalimentación
        $('.invalid-feedback').text('');
        // Limpia los íconos de los inputs
        feather.replace();

        // Eliminar clases de validación de Bootstrap
        $('#formulario-psicologo-nuevo .form-control').removeClass('is-valid is-invalid');
        $('#formulario-psicologo-nuevo .form-check-input').removeClass('is-valid is-invalid');
    });
});


$(document).ready(function () {
    document.getElementById('cancel-form-change-password-psicologo').onclick = function () {
        let clean_elements = { 'password_psicologo': '', 'confirm_password_psicologo': '', 'id_psicologo': '' };
        resetear_formulario('formulario-cambiar-password-psicologo', clean_elements, false);
    };
});