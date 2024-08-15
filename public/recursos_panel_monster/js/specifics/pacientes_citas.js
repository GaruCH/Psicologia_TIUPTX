let loader = new Loader('loader');


//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_citas_table = () => {
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
        { "data": "nombre_psicologo" },
        { "data": "descripcion_cita" },
        { "data": "fecha_cita" },
        { "data": "hora_cita" },
        { "data": "estado_cita" },
        { "data": "acciones" }
    ];
    return instantiateAjaxDatatable('table-citas', './citas/data', 'GET', null, columns_elements, columns_order);
}; //end create_psicologos_table

let table_citas = create_citas_table();

// BOTONES OPCIONES
// =================================================================


$(document).on('click', '.eliminar-cita', function () {
    eliminar_datatable("./citas/eliminar", $(this).attr('id'), '¿Estás seguro de cancelar esta cita?', 'Esta acción es permanente', table_citas);
});//end onclick eliminar-psicologo



//================================================================
//===================SECCIÓN PARA CREAR===========================
//================================================================



// Funciones de validación personalizadas
$.validator.addMethod("diaHabilitado", function (value, element) {
    var isValid = false;
    var fecha = value;
    var psicologoId = $('#id_psicologo').val();

    // Verificación de la fecha antes de validar el formulario
    var date = new Date(fecha);
    var diaNumero = date.getDay() + 1; // 1 (Lunes) a 7 (Domingo)

    $.ajax({
        url: './citas/verificar-fecha/' + diaNumero + '/' + psicologoId,
        method: 'GET',
        dataType: 'json',
        async: false, // Hacer la llamada sincrónica para que complete antes de proceder
        success: function (response) {
            isValid = response.fecha_valida;
        },
        error: function () {
            isValid = false;
        }
    });

    return isValid;
}, "La fecha seleccionada no es válida.");

// Reglas de validación para el formulario
$("#formulario-cita-nueva").validate({
    rules: {
        fecha_cita: {
            required: true,
            diaHabilitado: true
        },
        descripcion: {
            required: true
        },
        hora_cita: {
            required: {
                depends: function (element) {
                    return $('#hora_cita_container').is(':visible');
                }
            }
        }
    },
    messages: {
        fecha_cita: {
            required: "Por favor, selecciona una fecha.",
            diaHabilitado: "La fecha seleccionada no es válida."
        },
        descripcion: {
            required: "Por favor, proporciona una descripción para la cita."
        },
        hora_cita: {
            required: "Por favor, selecciona una hora."
        }
    },
    highlight: function (input) {
        $(input).addClass('is-invalid');
        $(input).removeClass('is-valid');
    },
    unhighlight: function (input) {
        $(input).removeClass('is-invalid');
        $(input).addClass('is-valid');
    },
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }
});

$(document).ready(function () {
    // Establecer la fecha mínima en el campo de fecha
    var today = new Date().toISOString().split('T')[0];
    $('#fecha_cita').attr('min', today);

    $('#fecha_cita').change(function () {
        var fecha = $(this).val();
        var psicologoId = $('#id_psicologo').val();

        if (fecha) {
            var date = new Date(fecha);
            var diaNumero = date.getDay() + 1; // 1 (Lunes) a 7 (Domingo)

            // Verificar si la fecha seleccionada es válida (habilitada)
            $.ajax({
                url: './citas/verificar-fecha/' + diaNumero + '/' + psicologoId,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.fecha_valida) {
                        // Mostrar el campo de hora si la fecha es válida
                        $('#hora_cita_container').show();

                        // Solicitar horas disponibles al servidor
                        $.ajax({
                            url: './citas/horas-disponibles/' + diaNumero + '/' + psicologoId + '/' + fecha,
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                if (response.horas_disponibles) {
                                    var selectHora = $('#hora_cita');
                                    selectHora.empty();
                                    selectHora.append('<option value="">Selecciona una hora</option>');

                                    $.each(response.horas_disponibles, function (index, hora) {
                                        selectHora.append('<option value="' + hora.value + '">' + hora.text + '</option>');
                                    });
                                } else {
                                    alert(response.error);
                                }
                            },
                            error: function (xhr, status, error) {
                                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al obtener las horas disponibles!', 4000);
                            }
                        });
                    } else {
                        // Ocultar el campo de hora si la fecha no es válida
                        $('#hora_cita_container').hide();
                        mensaje_notificacion('Horas no disponibles del psicólogo o psicóloga.', 'warning', '¡Advertencia!', 4000);
                    }
                },
                error: function (xhr, status, error) {
                    mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al verificar la validez de la fecha!', 4000);
                }
            });
        } else {
            // Ocultar el campo de hora si no se selecciona una fecha
            $('#hora_cita_container').hide();
        }
    });
});


// REGISTRAR CITA
//================================================================
document.getElementById('formulario-cita-nueva').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();

    // Inicializar el formulario de validación

    // Asegúrate de ejecutar tu lógica de validación antes de este punto
    if ($('#formulario-cita-nueva .is-invalid').length == 0) {
        loader.setLoaderTitle('Registrando la cita, por favor espere...');
        loader.setLoaderBody('Por favor espere mientras se registra la cita...');
        loader.openLoader();

        fetch('./citas/registrar', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-cita-nueva'))
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
                    // Reseteamos los campos básicos
                    // Limpia todos los campos del formulario
                    $('#formulario-cita-nueva')[0].reset();
                    // Oculta el campo de hora si es visible
                    $('#formulario-cita-nueva').hide();
                    // Limpia cualquier mensaje de retroalimentación
                    $('.invalid-feedback').text('');
                    // Limpia los íconos de los inputs
                    feather.replace();

                    // Eliminar clases de validación de Bootstrap
                    $('#formulario-cita-nueva .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-cita-nueva .form-check-input').removeClass('is-valid is-invalid');

                    $('#nueva-cita').modal('hide');
                    table_citas.ajax.reload(null, false);
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
//==================================ON PAGE LOADED==============================
//==============================================================================


$(document).ready(function () {
    $('#cancel-form-create-cita').on('click', function () {
        // Limpia todos los campos del formulario
        $('#formulario-cita-nueva')[0].reset();

        // Limpia el campo de hora si está visible
        $('#hora_cita').empty();
        $('#hora_cita_container').hide();

        // Limpia cualquier mensaje de retroalimentación
        $('.invalid-feedback').text('');

        // Limpia los íconos de los inputs
        feather.replace();

        // Eliminar clases de validación de Bootstrap
        $('#formulario-cita-nueva .form-control').removeClass('is-valid is-invalid');
        $('#formulario-cita-nueva .form-check-input').removeClass('is-valid is-invalid');
    });
});

