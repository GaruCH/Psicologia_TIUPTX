let loader = new Loader("loader");

//================================================================
//===================SECCIÓN PARA TABLA===========================
//================================================================

// DATATABLE
//================================================================
const create_asignaciones_table = () => {
    columns_elements = [
        {
            targets: [0, 1, 2, 3, 4, 5, 6],
            createdCell: function (td, cellData, rowData, row, col) {
                $(td).addClass("special-cell text-center ");
            },
        },
    ];
    columns_order = [
        { data: "total" },
        { data: "numero_trabajador" },
        { data: "nombre_psicologo" },
        { data: "identificador_paciente" },
        { data: "nombre_paciente" },
        { data: "fecha_asignacion" },
        { data: "acciones" },
    ];
    return instantiateAjaxDatatable(
        "table-asignaciones",
        "./obtener_asignaciones",
        "GET",
        null,
        columns_elements,
        columns_order
    );
}; //end create_horarios_table

let table_asignaciones = create_asignaciones_table();

//==============================================================================
//===================SECCIÓN PARA EDITAR========================================
//==============================================================================

document.getElementById('psicologo').addEventListener('change', function() {
    let selectedValue = this.value;
    let numeroTrabajador = selectedValue.split('|')[1];
    document.getElementById('numero_trabajador').value = numeroTrabajador;
});


$("#formulario-asignacion-editar").validate({
    rules: {
        psicologo: {
            required: true,
        }
    },
    messages: {
        psicologo: {
            required: 'Se requiere seleccionar un psicólogo.'
        }
    },
    highlight: function (input) {
        // Verificar si el campo es de solo lectura
        if (!$(input).attr('readonly')) {
            $(input).addClass('is-invalid');
            $(input).removeClass('is-valid');
        }
    },
    unhighlight: function (input) {
        // Verificar si el campo es de solo lectura
        if (!$(input).attr('readonly')) {
            $(input).removeClass('is-invalid');
            $(input).addClass('is-valid');
        }
    },
    errorPlacement: function (error, element) {
        $(element).next().append(error);
    }
});


// CREAR DATOS DEL MODAL

// =================================================================
$(document).on("click", ".editar-asignacion", function () {
    let button_info = document.getElementById($(this).attr("id"));
    // Esconder el tooltip por si se bugea
    let tooltip_button = bootstrap.Tooltip.getInstance(button_info);
    if (tooltip_button) {
        tooltip_button.hide();
    }

    let id = $(this).attr("id").split("_")[1];

    loader.setLoaderTitle("Cargando datos, por favor espere...");
    loader.setLoaderBody(
        "Por favor espere en lo que se cargan los datos de la asignacion..."
    );
    loader.openLoader();

    fetch("./obtener_asignacion/" + id)
        .then((res) => {
            if (!res.ok) {
                throw new Error("Ocurrió un error");
            }
            return res.json();
        })
        .then((respuesta) => {
            loader.closeLoader();
            if (respuesta.data === -1) {
                mensaje_notificacion(
                    "No existe la asignación buscado ¿Ha seleccionado correctamente el psicólogo?",
                    DANGER_ALERT,
                    "!Error al obtener la asignación¡"
                );
            } else {
                let nombre_paciente =
                    respuesta.data.nombre_paciente +
                    " " +
                    respuesta.data.ap_paterno_paciente +
                    " " +
                    respuesta.data.ap_materno_paciente;

                let identificador;
                if (respuesta.data.id_subcate == 439) {
                    identificador = respuesta.data.matricula;
                } else if (respuesta.data.id_subcate == 426) {
                    identificador = respuesta.data.numero_trabajador_administrativo;
                } else if (respuesta.data.id_subcate == 411) {
                    identificador = respuesta.data.identificador;
                }

                let clean_elements = {
                    numero_trabajador: respuesta.data.numero_trabajador_psicologo,
                    psicologo: respuesta.data.id_psicologo + '|' + respuesta.data.numero_trabajador_psicologo,
                    nombre_paciente: nombre_paciente,
                    identificador: identificador,
                    id_asignacion: respuesta.data.id_asignacion,
                    id_paciente: respuesta.data.id_paciente
                };
                
                resetear_formulario(
                    "formulario-asignacion-editar",
                    clean_elements,
                    true
                );
                

                let modal_edit_asignacion = new bootstrap.Modal(
                    document.getElementById("editar-asignacion")
                );
                modal_edit_asignacion.show();
            }
        })
        .catch((error) => {
            loader.closeLoader();
            mensaje_notificacion(
                "Hubo un error con nuestro servidor. Intente nuevamente, por favor",
                DANGER_ALERT,
                "!Error al obtener la asignacion¡"
            );
        });
});

document.getElementById('formulario-asignacion-editar').addEventListener('submit', event => {
    event.preventDefault();
    event.stopImmediatePropagation();
    
    
    if ($('#formulario-asignacion-editar .is-invalid').length == 0) {
        loader.setLoaderTitle('Insertando la asignación, por favor espere...');
        loader.setLoaderBody('Por favor espere en lo que se inserta la asignación...');
        loader.openLoader();

        fetch('./editar_asignacion', {
            method: 'POST',
            body: new FormData(document.getElementById('formulario-asignacion-editar'))
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
                    $('#formulario-asignacion-editar')[0].reset();
                    // Limpia cualquier mensaje de retroalimentación
                    $('.invalid-feedback').text('');
                    // Limpia los íconos de los inputs
                    feather.replace();

                    // Eliminar clases de validación de Bootstrap
                    $('#formulario-asignacion-editar .form-control').removeClass('is-valid is-invalid');
                    $('#formulario-asignacion-editar .form-check-input').removeClass('is-valid is-invalid');

                    $('#editar-asignacion').modal('hide');
                    table_asignaciones.ajax.reload(null, false);
                }
            })
            .catch(error => {
                loader.closeLoader();
                mensaje_notificacion('Hubo un error con nuestro servidor. Intente nuevamente, por favor.', 'danger', '¡Error al insertar!', 4000);
            });
    } else {
        mensaje_notificacion('Por favor, completa los campos correctamente antes de enviar.', 'warning', '¡Advertencia!', 4000);
    }
});

